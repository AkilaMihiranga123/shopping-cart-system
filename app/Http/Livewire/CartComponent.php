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
        $this->emitTo('cart-count-component', 'refreshComponent');
    }

    public function decreaseQuantity($row_id)
    {
        $product = Cart::instance('cart')->get($row_id);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($row_id, $qty);
        $this->emitTo('cart-count-component', 'refreshComponent');
    }

    public function destroy($row_id)
    {
        Cart::instance('cart')->remove($row_id);
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('success_message', 'Item has been removed');
    }

    public function destroyAll()
    {
        Cart::instance('cart')->destroy();
        $this->emitTo('cart-count-component', 'refreshComponent');
    }

    public function switchToSaveForLater($rowId)
    {
        $item = Cart::instance('cart')->get($rowId);
        Cart::instance('cart')->remove($rowId);
        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('success_message', 'Item has been saved for later');
    }

    public function moveToCart($rowId)
    {
        $item = Cart::instance('saveForLater')->get($rowId);
        Cart::instance('saveForLater')->remove($rowId);
        Cart::instance('cart')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');
        $this->emitTo('cart-count-component', 'refreshComponent');
        session()->flash('s_success_message', 'Item has been moved to cart');
    }

    public function deleteFromSaveForLater($rowId)
    {
        Cart::instance('saveForLater')->remove($rowId);
        session()->flash('s_success_message', 'Item has been removed from save for later');
    }

    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
