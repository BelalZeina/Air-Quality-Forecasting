<?php

namespace App\Livewire;


use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\PaymentLog;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Cart as ModelCart;

class Cart extends Component
{
    public $existingAddresses = [];
    public $selectedAddressId = null;
    public $newAddress = false;

    public $cartItems = [];
    public $couponCode = '';
    public $subtotal = 0;
    public $shipping = 0;
    public $discount = 0;
    public $address_line1;
    public $address_line2;
    public $city;
    public $state;
    public $postal_code;
    public $country;
    public $totalPrice;




    protected $rules = [
        'address_line1' => 'required|string|max:255',
        'address_line2' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:10',
        'country' => 'required|string|max:255',
    ];

    public function toggleNewAddress()
    {
        $this->newAddress = !$this->newAddress; // Toggle the value
    }
    public function mount()
    {
        $this->loadCartItems();
        $this->calculateTotals();
        $this->existingAddresses = Address::where('user_id', Auth::id())->get();
    }

    public function loadCartItems()
    {
        $this->cartItems = auth()->user()->carts()->with('product')->get()->toArray();
    }

    public function updateQuantity($itemId, $quantity)
    {
        $cartItem = ModelCart::where('id', $itemId)->first();
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        $this->loadCartItems(); // Reload cart items after update
        $this->calculateTotals();
        if($this->couponCode){
            $this->applyCoupon();
        }
        $this->dispatch('updateCartCount');
    }

    public function removeItem($itemId)
    {
        ModelCart::destroy($itemId); // Remove item from the database
        $this->loadCartItems(); // Reload cart items after removal
        $this->calculateTotals();
        if($this->couponCode){
            $this->applyCoupon();
        }
        $this->dispatch('updateCartCount');

    }

    public function applyCoupon()
    {
        // Find the coupon in the database
        $coupon = Coupon::where('code', $this->couponCode)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function ($query) {
                $query->where('max_uses', '>', 'used_count') // Check if usage limit hasn't been reached
                    ->orWhereNull('max_uses'); // Unlimited usage allowed
            })
            ->first();

        // Validate if coupon exists and is usable
        if ($coupon) {
            // Check the type of discount: percentage or fixed
            if ($coupon->type === 'percentage') {
                $this->discount = ($coupon->discount / 100) * $this->getSubtotal(); // Apply percentage discount
            } elseif ($coupon->type === 'fixed') {
                $this->discount = $coupon->discount; // Apply fixed amount discount
            }

            // Check to ensure the discount doesn't exceed the subtotal
            if ($this->discount > $this->getSubtotal()) {
                $this->discount = $this->getSubtotal(); // Limit discount to subtotal
            }

            // Increase the used_count for the coupon
            $coupon->increment('used_count');

            // Notify user of success
            $this->dispatch('toast', message: 'Coupon applied successfully', notify:'success');
        } else {
            // No valid coupon found or it has expired/used up
            $this->discount = 0;
            return $this->dispatch(event: 'toast', message: 'Coupon invalid', notify: 'error');
        }

        // Recalculate totals after applying coupon
        // $this->couponCode='';
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        // Get the subtotal (before any discounts)
        $this->subtotal = $this->getSubtotal();

        // Apply discount to the total price
        $this->totalPrice = max($this->subtotal - $this->discount, 0); // Ensure total doesn't go below zero
    }

    public function getSubtotal()
    {
        return array_reduce($this->cartItems, function ($carry, $item) {
            $price=$item['product']['price_after_discount']==0?$item['product']['price']:$item['product']['price_after_discount'];
            return $carry + ($price * $item['quantity']);
        }, 0);
    }


    // Store the order and checkout process
    public function storeOrder()
    {

        if (count($this->cartItems) == 0) {
            return $this->dispatch(event: 'toast', message: 'Cart is empty', notify: 'error');
        }

        // Check if a new address needs to be created
        if ($this->newAddress) {
            // Create a new address and store it in the database
            $newAddress = Address::create([
                'user_id' => auth()->id(),
                'address_line1' => $this->address['address_line1'],
                'address_line2' => $this->address['address_line2'],
                'city' => $this->address['city'],
                'state' => $this->address['state'],
                'postal_code' => $this->address['postal_code'],
                'country' => $this->address['country'],
            ]);

            // Use the new address ID for the order
            $this->selectedAddressId = $newAddress->id;
        }
        if(!$this->selectedAddressId){
            return $this->dispatch(event: 'toast', message: 'must select address', notify: 'error');
        }

        // Create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'address_id' => $this->selectedAddressId,
            'total_amount' => $this->totalPrice,
            'discount_amount' => $this->discount,
            'coupon_code' => $this->couponCode,
            'status' => 'Pending',
        ]);

        // Add items to the order
        foreach ($this->cartItems as $cartItem) {
            $product = Product::find($cartItem['product_id']);
            $newStock = $product->stock - $cartItem['quantity']; // Subtract the quantity from stock
            $product->update(['stock' => $newStock]);
            OrderItems::create([
                'order_id' => $order->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity'],
                'attribute_values' => $cartItem['attribute_values'],
                'price' => $cartItem['product']['price_after_discount'] == 0
                    ? $cartItem['product']['price']
                    : $cartItem['product']['price_after_discount'],
            ]);
        }
        $paymentLog = PaymentLog::create([
            'bill_no' => mt_rand(100000000, 9999999999),
            'owner_id' =>auth()->user()->id,
            'owner_type' =>  get_class(auth()->user()),
            'amount' => calculateTotalCart(),
            'type' => "order",
            'payment_tool' => "Cash",
            'status' => false,
        ]);

        // Clear the cart
        ModelCart::where('user_id', auth()->id())->delete();

        // Recalculate the totals
        $this->loadCartItems();
        $this->calculateTotals();

        // Notify success
        $this->dispatch(event: 'order', message: 'Order placed successfully', notify: 'success');
        $this->dispatch('updateCartCount');

    }



    public function render()
    {
        return view('livewire.cart');
    }
}
