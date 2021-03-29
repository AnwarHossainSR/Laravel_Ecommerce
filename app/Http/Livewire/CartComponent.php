<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;
class CartComponent extends Component
{
    public function increaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty+1;
        Cart::update($rowId,$qty);
    }
    public function decreaseQuantity($rowId)
    {
        $product = Cart::get($rowId);
        $qty = $product->qty-1;
        Cart::update($rowId,$qty);
    }
    public function removeproduct($rowId)
    {
        Cart::remove($rowId);
        \session()->flash('success_message','Item has been removed from cart');
    }
    public function destroyCart()
    {
        Cart::destroy();
        \session()->flash('success_message','All item has been removed from cart');
    }
    
    public function render()
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
