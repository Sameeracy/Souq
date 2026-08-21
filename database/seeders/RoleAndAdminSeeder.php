<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure Roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $sellerRole = Role::firstOrCreate(['name' => 'seller']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // 2. Create or Update Default Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@souq.com'],
            [
                'name' => 'Admin Souq',
                'password' => Hash::make('password'),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // 3. Create or Update Default Demo Seller
        $seller = User::firstOrCreate(
            ['email' => 'seller@souq.com'],
            [
                'name' => 'Elite Souq Seller',
                'password' => Hash::make('password'),
            ]
        );
        if (!$seller->hasRole('seller')) {
            $seller->assignRole('seller');
        }

        // 4. Create or Update Default Demo Buyer
        $buyer = User::firstOrCreate(
            ['email' => 'buyer@souq.com'],
            [
                'name' => 'Ahmed Customer',
                'password' => Hash::make('password'),
            ]
        );
        if (!$buyer->hasRole('user')) {
            $buyer->assignRole('user');
        }

        // 5. Fix any existing users without roles (assign 'user')
        $usersWithoutRoles = User::doesntHave('roles')->get();
        foreach ($usersWithoutRoles as $u) {
            $u->assignRole('user');
        }

        // 6. Seed Sample Products for the Seller if none exist
        if ($seller->products()->count() === 0) {
            $product1 = $seller->products()->create([
                'title' => 'Handcrafted Arabic Coffee Dallah Pot',
                'description' => 'Authentic traditional brass coffee pot with ornate engraving, perfect for Arabic coffee lovers.',
                'price' => 4999.00,
                'image_path' => null,
            ]);
            $product1->options()->create(['name' => 'Size', 'value' => 'Medium (500ml)', 'price' => 4999.00]);
            $product1->options()->create(['name' => 'Size', 'value' => 'Large (1000ml)', 'price' => 6499.00]);
            $product1->options()->create(['name' => 'Finish', 'value' => 'Antique Gold (Pure Brass)', 'price' => 5499.00]);

            $product2 = $seller->products()->create([
                'title' => 'Premium Arabian Oud & Frankincense Set',
                'description' => 'Luxury incense burner bundle with organic Royal Hojari Frankincense and pure Cambodian Oud chips.',
                'price' => 8950.00,
                'image_path' => null,
            ]);
            $product2->options()->create(['name' => 'Set Edition', 'value' => 'Emerald Green & Gold Luxury Box', 'price' => 8950.00]);
            $product2->options()->create(['name' => 'Set Edition', 'value' => 'Matte Black & Copper Deluxe (Includes Extra Oud)', 'price' => 11200.00]);

            $product3 = $seller->products()->create([
                'title' => 'Silk Embroidered Pashmina Shawl',
                'description' => 'Ultra-soft cashmere blend pashmina scarf hand-embroidered with traditional geometric motifs.',
                'price' => 3400.00,
                'image_path' => null,
            ]);
            $product3->options()->create(['name' => 'Color', 'value' => 'Navy Blue']);
            $product3->options()->create(['name' => 'Color', 'value' => 'Burgundy Red']);
            $product3->options()->create(['name' => 'Color', 'value' => 'Ivory Cream']);
        }
    }
}