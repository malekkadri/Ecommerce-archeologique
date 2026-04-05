<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WorkshopFactory extends Factory
{
    protected $model = \App\Models\Workshop::class;

    public function definition()
    {
        $title = 'Atelier ' . $this->faker->unique()->words(3, true);
        $start = now()->addDays(rand(2, 60));
        return [
            'category_id' => Category::inRandomOrder()->value('id'),
            'title' => $title,
            'slug' => Str::slug($title),
            'summary' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'location' => 'Tunis',
            'starts_at' => $start,
            'ends_at' => (clone $start)->addHours(3),
            'capacity' => 20,
            'reserved_count' => 0,
            'price' => $this->faker->randomFloat(2, 0, 150),
            'is_featured' => $this->faker->boolean(30),
        ];
    }
}
