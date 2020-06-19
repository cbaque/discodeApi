<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // User::truncate();
        User::create([
            'username' => 'admin2020',
            'contrasenia' => Hash::make('admin2020'),
            'email' => 'admin@admin.com',
        ]);
    }
}
