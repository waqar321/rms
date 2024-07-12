<div>
    <div class="form-group">
        <label for="name" class="col-form-label text-md-right">
            Product name
        </label>
        <div>
            <input wire:model="product.name" type="text"
                   class="form-control @error('product.name') is-invalid @enderror"/>
            @error('product.name')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="description" class="col-form-label text-md-right">
            Product description
        </label>
        <div wire:ignore>
            <textarea data-description="@this"
                      wire:model.defer="product.description"
                      class="form-control @error('product.description') is-invalid @enderror"
                      id="description"
                      name="description"></textarea>
        </div>
        @error('product.description')
            <span style="font-size: 11px; color: #e3342f">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button wire:click="submitForm" type="submit" class="btn btn-primary">
                Save Product
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
    <script>
        var ready = (callback) => {
            if (document.readyState != "loading") 
            {
                callback();
            }        
            else 
            {
                document.addEventListener("DOMContentLoaded", callback);
            }
        }
        ready(() =>{
            ClassicEditor
                .create(document.querySelector('#description'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('product.description', editor.getData());
                    })
                    Livewire.on('reinit', () => {
                        editor.setData('', '')
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        })
    </script>
@endpush