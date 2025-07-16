<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new User();
        $admin->name = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = Hash::make('rahasia');
        $admin->role = 'admin';
        $admin->save();

        $user = new User();
        $user->name = 'user';
        $user->email = 'user@gmail.com';
        $user->password = Hash::make('rahasia');
        $user->role = 'user';
        $user->save();

        $user = new User();
        $user->name = 'user';
        $user->email = 'author@gmail.com';
        $user->password = Hash::make('rahasia');
        $user->role = 'author';
        $user->save();
    }
}
