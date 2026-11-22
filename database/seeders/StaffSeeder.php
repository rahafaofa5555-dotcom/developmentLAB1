<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        // updateOrCreate so the seeder can run twice without a "unique" error.
        // The 'hashed' cast on the Staff model hashes the password.
        Staff::updateOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'Admin',
            'password' => '12345678',
            'phone_number' => '1434567890',
            'role' => 'admin',
        ]);

        // A non-admin, to test Task 10 (should get 403 on POST /api/staff)
        Staff::updateOrCreate(['email' => 'librarian@gmail.com'], [
            'name' => 'Librarian',
            'password' => '12345678',
            'phone_number' => '1434567891',
            'role' => 'librarian',
        ]);
    }
}
