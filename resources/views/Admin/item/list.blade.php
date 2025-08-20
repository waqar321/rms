
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
                    <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Item Name...">
                </div>
                @include('Admin.partial.livewire.ClearDeleteButtons', ['showDeleteButton' => 'false', 'modelName' => 'category'])

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
                                    @forelse($Items as $item)
                                        <tr>

                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name  }}</td>
                                            <td>{{ $item->order  }}</td>
                                            <td>{{ $item->Category->name ?? 'No Category' }}</td>
                                            <td>{{ $item->description  }}</td>
                                            <td>{{ $item->cost_price  }}</td>
                                            <td>{{ $item->price  }}</td>
                                            <td>{{ $item->stock_quantity  }}</td>
                                            <td>{{ $item->unit_type->name ?? '' }}</td>
                                            <td>
                                                @if($item->is_pos_product == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updatePOS({{ $item->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updatePOS({{ $item->id }}, 1)"></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->is_item_purchasing_product == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateItemPurchasing({{ $item->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateItemPurchasing({{ $item->id }}, 1)"></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->image_path)
                                                    <img src="{{ asset('/storage/'.$item->image_path) }}" style="width: 70px; height: 45px;" class="me-4" alt="Img">
                                                @endif
                                            </td>
                                            <td>{{ $item->user->name  }}</td>
                                            <td>
                                                @if($item->is_active == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $item->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $item->id }}, 1)"></span>
                                                @endif
                                            </td>
                                            <td>
                                                <a data-screen-item-id="23" wire:click="EditData({{ $item->id }})" class="btn btn-primary">Edit</a>
                                                <button data-screen-item-id="24" onclick="confirmDelete('{{ $item->id }}')" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12" class="text-center"> <h2> No  Record Found!!! </h2></td>
                                        </tr>
                                    @endforelse
                                @endif

                                @include('Admin.partial.livewire.loadingData')

                            </tbody>
                        </table>

                        @include('Admin.partial.livewire.pagination', ['ModelListing' => $Items, 'Model' => 'categoryListing'])

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
