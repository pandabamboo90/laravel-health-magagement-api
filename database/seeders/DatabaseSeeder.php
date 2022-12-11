<?php

namespace Database\Seeders;

use App\Models\Exercise;
use App\Models\ExerciseHistory;
use App\Models\Meal;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory()->create();

        // Body info
        $user->bodyInfo()->create([
            'height' => 180,
            'weight' => 70,
            'fat_percent' => 15,
        ]);

        // Diaries
        for ($i = 0; $i < 30; $i++) {
            $user->diaries()->create([
                'content' => fake()->paragraph(),
            ]);
        }

        // Exercise
        for ($i = 0; $i < 10; $i++) {
            $exercise = new Exercise();
            $exercise->fill([
                'name' => fake()->name(),
                'level' => fake()->randomElement(Exercise::LEVEL),
            ]);
            $exercise->save();
        }

        // Exercise Histories
        for ($i = 0; $i < 20; $i++) {
            $exerciseHistory = new ExerciseHistory();
            $randomExercise = Exercise::inRandomOrder()->first();

            $exerciseHistory->fill([
                'user_id' => $user->id,
                'exercise_id' => $randomExercise->id,
                'status' => fake()->randomElement(ExerciseHistory::STATUS),
            ]);
            $exerciseHistory->save();
        }

        // Meals
        for ($i = 0; $i < 14; $i++) {
            $user->meals()->create([
                'meal_type' => fake()->randomElement(Meal::MEAL_TYPE),
                'thumbnail_img_url' => fake()->imageUrl()
            ]);
        }

        // Tag
        for ($i = 0; $i < 10; $i++) {
            $tag = new Tag();
            $tag->fill([
                'name' => fake()->text(10)
            ]);
            $tag->save();
        }

        // Post
        for ($i = 0; $i < 30; $i++) {
            $post = new Post();
            $post->fill([
                'title' => fake()->text(),
                'thumbnail_img_url' => fake()->imageUrl(),
                'content' => fake()->paragraph(),
                'recommended' => fake()->boolean()
            ]);
            $post->save();

            // Posts <-> Tags
            $randomTags = Tag::inRandomOrder()->limit(fake()->numberBetween(1, 3))->get();
            $post->tags()->sync($randomTags);
        }
    }
}
