<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContentFactory extends Factory
{
    protected $model = \App\Models\Content::class;

    public function definition()
    {
        $title = 'Recette ' . $this->faker->unique()->words(3, true);
        return [
            'author_id' => User::factory(),
            'category_id' => Category::inRandomOrder()->value('id'),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(4, true),
            'type' => $this->faker->randomElement(['recipe', 'article', 'tradition', 'ingredient', 'nutrition']),
            'is_featured' => $this->faker->boolean(30),
            'published_at' => now(),
        ];
    }
}
