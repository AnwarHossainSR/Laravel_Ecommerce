<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Cart;

class DetailsComponent extends Component
{
    public $slug;
    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function cartStore($pId,$pName,$pPrice)
    {
        Cart::add($pId,$pName,1,$pPrice)->associate('App\Models\Product');
        \session()->flash('success_message','Product added in cart');
        return \redirect()->route('product.cart');
    }

    public function render()
    {
        $product = Product::where('slug',$this->slug)->first();
        $popular_product = Product::inRandomOrder()->limit(4)->get();
        $related_product = Product::where('category_id',$product->category_id)->inRandomOrder()->limit(8)->get();
        return view('livewire.details-component',\compact('product','popular_product','related_product'))->layout('layouts.base');
    }
}
