<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Chef;
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

        // Settings (Saskatchewan, Canada)
        Setting::set('delivery_fee', '8', 'number', 'Delivery fee in CAD');
        Setting::set('contact_phone', '+1 (306) 555-5485', 'string', 'Contact phone number');
        Setting::set('contact_email', 'orders@liluskitchen.com', 'string', 'Contact email');
        Setting::set('pickup_address', '123 Broadway Ave, Saskatoon, SK S7N 1B3', 'string', 'Pickup location address');
        Setting::set('operating_hours', 'Mon-Sat: 11:00 AM - 9:00 PM | Sun: 12:00 PM - 8:00 PM', 'string', 'Operating hours');
        Setting::set('etransfer_email', 'payments@liluskitchen.com', 'string', 'Interac e-Transfer email');

        // Categories
        $mains = Category::firstOrCreate(['slug' => 'mains'], ['name' => 'Mains', 'sort_order' => 1]);
        $appetizers = Category::firstOrCreate(['slug' => 'appetizers-sides'], ['name' => 'Appetizers & Sides', 'sort_order' => 2]);
        $soups = Category::firstOrCreate(['slug' => 'soups-salads'], ['name' => 'Soups & Salads', 'sort_order' => 3]);
        $desserts = Category::firstOrCreate(['slug' => 'desserts'], ['name' => 'Desserts', 'sort_order' => 4]);
        $beverages = Category::firstOrCreate(['slug' => 'beverages'], ['name' => 'Beverages', 'sort_order' => 5]);

        // ===== MAINS =====
        MenuItem::firstOrCreate(
            ['name' => 'Chicken Parmesan'],
            [
                'category_id' => $mains->id,
                'description' => 'Crispy breaded chicken breast topped with marinara sauce and melted mozzarella, served with spaghetti.',
                'price' => 18.99,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Beef Stroganoff'],
            [
                'category_id' => $mains->id,
                'description' => 'Tender strips of beef in a creamy mushroom sauce, served over egg noodles with fresh herbs.',
                'price' => 21.99,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Grilled Atlantic Salmon'],
            [
                'category_id' => $mains->id,
                'description' => 'Fresh salmon fillet grilled to perfection with lemon dill butter, served with roasted vegetables.',
                'price' => 24.99,
                'is_available' => true,
                'sort_order' => 3,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Butter Chicken'],
            [
                'category_id' => $mains->id,
                'description' => 'Tender chicken in a rich, creamy tomato-based sauce with aromatic spices, served with basmati rice and naan.',
                'price' => 17.99,
                'is_available' => true,
                'sort_order' => 4,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'BBQ Back Ribs'],
            [
                'category_id' => $mains->id,
                'description' => 'Slow-smoked pork back ribs glazed with our house-made BBQ sauce, served with coleslaw and fries.',
                'price' => 23.99,
                'is_available' => true,
                'sort_order' => 5,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Pasta Primavera'],
            [
                'category_id' => $mains->id,
                'description' => 'Penne pasta tossed with seasonal vegetables in a light garlic cream sauce, topped with parmesan.',
                'price' => 15.99,
                'is_available' => true,
                'sort_order' => 6,
            ]
        );

        // ===== APPETIZERS & SIDES =====
        MenuItem::firstOrCreate(
            ['name' => 'Perogies (8 pcs)'],
            [
                'category_id' => $appetizers->id,
                'description' => 'Traditional potato and cheddar perogies pan-fried golden, served with sour cream and caramelized onions.',
                'price' => 12.99,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Crispy Chicken Wings'],
            [
                'category_id' => $appetizers->id,
                'description' => 'One pound of crispy wings tossed in your choice of sauce: Buffalo, Honey Garlic, or Salt & Pepper.',
                'price' => 14.99,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Garlic Cheese Bread'],
            [
                'category_id' => $appetizers->id,
                'description' => 'Toasted artisan bread with roasted garlic butter and melted three-cheese blend.',
                'price' => 9.99,
                'is_available' => true,
                'sort_order' => 3,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Vegetable Spring Rolls (4 pcs)'],
            [
                'category_id' => $appetizers->id,
                'description' => 'Crispy rolls filled with cabbage, carrots, and glass noodles, served with sweet chili dipping sauce.',
                'price' => 10.99,
                'is_available' => true,
                'sort_order' => 4,
            ]
        );

        // ===== SOUPS & SALADS =====
        MenuItem::firstOrCreate(
            ['name' => 'French Onion Soup'],
            [
                'category_id' => $soups->id,
                'description' => 'Classic caramelized onion soup topped with crusty bread and melted Gruyère cheese.',
                'price' => 9.99,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Caesar Salad'],
            [
                'category_id' => $soups->id,
                'description' => 'Crisp romaine lettuce with house-made Caesar dressing, parmesan shavings, and garlic croutons.',
                'price' => 11.99,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Garden Salad'],
            [
                'category_id' => $soups->id,
                'description' => 'Fresh mixed greens with cherry tomatoes, cucumber, red onion, and balsamic vinaigrette.',
                'price' => 8.99,
                'is_available' => true,
                'sort_order' => 3,
            ]
        );

        // ===== DESSERTS =====
        MenuItem::firstOrCreate(
            ['name' => 'Saskatoon Berry Pie'],
            [
                'category_id' => $desserts->id,
                'description' => 'A Saskatchewan classic! Flaky pastry filled with wild Saskatoon berries, served warm with vanilla ice cream.',
                'price' => 9.99,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'New York Cheesecake'],
            [
                'category_id' => $desserts->id,
                'description' => 'Creamy baked cheesecake with a graham cracker crust, topped with fresh strawberry compote.',
                'price' => 10.99,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Tiramisu'],
            [
                'category_id' => $desserts->id,
                'description' => 'Classic Italian dessert with espresso-soaked ladyfingers layered with mascarpone cream and cocoa.',
                'price' => 11.99,
                'is_available' => true,
                'sort_order' => 3,
            ]
        );

        // ===== BEVERAGES =====
        MenuItem::firstOrCreate(
            ['name' => 'Fresh Squeezed Lemonade'],
            [
                'category_id' => $beverages->id,
                'description' => 'Hand-squeezed lemonade with a hint of mint. Perfectly refreshing.',
                'price' => 4.99,
                'is_available' => true,
                'sort_order' => 1,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Iced Tea'],
            [
                'category_id' => $beverages->id,
                'description' => 'House-brewed iced tea with lemon. Available sweetened or unsweetened.',
                'price' => 3.99,
                'is_available' => true,
                'sort_order' => 2,
            ]
        );

        MenuItem::firstOrCreate(
            ['name' => 'Berry Smoothie'],
            [
                'category_id' => $beverages->id,
                'description' => 'Blended Saskatoon berries, strawberries, banana, and yogurt. A prairie favourite.',
                'price' => 7.99,
                'is_available' => true,
                'sort_order' => 3,
            ]
        );

        // ===== CHEFS =====
        Chef::firstOrCreate(
            ['name' => 'Sarah Mitchell'],
            [
                'title' => 'Head Chef',
                'bio' => 'With over 15 years of culinary experience across Western Canada, Chef Sarah brings farm-to-table passion to every dish. Her specialty is blending traditional prairie flavours with modern techniques.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        Chef::firstOrCreate(
            ['name' => 'James Whitecalf'],
            [
                'title' => 'Pastry Chef',
                'bio' => 'A proud Saskatchewan native, James trained at the Canadian Food & Wine Institute. He\'s known for his incredible Saskatoon berry desserts and artisan breads that keep customers coming back.',
                'sort_order' => 2,
                'is_active' => true,
            ]
        );
    }
}
