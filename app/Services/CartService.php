<?php

namespace App\Services;

use App\Models\MenuItem;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected const SESSION_KEY = 'cart';

    public function getItems(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function add(int $menuItemId, int $quantity = 1): void
    {
        $cart = $this->getItems();
        
        if (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity'] += $quantity;
        } else {
            $menuItem = MenuItem::findOrFail($menuItemId);
            $cart[$menuItemId] = [
                'id' => $menuItem->id,
                'name' => $menuItem->name,
                'price' => (float) $menuItem->price,
                'image' => $menuItem->image,
                'quantity' => $quantity,
            ];
        }
        
        Session::put(self::SESSION_KEY, $cart);
    }

    public function update(int $menuItemId, int $quantity): void
    {
        $cart = $this->getItems();
        
        if ($quantity <= 0) {
            $this->remove($menuItemId);
            return;
        }
        
        if (isset($cart[$menuItemId])) {
            $cart[$menuItemId]['quantity'] = $quantity;
            Session::put(self::SESSION_KEY, $cart);
        }
    }

    public function remove(int $menuItemId): void
    {
        $cart = $this->getItems();
        unset($cart[$menuItemId]);
        Session::put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function getCount(): int
    {
        $cart = $this->getItems();
        return array_sum(array_column($cart, 'quantity'));
    }

    public function getSubtotal(): float
    {
        $cart = $this->getItems();
        $subtotal = 0;
        
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        return $subtotal;
    }

    public function isEmpty(): bool
    {
        return empty($this->getItems());
    }

    public function getCartDetails(): array
    {
        $items = $this->getItems();
        $subtotal = $this->getSubtotal();
        
        return [
            'items' => $items,
            'count' => $this->getCount(),
            'subtotal' => $subtotal,
        ];
    }
}
