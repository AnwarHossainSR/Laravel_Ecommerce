<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
class CategoryComponent extends Component
{
    public $sorting;
    public $pagesize;
    public $category_slug;

    public function mount($category_slug)
    {
        $this->sorting = 'default';
        $this->pagesize = 12;
        $this->category_slug=$category_slug;
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
        $category = Category::where('slug',$this->category_slug)->first();
        $category_name = $category->name;
        if ($this->sorting === 'date') {
            $products = Product::where('category_id',$category->id)->orderBy('created_at','DESC')->paginate($this->pagesize);
        } else if($this->sorting === 'price') {
            $products = Product::where('category_id',$category->id)->orderBy('regular_price','ASC')->paginate($this->pagesize);
        } else if($this->sorting === 'price-desc') {
            $products = Product::where('category_id',$category->id)->orderBy('regular_price','DESC')->paginate($this->pagesize);
        }else{
            $products = Product::where('category_id',$category->id)->paginate($this->pagesize);
        }
        $categories = Category::all();
        return view('livewire.category-component',compact('products','productsAll','categories','category_name'))->layout('layouts.base');
    }
}

