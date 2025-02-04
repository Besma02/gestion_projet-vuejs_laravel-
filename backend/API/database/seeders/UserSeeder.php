<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin=User::create([
            "name"=>"admin",
            "email"=>"admin@admin.com",
            "password"=>Hash::make('password')
        ]);
        $chefDev=User::create([
            "name"=>"chefDev",
            "email"=>"chefDev@chefDev.com",
            "password"=>Hash::make('password')
        ]);
        $user=User::create([
            "name"=>"user",
            "email"=>"user@user.com",
            "password"=>Hash::make('password')
        ]);
        $admin->roles()->attach([1,2]);
        $chefDev->roles()->attach([2]);
        $user->roles()->attach([3]);
    }
}
