<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class CartComponent extends Component
{
    public function increaseQuantity($row_id)
    {
        $product = Cart::instance('cart')->get($row_id);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($row_id, $qty);
    }

    public function decreaseQuantity($row_id)
    {
        $product = Cart::instance('cart')->get($row_id);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($row_id, $qty);
    }

    public function destroy($row_id)
    {
        Cart::instance('cart')->remove($row_id);
        session()->flash('success_message', 'Item has been removed');
    }

    public function destroyAll()
    {
        Cart::instance('cart')->destroy();
    }

    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
