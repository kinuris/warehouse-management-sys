<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\EmployeeRole;
use App\Models\ItemOverhead;
use App\Models\Product;
use App\Models\SystemRole;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin_role = SystemRole::query()->create([
            'name' => 'admin',
        ]);

        $role = SystemRole::query()->create([
            'name' => 'manager',
        ]);

        SystemRole::query()->create([
            'name' => 'employee',
        ]);

        $emp_role = EmployeeRole::query()->create([
            'name' => 'management'
        ]);

        EmployeeRole::query()->create([
            'name' => 'driver'
        ]);

        EmployeeRole::query()->create([
            'name' => 'receiver'
        ]);

        EmployeeRole::query()->create([
            'name' => 'laborer'
        ]);

        $categories = [
            "Seeds and Plants",
            "Fertilizers and Soil Amendments",
            "Pesticides and Herbicides",
            "Irrigation Equipment",
            "Farm Machinery and Tools",
            "Animal Feed and Supplements",
            "Storage and Packaging",
            "Protective Gear and Clothing",
            "Greenhouse Supplies",
            "Miscellaneous Supplies"
        ];

        foreach ($categories as $category) {
            Category::query()->create(['name' => $category]);
        }

        // NOTE: Manager account
        User::create([
            'first_name' => 'Seed',
            'middle_name' => null,
            'last_name' => 'User',
            'email' => 'wms@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '09508710378',
            'system_role_id' => $role->id,
            'employee_role_id' => $emp_role->id,
        ]);

        // NOTE: Admin account
        User::create([
            'first_name' => 'Seed',
            'middle_name' => null,
            'last_name' => 'User',
            'email' => 'adm@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '09508710377',
            'system_role_id' => $admin_role->id,
            'employee_role_id' => $emp_role->id,
        ]);

        Product::factory(50)->create();
        function generateRandomFloat($min, $max)
        {
            return $min + mt_rand() / mt_getrandmax() * ($max - $min);
        }

        foreach (Product::all() as $product) {
            $base = generateRandomFloat(100, 30);
            $profit = generateRandomFloat(100, 30);

            ItemOverhead::query()->create([
                'base' => $base,
                'profit' => $profit,
                'product_id' => $product->id,
            ]);
        }
    }
}
