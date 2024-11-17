<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Livewire\Component;
use Livewire\Features\SupportAttributes\AttributeCollection;
class ShowProduct extends Component
{
    public $product;
    public $quantity = 1;
    public AttributeCollection $attributes ;


    // Mount method to load product data when the component is initialized
    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);

        // Initialize default attribute values
        if ($this->product->attributes()->get() && $this->product->attributes()->count()) {
            foreach ($this->product->attributes()->get() as $attribute) {
                // Set default attribute value (first one in the list)
                $this->attributes[$attribute->id] = $attribute->values->first()->id ?? null;
            }
        }
    }

    public function increaseQuantity()
    {
        $this->quantity++;
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        // Validate input (ensuring at least quantity and attributes are set)
        $this->validate([
            'quantity' => 'required|integer|min:1',
            'attributes' => 'nullable|array',
        ]);

        $product = $this->product;

        if ($product) {
            // Check stock availability
            if ($product->stock <= 0 || $this->quantity > $product->stock) {
                return $this->dispatch('toast', message: 'Product Not Available Now',  notify: 'error');
            }

            // Get product price (discounted or original)
            $price = $product->price_after_discount != 0 ? $product->price_after_discount : $product->price;
        // Process selected attributes
        $selectedAttributeIds = [];
            // Check if the product has attributes and calculate the total price
            if (!empty($this->attributes)) {
                foreach ($this->attributes as $attributeId => $valueId) {
                    $selectedAttributeIds[] = $valueId;
                    // You may want to add attribute price to the product price if applicable
                    $attributeValue = ProductAttributeValue::find($valueId);
                    if ($attributeValue) {
                        $price += $attributeValue->price;
                    }
                }
            }

            // Get authenticated user
            $user = \Auth::user();

            // Check if the product with the same attributes already exists in the cart
            $cart = Cart::where([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'attribute_values' => !empty($selectedAttributeIds) ? json_encode($selectedAttributeIds) : null
            ])->first();

            if ($cart) {
                // Update the cart with new quantity and price
                $cart->update([
                    'quantity' => $cart->quantity + $this->quantity,
                    'price' => $price,
                ]);
                $this->dispatch('updateCartCount');
                return $this->dispatch('toast', message: 'Quantity increased successfully.', notify: 'success');
            } else {
                // Create new cart entry
                Cart::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => $this->quantity,
                    'price' => $price,
                    'attribute_values' => !empty($selectedAttributeIds) ? json_encode($selectedAttributeIds) : null
                ]);
                $this->dispatch('updateCartCount');
                return $this->dispatch('toast', message: 'Product added to cart successfully.', notify: 'success');
            }
        } else {
            // Product not found or an error occurred
            return $this->dispatch('toast', message: 'Product cannot be added to the cart', notify: 'error');
        }

    }

    public function render()
    {
        return view('livewire.show-product');
    }
}
