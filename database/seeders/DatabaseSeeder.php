<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Company;
use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create a default company
        $company = Company::create([
            'name' => 'Default Company',
            'slug' => 'default-company',
            'address' => 'Default Address',
            'phone' => '1234567890',
        ]);

        // Create admin user
        $admin = Admin::create([
            'company_id' => $company->id,
            'name' => 'Admin',
            'email' => 'admin@company.com',
            'password' => Hash::make('secret'),
        ]);

        $this->call([
            GroupSeeder::class,
            MenuSeeder::class,
            PaymentMethodSeeder::class,
        ]);

        // Attach admin to Admin group
        $adminGroup = Group::where('name', 'Admin')->first();
        if ($adminGroup) {
            $admin->groups()->attach($adminGroup->id, [
                'company_id' => $company->id,
                'branch_id' => null,
            ]);
        }
    }
}
