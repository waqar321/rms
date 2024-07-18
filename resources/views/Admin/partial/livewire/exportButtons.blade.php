<div class="d-flex justify-content-end">
        <button
                class="btn btn-primary btn-sm uppercase mr-1 selectingvalue"
                type="button"
                data-export-type="1"
                wire:loading.attr="disabled"
            >
                    Select All 
        </button>
        <button
            class="btn btn-primary btn-sm uppercase mr-1 ExportButtonLivewire"
            type="button"
            data-export-type="csv"
            wire:loading.attr="disabled"
        >
            CSV
        </button>
        <button
            class="btn btn-primary btn-sm uppercase mr-1 ExportButtonLivewire"
            type="button"
            data-export-type="xlsx"
            wire:loading.attr="disabled"
        >
            XLS
        </button>
        <button
            class="btn btn-primary btn-sm uppercase mr-1 ExportButtonLivewire"
            type="button"
            data-export-type="pdf"
            wire:loading.attr="disabled"
        >
            PDF
        </button>
</div>