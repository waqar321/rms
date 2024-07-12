<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductForm extends Component
{
    public Product $product;

    protected array $rules = [
        'product.name' => 'required|min:5',
        'product.description' => 'required|min:30',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.product-form');
    }

    public function submitForm()
    {
        $this->validate();

        $this->product->save();

        return redirect()->route('products.index');
    }
}
