<?php

if (!function_exists('get_cart')) {
    function get_cart()
    {
        $cart = session()->get('cart') ?? [];
        return $cart;
    }
}

if (!function_exists('count_cart')) {
    function count_cart()
    {
        $cart = session()->get('cart') ?? [];
        return count($cart);
    }
}

if (!function_exists('cart_total')) {
    function cart_total()
    {
        $cart = session()->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}