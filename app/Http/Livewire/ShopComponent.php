<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
class ShopComponent extends Component
{
    public function cartStore($pId,$pName,$pPrice)
    {
        Cart::add($pId,$pName,1,$pPrice)->associate('App\Models\Product');
        \session()->flash('success_message','Product added in cart');
        return \redirect()->route('product.cart');
    }
    use WithPagination;
    public function render()
    {
        $productsAll = Product::all();
        $products = Product::paginate(12);
        return view('livewire.shop-component',compact('products','productsAll'))->layout('layouts.base');
    }
}
