<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    protected $model = \App\Models\Course::class;

    public function definition()
    {
        $title = 'Cours ' . $this->faker->unique()->words(3, true);
        return [
            'category_id' => Category::inRandomOrder()->value('id'),
            'title' => $title,
            'slug' => Str::slug($title),
            'summary' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'price' => $this->faker->randomFloat(2, 0, 200),
            'is_published' => true,
            'is_featured' => $this->faker->boolean(25),
        ];
    }
}
