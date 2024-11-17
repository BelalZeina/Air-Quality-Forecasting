<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = Admin::create([
            'name' => 'admin' ,
            'mobile' => '012345678' ,
            'email' => 'admin@yahoo.com' ,
            'img' => null ,
            'password' => bcrypt('password') ,
            'created_at'=>now(),
    ]);
        $owner = User::create([
            'name' => 'admin' ,
            'mobile' => '012345678' ,
            'img' => null ,
            'password' => bcrypt('password') ,
            'created_at'=>now(),
    ]);

    // $owner->syncRoles(['owners' => 1]);

    }
}
