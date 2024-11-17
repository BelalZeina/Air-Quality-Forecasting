<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Product;

class Header extends Component
{
    protected $listeners = ['updateCartCount']; // Listen to emitted events
    public $count_cart = 0;
    public $cart_items = [];
    public $search = ''; // For storing search input
    public $searchResults = []; // For storing search input

    // Lifecycle method to mount component
    public function mount()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->count_cart = $user->carts->count();
            $this->cart_items = $user->carts;

            // Debugging
            \Log::info('Cart count: ' . $this->count_cart);
            \Log::info('Cart items: ', $this->cart_items->toArray());

        } else {
            $this->count_cart = 0;
            $this->cart_items = [];
        }
    }

    // Method to update cart count when 'updateCartCount' event is emitted
    public function updateCartCount()
    {
        $this->mount(); // Reload cart data
    }

    // Method to dynamically load cart data
    // In the loadCartData method
    public function loadCartData()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->count_cart = $user->carts->count();
            $this->cart_items = $user->carts;

            // Debugging
            \Log::info('Cart count: ' . $this->count_cart);
            \Log::info('Cart items: ', $this->cart_items->toArray());

        } else {
            $this->count_cart = 0;
            $this->cart_items = [];
        }
        // $this->render();
    }


    public function deleteCart($id){
        Cart::findOrFail($id)->delete();
        $this->mount();
        return $this->dispatch(event: 'toast', message: 'Product delete from cart successfully.', notify: 'success');
    }

    // Search for products based on the search input
    public function updatedSearch()
    {
        // Example of how to search in the products table by name or description
        $this->searchResults = Product::where(function ($query) {

            $query->where('name', 'LIKE', '%' . $this->search. '%')
                ->orWhere('description', 'LIKE', '%' . $this->search. '%');
        })->get()->take(5);
    }

    public function render()
    {
        return view('livewire.header');
    }
}
