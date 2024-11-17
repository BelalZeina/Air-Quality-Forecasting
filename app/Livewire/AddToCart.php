<?php

namespace App\Livewire;

use App\Models\AttributeValue;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportAttributes\AttributeCollection;

class AddToCart extends Component
{
    public $productId;
    public $quantity = 1;
    public AttributeCollection $attributes; // Use AttributeCollection for attributes

    protected $rules = [
        'productId' => 'nullable|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ];

    public function mount() // Initialize attributes in the mount method
    {
        $this->attributes = new AttributeCollection();
    }

    public function addToCart()
    {
        $this->validate();

        $product = Product::find($this->productId);

        if ($product) {
            if ($product->stock <= 0 || $this->quantity > $product->stock) {
                return sendResponse(404, 'Product Not Available Now');
            }

            $hasAttribute = $product->attributes()->exists();
            $price = $product->price_after_discount != 0 ? $product->price_after_discount : $product->price;
            $defaultAttributeValue=[];
            if ($hasAttribute) {
                // If no attributes provided but the product has attributes, select default ones
                    foreach ($product->attributes()->get() as $attribute) {
                    // Set default attribute value (first one in the list of values)
                    $defaultAttributeValue = $attribute->values->first();
                    if ($defaultAttributeValue) {
                        $this->attributes[] = $defaultAttributeValue->id;
                        // Add the price of the default attribute to the total price
                        $price += $defaultAttributeValue->price;
                    }
                }
            }
            if(auth()->check()){
                $user = Auth::user();
            }else{
                return $this->dispatch(event: 'toast', message: 'you must login before.', notify: 'error');
            }

            // Check if the product with the same attribute values already exists in the cart
            $cart = Cart::where([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'attribute_values' => $this->attributes->isNotEmpty() ? json_encode($this->attributes->toArray()) : null
            ])->first();

            if ($cart) {
                // If the product is already in the cart, increase the quantity
                $cart->update([
                    'quantity' => $cart->quantity + $this->quantity,
                    'price' => $price,
                ]);
                $this->dispatch('updateCartCount');
                $this->attributes = new AttributeCollection();
                return $this->dispatch('toast', message: 'Quantity increased successfully.', notify: 'success');
            } else {
                // If the product is not in the cart, add it
                Cart::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => $this->quantity,
                    'price' => $price,
                    'attribute_values' => $this->attributes->isNotEmpty() ? json_encode($this->attributes->toArray()) : null
                ]);
                $this->attributes = new AttributeCollection();
                $this->dispatch('updateCartCount');
                return $this->dispatch(event: 'toast', message: 'Product added to cart successfully.', notify: 'success');
            }

        } else {
            return $this->dispatch(event: 'toast', message: 'Product cannot be added', notify: 'error');
        }
    }


    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
