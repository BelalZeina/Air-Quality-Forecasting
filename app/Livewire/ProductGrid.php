<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ProductGrid extends Component
{
    use WithPagination  ;
    protected $paginationTheme = 'bootstrap'; // Optional, ensures Bootstrap styling
    protected $queryString = [
        'search' => ['except' => ''], // Correct parameter name
        'page' => ['except' => 1],
        'category_id' => ['except' => ""],
    ];
    public $search ="" ;
    public $page ="" ;
    public $category_id = '';
    public $initialCategoryId;
    public $currentPage;

    public function paginate($page)
    {
        $this->currentPage = $page;
        $this->resetPage(); // Resetting Livewire pagination state
    }

    public function mount($initialCategoryId = null)
    {
        if ($initialCategoryId) {
            $this->category_id = $initialCategoryId;
        }
    }


    public function updated()
    {
        $this->resetPage();
    }



    public function render()
    {
        $query = Product::query();

        // البحث
        if ($this->search) {
                $query->where('name', 'LIKE', '%' . $this->search. '%')
                ->orWhere('description', 'LIKE', '%' . $this->search. '%')
                    ->orWhereHas('categories', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        // فلترة الفئات
        if ($this->category_id) {
            $query->whereHas('categories', function ($q) {
                $q->where('category_id', $this->category_id);
            });
        }

        $products = $query->paginate(9);
        $categories = Category::all();

        return view('livewire.product-grid', compact('products', 'categories'));
    }






}
