<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = ['Cash', 'Transfer BCA', 'Transfer BRI', 'QRIS'];

        foreach ($methods as $method) {
            \App\Models\PaymentMethod::create(['name' => $method]);
        }
    }
}
