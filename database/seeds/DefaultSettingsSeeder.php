<?php

use App\Models\Page;
use App\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DefaultSettingsSeeder extends Seeder
{
    /**
     *
     */
    public function run(){
        factory(User::class)->create([
            'role' => User::ADMIN,
            'name' => env('ADMIN_NAME', 'Admin'),
            'password' => Hash::make((env('ADMIN_PASSWORD', 'qwerty'))),
            'email' => env('ADMIN_EMAIL', 'admin@local.com'),
        ]);

        foreach ($this->name() as $category){
            factory(Category::class)->create([
                "name" => $category,
            ]);

            factory(Page::class)->create([
                "name" => $category,
                "slug" => $category,
            ]);
        }
    }

    public function name()
    {
        return [
            'cars',
            'buildings',
            'others'
        ];
    }
}
