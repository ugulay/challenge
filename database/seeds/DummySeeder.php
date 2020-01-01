<?php

use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Version::class, 5)->create();

        factory(App\Device::class, 10)->create();

        factory(App\Category::class, 5)->create()->each(function ($category) {

            $media = factory(App\Media::class, rand(4, 20))->make();
            $category->media()->saveMany($media);
        });
    }
}
