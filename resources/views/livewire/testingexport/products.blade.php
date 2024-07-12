<div>
    <div class="alert alert-info" role="alert">
        Choose at least one product, and click desired extension to export.
    </div>
    
    <div class="d-flex justify-content-end">
        <button
            class="btn btn-success uppercase mr-1"
            type="button"
            wire:click="export('csv')"
            wire:loading.attr="disabled"
        >
            CSV
        </button>
        <button
            class="btn btn-success uppercase mr-1"
            type="button"
            wire:click="export('xlsx')"
            wire:loading.attr="disabled"
        >
            XLS
        </button>
        <button
            class="btn btn-success uppercase mr-1"
            type="button"
            wire:click="export('pdf')"
            wire:loading.attr="disabled"
        >
            PDF
        </button>
    </div>

    <table class="table table-stripped mt-3">
        <tr>
            <th></th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
        </tr>
        @foreach($products as $product)
            <tr>
                <th>
                    <input type="checkbox" wire:model="selectedProducts.{{ $product->id }}">
                </th>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>${{ $product->price }}</td>
            </tr>
        @endforeach
    </table>
</div>
