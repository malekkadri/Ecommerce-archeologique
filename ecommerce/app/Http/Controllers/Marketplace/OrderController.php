<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Marketplace\CheckoutRequest;
use App\Http\Requests\Marketplace\StoreCartItemRequest;
use App\Http\Requests\Marketplace\UpdateCartItemRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function cart()
    {
        $cartItems = auth()->user()
            ->cartItems()
            ->with('product')
            ->latest()
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return (float) $item->unit_price * (int) $item->quantity;
        });

        return view('marketplace.cart', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
        ]);
    }

    public function storeCartItem(StoreCartItemRequest $request)
    {
        $productId = (int) $request->input('product_id');
        $quantity = (int) $request->input('quantity');
        $product = Product::where('is_active', true)->findOrFail($productId);

        if ($product->stock < $quantity) {
            return back()->with('error', __('messages.insufficient_stock'));
        }

        $item = CartItem::firstOrNew([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        $newQuantity = ((int) $item->quantity ?: 0) + $quantity;

        if ($newQuantity > $product->stock) {
            return back()->with('error', __('messages.insufficient_stock'));
        }

        $item->fill([
            'quantity' => $newQuantity,
            'unit_price' => $product->price,
        ])->save();

        return redirect()->route('cart.index')->with('success', __('messages.item_added_to_cart'));
    }

    public function updateCartItem(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);
        $quantity = (int) $request->input('quantity');

        if (! $cartItem->product || $cartItem->product->stock < $quantity) {
            return back()->with('error', __('messages.insufficient_stock'));
        }

        $cartItem->update([
            'quantity' => $quantity,
            'unit_price' => $cartItem->product->price,
        ]);

        return back()->with('success', __('messages.updated'));
    }

    public function destroyCartItem(CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);
        $cartItem->delete();

        return back()->with('success', __('messages.deleted'));
    }

    public function checkout()
    {
        $cartItems = auth()->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('messages.empty_cart'));
        }

        $subtotal = $cartItems->sum(function ($item) {
            return (float) $item->unit_price * (int) $item->quantity;
        });

        return view('marketplace.checkout', compact('cartItems', 'subtotal'));
    }

    public function placeOrder(CheckoutRequest $request)
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('messages.empty_cart'));
        }

        try {
            $order = DB::transaction(function () use ($user, $cartItems, $request) {
                $subtotal = 0;
                $preparedItems = [];

                foreach ($cartItems as $cartItem) {
                    if (! $cartItem->product || ! $cartItem->product->is_active) {
                        throw new \RuntimeException(__('messages.product_unavailable'));
                    }

                    $product = Product::lockForUpdate()->find($cartItem->product_id);

                    if (! $product || $product->stock < $cartItem->quantity) {
                        throw new \RuntimeException(__('messages.insufficient_stock'));
                    }

                    $lineTotal = (float) $product->price * (int) $cartItem->quantity;
                    $subtotal += $lineTotal;
                    $preparedItems[] = [
                        'product' => $product,
                        'quantity' => (int) $cartItem->quantity,
                        'unit_price' => (float) $product->price,
                        'total_price' => $lineTotal,
                    ];
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'reference' => 'MIDA-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)),
                    'status' => 'confirmed',
                    'payment_status' => 'pending',
                    'payment_method' => 'cash_on_delivery',
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                    'currency' => 'TND',
                    'billing_name' => $request->input('billing_name'),
                    'billing_email' => $request->input('billing_email'),
                    'billing_phone' => $request->input('billing_phone'),
                    'billing_address' => $request->input('billing_address'),
                    'shipping_name' => $request->input('shipping_name'),
                    'shipping_phone' => $request->input('shipping_phone'),
                    'shipping_address' => $request->input('shipping_address'),
                    'notes' => $request->input('notes'),
                ]);

                foreach ($preparedItems as $preparedItem) {
                    $product = $preparedItem['product'];

                    $order->items()->create([
                        'product_id' => $product->id,
                        'vendor_profile_id' => $product->vendor_profile_id,
                        'quantity' => $preparedItem['quantity'],
                        'unit_price' => $preparedItem['unit_price'],
                        'total_price' => $preparedItem['total_price'],
                    ]);

                    $product->decrement('stock', $preparedItem['quantity']);
                }

                $user->cartItems()->delete();

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return redirect()->route('cart.index')->with('error', $exception->getMessage());
        }

        return redirect()->route('orders.confirmation', $order)->with('success', __('messages.order_placed'));
    }

    public function confirmation(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.product');

        return view('marketplace.confirmation', compact('order'));
    }

    private function authorizeCartItem(CartItem $cartItem)
    {
        abort_unless($cartItem->user_id === auth()->id(), 403);
    }
}
