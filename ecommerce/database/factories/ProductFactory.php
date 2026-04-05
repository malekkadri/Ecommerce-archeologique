<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\VendorProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition()
    {
        $name = 'Produit ' . $this->faker->unique()->words(2, true);
        return [
            'vendor_profile_id' => VendorProfile::inRandomOrder()->value('id'),
            'category_id' => Category::inRandomOrder()->value('id'),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 5, 500),
            'stock' => rand(0, 60),
            'is_featured' => $this->faker->boolean(20),
            'is_active' => true,
        ];
    }
}
