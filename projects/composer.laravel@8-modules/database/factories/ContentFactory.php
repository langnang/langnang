<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContentFactory extends Factory
{
    protected $model = \App\Models\Content::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new \DavidBadura\FakerMarkdownGenerator\FakerProvider($this->faker));
        $typeOptions = \App\Models\Option::where('name', 'content.type')->first()->toArray()['value'];
        if (empty($typeOptions)) {
            $typeOptions = \App\Models\Option::where('name', 'global.type')->first()->toArray()['value'];
        }
        $statusOptions = \App\Models\Option::where('name', 'content.status')->first()->toArray()['value'];
        if (empty($statusOptions)) {
            $typeOptions = \App\Models\Option::where('name', 'global.status')->first()->toArray()['value'];
        }
        return [
            // "cid" => $this->faker->randomNumber(),
            "slug" => $this->faker->slug(),
            "ico" => $this->faker->imageUrl(72, 72),

            "title" => $this->faker->sentence(),
            "description" => $this->faker->sentence(),
            "text" => "<!--markdown-->\r\n{$this->faker->markdown()}\r\n<!--more-->\r\n{$this->faker->markdown()}",
            "type" => $this->faker->randomElement(array_keys($typeOptions)),
            "status" => $this->faker->randomElement(array_keys($statusOptions)),

            "template" => 0,
            "views" => 0,
            "count" => 0,
            "order" => 0,
            "parent" => 0,

            "user_id" => 0,

            // "created_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "updated_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "release_at" => $this->faker->date() . ' ' . $this->faker->time(),
            // "deleted_at" => $this->faker->date() . ' ' . $this->faker->time(),
        ];
    }
}
