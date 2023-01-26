<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            'name'=>"avatar.png",
            'path'=>"images/avatar.png",
            'url'=>config('app.url')."/images/avatar.png",
            'type'=>array_flip(Image::TYPES)['user_profile'],
            'created_at'=>now(),
        ]);
    }
}
