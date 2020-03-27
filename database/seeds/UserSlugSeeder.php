<?php

use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Seeder;

class UserSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function ($item) {
            $slug = SlugService::createSlug(User::class, 'slug', $item->name);

            $item->update([
                'slug' => $slug,
            ]);
        });
    }
}
