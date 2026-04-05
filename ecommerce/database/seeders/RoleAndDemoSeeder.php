<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Product;
use App\Models\User;
use App\Models\VendorProfile;
use App\Models\Workshop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleAndDemoSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin MIDA',
            'email' => 'admin@mida.tn',
            'role' => User::ROLE_ADMIN,
            'locale' => 'fr',
        ]);

        $vendorUser = User::factory()->create([
            'name' => 'Vendor MIDA',
            'email' => 'vendor@mida.tn',
            'role' => User::ROLE_VENDOR,
            'locale' => 'fr',
        ]);

        $vendor = VendorProfile::create([
            'user_id' => $vendorUser->id,
            'shop_name' => 'Maison MIDA',
            'slug' => 'maison-mida',
            'description' => 'Artisanat culinaire tunisien premium.',
            'is_approved' => true,
        ]);

        foreach (['Culture','Recettes','Nutrition','Ateliers','Marketplace'] as $name) {
            Category::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'type' => 'content']
            );
        }

        \App\Models\Content::factory()->count(12)->create();
        Course::factory()->count(8)->create()->each(function ($course) {
            for ($i = 1; $i <= 4; $i++) {
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => 'Module ' . $i,
                    'slug' => 'module-' . $i,
                    'content' => 'Contenu pédagogique.',
                    'position' => $i,
                    'duration_minutes' => 20,
                ]);
            }
        });

        Workshop::factory()->count(6)->create();
        Product::factory()->count(14)->create(['vendor_profile_id' => $vendor->id]);
    }
}
