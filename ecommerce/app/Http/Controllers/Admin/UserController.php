<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $items = User::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = trim((string) $request->q);
                $query->where('name', 'like', '%' . $term . '%')->orWhere('email', 'like', '%' . $term . '%');
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.shared-index', [
            'items' => $items,
            'title' => 'Users',
            'routePrefix' => 'admin.users',
            'columns' => [
                ['label' => 'Name', 'key' => 'name'],
                ['label' => 'Email', 'key' => 'email'],
                ['label' => 'Role', 'key' => 'role'],
                ['label' => 'Locale', 'key' => 'locale'],
            ],
        ]);
    }

    public function create()
    {
        return view('admin.shared-form', [
            'title' => 'Create User',
            'routePrefix' => 'admin.users',
            'method' => 'POST',
            'item' => new User(),
            'fields' => $this->fields(),
        ]);
    }

    public function store(Request $request)
    {
        User::create($this->validated($request));

        return redirect()->route('admin.users.index')->with('success', __('messages.saved'));
    }

    public function show(User $user)
    {
        return view('admin.shared-show', [
            'title' => 'User details',
            'routePrefix' => 'admin.users',
            'item' => $user,
            'displayFields' => [
                ['label' => 'Name', 'key' => 'name'],
                ['label' => 'Email', 'key' => 'email'],
                ['label' => 'Role', 'key' => 'role'],
                ['label' => 'Locale', 'key' => 'locale'],
            ],
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.shared-form', [
            'title' => 'Edit User',
            'routePrefix' => 'admin.users',
            'method' => 'PUT',
            'item' => $user,
            'fields' => $this->fields(true),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->update($this->validated($request, $user));

        return redirect()->route('admin.users.edit', $user)->with('success', __('messages.updated'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', __('messages.deleted'));
    }

    private function fields($isEdit = false)
    {
        $fields = [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
            ['name' => 'role', 'label' => 'Role', 'type' => 'select', 'required' => true, 'options' => [
                User::ROLE_USER => 'User',
                User::ROLE_VENDOR => 'Vendor',
                User::ROLE_ADMIN => 'Admin',
            ]],
            ['name' => 'locale', 'label' => 'Locale', 'type' => 'select', 'required' => true, 'options' => [
                'fr' => 'Français',
                'en' => 'English',
                'ar' => 'العربية',
            ]],
            ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'required' => !$isEdit],
            ['name' => 'password_confirmation', 'label' => 'Confirm password', 'type' => 'password', 'required' => !$isEdit],
        ];

        return $fields;
    }

    private function validated(Request $request, ?User $user = null)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns', 'max:255', Rule::unique('users', 'email')->ignore(optional($user)->id)],
            'role' => ['required', Rule::in([User::ROLE_USER, User::ROLE_VENDOR, User::ROLE_ADMIN])],
            'locale' => ['required', Rule::in(['fr', 'en', 'ar'])],
        ];

        if ($user) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $data = $request->validate($rules);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $data;
    }
}
