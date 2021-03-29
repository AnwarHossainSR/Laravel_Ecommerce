<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
class ShopComponent extends Component
{
    public $sorting;
    public $pagesize;

    public function mount()
    {
        $this->sorting = 'default';
        $this->pagesize = 12;
    }

    public function cartStore($pId,$pName,$pPrice)
    {
        Cart::add($pId,$pName,1,$pPrice)->associate('App\Models\Product');
        \session()->flash('success_message','Product added in cart');
        return \back()->route('product.shop');
    }
    use WithPagination;
    public function render()
    {
        $productsAll = Product::all();
        if ($this->sorting === 'date') {
            $products = Product::orderBy('created_at','DESC')->paginate($this->pagesize);
        } else if($this->sorting === 'price') {
            $products = Product::orderBy('regular_price','ASC')->paginate($this->pagesize);
        } else if($this->sorting === 'price-desc') {
            $products = Product::orderBy('regular_price','DESC')->paginate($this->pagesize);
        }else{
            $products = Product::paginate($this->pagesize);
        }
        $categories = Category::all();
        return view('livewire.shop-component',compact('products','productsAll','categories'))->layout('layouts.base');
    }
}
