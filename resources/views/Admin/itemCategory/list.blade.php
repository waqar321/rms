
@push('styles')


    <style>
        .testForm
        {
            display: block !important;
            margin-top: 0em !important;
            unicode-bidi: isolate !important;
            padding-top: 20px;
        }

    </style>
@endpush

<div class="row" data-screen-category-id="22">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-4 col-lg-4">
                    <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Category...">
                </div>
                {{-- <div class="col-md-4 col-lg-4">
                    <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Category...">
                </div> --}}
                <div class="col-md-4 col-lg-4">
                    <div class="form-group" wire:ignore>
                        {{-- <label>Item <span class="danger">*</span></label> --}}
                        <select class="form-control Select2DropDown" data-id="category_type_id" id="category_type_id" name="category_type_id" >
                            <option value="">-- Select Category Type --</option>
                            <option value="pos"> POS </option>
                            <option value="item_purchase"> Item Purchasing </option>
                        </select>
                    </div>
                </div>
                {{-- <div class="col-md-4 col-lg-4">
                    <div class="form-group" wire:ignore>
                        <select class="form-control Select2DropDown" data-id="item_id" id="item_id" name="item_id" >
                            <option value="">-- Select Item --</option>
                            @foreach($items as $item_id => $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                @include('Admin.partial.livewire.ClearDeleteButtons', ['showDeleteButton' => 'true', 'modelName' => 'category'])

                <ul class="nav navbar-right panel_toolbox justify-content-end">
                    <li>
                        <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>

                <div class="clearfix"></div>

            </div>
            <div class="x_content">

                        <!-- <div class="col-lg-4" wire:ignore>
                            <select id="framework" name="framework[]" multiple class="form-control">
                                    @foreach($availableColumns as $column)
                                        @if($column != 'Image' && $column != 'Actions')
                                            <option value="{{ $column }}">{{ ucfirst($column) }}</option>
                                        @endif
                                    @endforeach
                            </select>
                        </div>

                        @include('Admin.partial.livewire.exportButtons')
                        <hr> -->

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <!-- <th> </th> -->
                                    @foreach($availableColumns as $column)
                                            <th>{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @if($readyToLoad)
                                    @forelse($ItemCategorys as $category)
                                        <tr>
                                            <!-- <td>
                                                <input type="checkbox" wire:model="selectedRows.{{ $category->id }}">
                                            </td> -->
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name  }}</td>
                                            <td>{{ $category->order  }}</td>
                                            <td>
                                                @if($category->is_pos_product == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updatePOS({{ $category->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updatePOS({{ $category->id }}, 1)"></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($category->is_item_purchasing_category == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateItemPurchasing({{ $category->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateItemPurchasing({{ $category->id }}, 1)"></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($category->is_active == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $category->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $category->id }}, 1)"></span>
                                                @endif
                                            </td>
                                            <td>
                                                <a data-screen-category-id="23" wire:click="EditData({{ $category->id }})" class="btn btn-primary">Edit</a>
                                                <button data-screen-category-id="24" onclick="confirmDelete('{{ $category->id }}')" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center"> <h2> No User Record Found!!! </h2></td>
                                        </tr>
                                    @endforelse
                                @endif

                                @include('Admin.partial.livewire.loadingData')

                            </tbody>
                        </table>

                        @include('Admin.partial.livewire.pagination', ['ModelListing' => $ItemCategorys, 'Model' => 'categoryListing'])

            </div>
        </div>
    </div>
</div>
</div>


@push('scripts')


<script>
   $(document).ready(function()
   {

        $('#framework').multiselect({
            nonSelectedText: 'Select Framework',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonWidth:'400px'
        });

        // $('.ExportButtonLivewire').on('click', function()
        // {
        //     var selectedColumns = $('#framework').val();
        //     Livewire.emit('selectedColumns', selectedColumns.join(', '), $(this).data('export-type'));
        // });

    });
</script>

@endpush
