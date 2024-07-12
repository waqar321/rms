<?php

namespace App\Http\Livewire\testingExport;

use App\Models\Product;
use Livewire\Component;
use App\Exports\ProductsExport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

// class Products extends Component
class RealisProductsClass extends Component
{
    public Collection $selectedProducts;

    public Collection $products;

    public function mount()
    {
        dd('awd');
        $this->products = Product::with('category')->get();
        $this->selectedProducts = collect();
    }

    public function render()
    {
        return view('livewire.products');
    }

    private function getSelectedProducts()
    {
        return $this->selectedProducts->filter(fn($p) => $p)->keys();
    }

    public function export($ext)
    {
        abort_if(!in_array($ext, ['csv', 'xlsx', 'pdf']), Response::HTTP_NOT_FOUND);
        
        return Excel::download(new ProductsExport($this->getSelectedProducts()), 'products.' . $ext);
    }
}
