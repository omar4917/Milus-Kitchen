<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('0000'),
                'role' => 'admin',
            ]
        );

        // Create Regular User
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => Hash::make('0000'),
                'role' => 'staff',
            ]
        );

        // Settings
        Setting::set('delivery_fee', '50', 'number', 'Delivery fee in BDT');
        Setting::set('contact_phone', '+880 1XXX-XXXXXX', 'string', 'Contact phone number');
        Setting::set('contact_email', 'orders@restaurant.com', 'string', 'Contact email');
        Setting::set('pickup_address', 'House #12, Road #5, Dhanmondi, Dhaka', 'string', 'Pickup location address');
        Setting::set('operating_hours', 'Daily: 10:00 AM - 9:00 PM', 'string', 'Operating hours');
        Setting::set('bkash_instructions', 'Send payment to: 01XXXXXXXXX (Personal). Use your phone number as reference.', 'string', 'bKash payment instructions');
        Setting::set('nagad_instructions', 'Send payment to: 01XXXXXXXXX (Personal). Use your phone number as reference.', 'string', 'Nagad payment instructions');

        // Sample Categories
        $rice = Category::firstOrCreate(['slug' => 'rice-biryani'], ['name' => 'Rice & Biryani', 'sort_order' => 1]);
        $curry = Category::firstOrCreate(['slug' => 'curry-bhuna'], ['name' => 'Curry & Bhuna', 'sort_order' => 2]);
        $snacks = Category::firstOrCreate(['slug' => 'snacks'], ['name' => 'Snacks', 'sort_order' => 3]);
        $desserts = Category::firstOrCreate(['slug' => 'desserts'], ['name' => 'Desserts', 'sort_order' => 4]);

        // Sample Menu Items
        MenuItem::firstOrCreate(
            ['name' => 'Chicken Biryani'],
            [
                'category_id' => $rice->id,
                'description' => 'Aromatic basmati rice layered with tender chicken, saffron, and traditional spices.',
                'price' => 350,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Mutton Biryani'],
            [
                'category_id' => $rice->id,
                'description' => 'Rich and flavorful mutton biryani with caramelized onions and whole spices.',
                'price' => 450,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Vegetable Pulao'],
            [
                'category_id' => $rice->id,
                'description' => 'Fragrant rice cooked with seasonal vegetables and mild spices.',
                'price' => 200,
                'is_available' => true,
                'sort_order' => 3,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Chicken Bhuna'],
            [
                'category_id' => $curry->id,
                'description' => 'Slow-cooked chicken in rich onion and tomato gravy.',
                'price' => 280,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Beef Kala Bhuna'],
            [
                'category_id' => $curry->id,
                'description' => 'Traditional Chittagong-style beef curry with intense flavors.',
                'price' => 380,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Chicken Samosa (4 pcs)'],
            [
                'category_id' => $snacks->id,
                'description' => 'Crispy pastry filled with spiced chicken.',
                'price' => 120,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Vegetable Singhara (6 pcs)'],
            [
                'category_id' => $snacks->id,
                'description' => 'Traditional potato-filled triangular pastries.',
                'price' => 80,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Firni'],
            [
                'category_id' => $desserts->id,
                'description' => 'Creamy ground rice pudding with cardamom and pistachios.',
                'price' => 100,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Phirni (Saffron)'],
            [
                'category_id' => $desserts->id,
                'description' => 'Premium firni with saffron threads and almonds.',
                'price' => 150,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );
    }
}
