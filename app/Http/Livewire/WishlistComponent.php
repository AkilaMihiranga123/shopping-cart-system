<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class WishlistComponent extends Component
{
    public function removeFromWishList($product_id)
    {
        foreach (Cart::instance('wishlist')->content() as $wish_item)
        {
            if ($wish_item->id == $product_id)
            {
                Cart::instance('wishlist')->remove($wish_item->rowId);
                $this->emitTo('wishlist-count-component', 'refreshComponent');
                return;
            }
        }
    }

    public function render()
    {
        return view('livewire.wishlist-component')->layout('layouts.base');
    }
}
