<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ContactInquiry;
use App\Models\Content;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\VendorProfile;
use App\Models\Workshop;
use App\Models\WorkshopBooking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleAndDemoSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            $admin = User::factory()->create([
                'name' => 'Admin MIDA',
                'email' => 'admin@mida.tn',
                'role' => User::ROLE_ADMIN,
                'locale' => 'fr',
            ]);

            $vendors = collect();
            foreach ([
                ['name' => 'Vendor MIDA', 'email' => 'vendor@mida.tn', 'shop' => 'Maison MIDA'],
                ['name' => 'Fatma Ben Salem', 'email' => 'fatma.vendor@mida.tn', 'shop' => 'Epices Fatma'],
                ['name' => 'Hedi Trabelsi', 'email' => 'hedi.vendor@mida.tn', 'shop' => 'Artisans du Sahel'],
            ] as $index => $vendorData) {
                $vendorUser = User::factory()->create([
                    'name' => $vendorData['name'],
                    'email' => $vendorData['email'],
                    'role' => User::ROLE_VENDOR,
                    'locale' => 'fr',
                ]);

                $vendors->push(VendorProfile::create([
                    'user_id' => $vendorUser->id,
                    'shop_name' => $vendorData['shop'],
                    'slug' => Str::slug($vendorData['shop']) . '-' . ($index + 1),
                    'description' => 'Sélection premium de produits tunisiens.',
                    'phone' => '+216 71 000 00' . ($index + 1),
                    'address' => 'Tunis',
                    'is_approved' => true,
                ]));
            }

            $users = User::factory()->count(18)->create(['role' => User::ROLE_USER, 'locale' => 'fr']);

            $categories = [
                ['name' => 'Culture', 'slug' => 'culture', 'type' => 'content'],
                ['name' => 'Recettes', 'slug' => 'recettes', 'type' => 'content'],
                ['name' => 'Nutrition', 'slug' => 'nutrition', 'type' => 'content'],
                ['name' => 'Ateliers', 'slug' => 'ateliers', 'type' => 'workshop'],
                ['name' => 'Marketplace', 'slug' => 'marketplace', 'type' => 'marketplace'],
            ];

            foreach ($categories as $category) {
                Category::updateOrCreate(['slug' => $category['slug']], $category);
            }

            $contentCategory = Category::where('slug', 'culture')->first();
            $courseCategory = Category::where('slug', 'recettes')->first();
            $workshopCategory = Category::where('slug', 'ateliers')->first();
            $productCategory = Category::where('slug', 'marketplace')->first();

            Content::factory()->count(16)->create([
                'author_id' => $admin->id,
                'category_id' => optional($contentCategory)->id,
            ]);

            $courses = Course::factory()->count(9)->create(['category_id' => optional($courseCategory)->id]);
            $courses->each(function ($course) {
                for ($i = 1; $i <= 5; $i++) {
                    Lesson::create([
                        'course_id' => $course->id,
                        'title' => 'Module ' . $i,
                        'slug' => 'module-' . $i,
                        'content' => 'Contenu pédagogique approfondi.',
                        'position' => $i,
                        'duration_minutes' => rand(12, 35),
                    ]);
                }
            });

            $workshops = Workshop::factory()->count(8)->create(['category_id' => optional($workshopCategory)->id]);

            $products = collect();
            foreach ($vendors as $vendor) {
                $products = $products->merge(
                    Product::factory()->count(10)->create([
                        'vendor_profile_id' => $vendor->id,
                        'category_id' => optional($productCategory)->id,
                    ])
                );
            }

            $users->take(10)->each(function ($user) use ($courses) {
                $selectedCourses = $courses->shuffle()->take(rand(1, 3));
                foreach ($selectedCourses as $course) {
                    Enrollment::firstOrCreate([
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                    ], [
                        'status' => 'active',
                        'progress_percent' => rand(5, 95),
                        'enrolled_at' => now()->subDays(rand(1, 80)),
                    ]);
                }
            });

            $users->take(12)->each(function ($user) use ($workshops) {
                $workshop = $workshops->random();
                $seats = rand(1, 3);

                WorkshopBooking::create([
                    'user_id' => $user->id,
                    'workshop_id' => $workshop->id,
                    'seats' => $seats,
                    'status' => 'confirmed',
                    'confirmed_at' => now()->subDays(rand(0, 30)),
                ]);

                $workshop->increment('reserved_count', $seats);
            });

            $users->take(14)->each(function ($user) use ($products) {
                $basket = $products->shuffle()->take(rand(1, 4));
                $subtotal = 0;
                $prepared = [];

                foreach ($basket as $product) {
                    $quantity = min(max(1, rand(1, 3)), max(1, (int) $product->stock));
                    $lineTotal = (float) $product->price * $quantity;
                    $subtotal += $lineTotal;
                    $prepared[] = compact('product', 'quantity', 'lineTotal');
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'reference' => 'MIDA-SEED-' . strtoupper(Str::random(6)),
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                    'currency' => 'TND',
                    'billing_name' => $user->name,
                    'billing_email' => $user->email,
                    'billing_phone' => '+216 55 000 000',
                    'billing_address' => 'Tunis, Tunisie',
                    'shipping_name' => $user->name,
                    'shipping_phone' => '+216 55 000 000',
                    'shipping_address' => 'Tunis, Tunisie',
                ]);

                foreach ($prepared as $row) {
                    $product = $row['product'];
                    $quantity = $row['quantity'];
                    $lineTotal = $row['lineTotal'];

                    $order->items()->create([
                        'product_id' => $product->id,
                        'vendor_profile_id' => $product->vendor_profile_id,
                        'quantity' => $quantity,
                        'unit_price' => $product->price,
                        'total_price' => $lineTotal,
                    ]);
                }
            });

            for ($i = 1; $i <= 12; $i++) {
                $user = $users->random();
                ContactInquiry::create([
                    'user_id' => $user->id,
                    'inquiry_type' => collect(['general', 'collaboration', 'vendor_request'])->random(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'subject' => 'Demande #' . $i . ' sur MIDA',
                    'message' => 'Bonjour, je souhaite obtenir plus d’informations concernant votre service.',
                    'status' => collect(['new', 'in_progress', 'closed'])->random(),
                    'created_at' => now()->subDays(rand(0, 45)),
                ]);
            }
        });
    }
}
