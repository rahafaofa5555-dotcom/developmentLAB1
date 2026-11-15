<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Ahmed Ali',
                'phone_number' => '0501234567',
                'password' => '12345678',
                'balance' => 500,
                'address' => 'Riyadh',
            ],
            [
                'name' => 'Sara Mohammed',
                'phone_number' => '0507654321',
                'password' => '12345678',
                'balance' => 250,
                'address' => 'Jeddah',
            ],
            [
                'name' => 'Omar Khaled',
                'phone_number' => '0509876543',
                'password' => '12345678',
                'balance' => 0,
                'address' => null,
            ],
        ];

        foreach ($customers as $customer) {
            // Password is hashed automatically by the 'hashed' cast on the Customer model.
            Customer::updateOrCreate(
                ['phone_number' => $customer['phone_number']],
                $customer
            );
        }
    }
}
