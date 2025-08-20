
@push('styles')


    <style>
            .zoom-wrapper {
                overflow: visible; /* allow zoom to overflow */
                width: 80px;
                position: relative;
            }

            .zoom-content {
                transition: transform 0.3s ease;
                display: inline-block;
                text-align: center;
                transform-origin: top left; /* ensures it zooms from corner */
            }

            .zoom-wrapper:hover .zoom-content {
                transform: scale(2.5);
                z-index: 999;
                position: absolute;
                background: white;
                padding: 10px;
                border-radius: 6px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.3);
                min-width: 200px; /* ✅ increase the width */
            }


    </style>
@endpush

@can('permission_listing')

<div class="row" data-screen-permission-id="22">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-12 col-lg-12">
                    <div class="col-md-4 col-lg-4">
                        <input type="search" wire:model="searchByID" class="form-control" placeholder="Enter Receipt Number...">
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <input type="search" wire:model="searchByItemName" class="form-control" placeholder="Enter Item Name...">
                    </div>
                    <div class="col-md-4 col-lg-4">
                        {{-- <label for="expiry_date">Payment From:</label> --}}
                        <input type="date" class="form-control" wire:model.debounce.500ms="payment_from" id="name" class="form-control">
                    </div>

                </div>
                <div class="col-md-12 col-lg-12">
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group" wire:ignore>
                            {{-- <label>Item <span class="danger">*</span></label> --}}
                            <select class="form-control Select2DropDown" data-id="item_id" id="item_id" name="item_id" >
                                <option value="">-- Select Item --</option>
                                    @foreach($items as $item_id => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="form-group" wire:ignore>
                            {{-- <label>category <span class="danger">*</span></label> --}}
                            <select class="form-control Select2DropDown" data-id="category_id" id="category_id" name="category_id" >
                                <option value="">-- Select category --</option>
                                    @foreach($categories as $item_id => $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        {{-- <label for="payment_date">Payment To:  </label> --}}
                        <input type="date" class="form-control" wire:model.debounce.500ms="payment_to" id="name" class="form-control">
                    </div>
                </div>
                {{-- <div class="col-md-4 col-lg-4">
                    <input type="search" wire:model="searchByItem" class="form-control" placeholder="Enter Item Name...">
                </div> --}}

                @include('Admin.partial.livewire.ClearDeleteButtons', ['showDeleteButton' => 'false', 'modelName' => 'Permission'])

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


                        <div class="container-fluid" style="margin-left: 13px; padding-top: 10px;">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <button class="btn btn-info btn-sm uppercase mr-1" type="button"> Total Sale:
                                        @if($readyToLoad)
                                            @if($searchByItem_id != null || $searchByCategory_id != null || $searchByItemName != null)
                                                {{ $total_item_sale }}
                                            @else
                                                {{ $Receipts->getCollection()->sum('total_amount') }}
                                            @endif
                                        @endif
                                    </button>

                                        @if($readyToLoad)
                                            @if($searchByItem_id != null || $searchByCategory_id != null)
                                               <button class="btn btn-info btn-sm uppercase mr-1" type="button"> Quantity: {{ $total_quantity }} </button>
                                            @endif
                                        @endif

                                    <button class="btn btn-info btn-sm uppercase mr-1" type="button"> Total Expense:
                                        @if($readyToLoad)
                                            {{ $Expenses->sum('amount') }}
                                        @endif
                                    </button>
                                    <button class="btn btn-info btn-sm uppercase mr-1" type="button"> Remaining Amount:
                                        @if($readyToLoad)
                                            {{ $Receipts->sum('total_amount') - $Expenses->sum('amount') }}
                                        @endif
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="container-fluid" style="margin-left: 13px; padding-top: 10px;">
                            <div class="row">
                                @include('Admin.partial.livewire.states', ['showDeleteButton' => 'true', 'states' => $states])
                            </div>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> </th>
                                    @foreach($availableColumns as $column)
                                            <th>{{ $column }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @if($readyToLoad)
                                    @forelse($Receipts as $Receipt)

                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model="selectedRows.{{ $Receipt->id }}">
                                            </td>
                                            <td>{{ $Receipt->id }}</td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($Receipt->receiptItems as $receiptItem)

                                                        @if($searchByItem_id != null)
                                                            @if($receiptItem->item_id == $searchByItem_id)
                                                                <div class="text-center zoom-wrapper">
                                                                    <div class="zoom-content">
                                                                        <img src="{{ asset('storage/' . $receiptItem->item->image_path) }}"
                                                                            alt="{{ $receiptItem->item->name }}"
                                                                            class="img-thumbnail"
                                                                            style="height: 60px; object-fit: cover;">
                                                                        <!-- <small class="d-block mt-1">{{ $receiptItem->item->name }} : {{ $receiptItem->item_qty }}</small> -->
                                                                        <small class="d-block mt-1">{{ $receiptItem->item->name }} : {{ $receiptItem->item_qty }} </small>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @elseif($searchByCategory_id != null)
                                                            @if($receiptItem->item->category_id == $searchByCategory_id)

                                                                <div class="text-center zoom-wrapper">
                                                                    <div class="zoom-content">
                                                                        <img src="{{ asset('storage/' . $receiptItem->item->image_path) }}"
                                                                            alt="{{ $receiptItem->item->name }}"
                                                                            class="img-thumbnail"
                                                                            style="height: 60px; object-fit: cover;">
                                                                        <!-- <small class="d-block mt-1">{{ $receiptItem->item->name }} : {{ $receiptItem->item_qty }}</small> -->
                                                                        <small class="d-block mt-1">{{ $receiptItem->item->name }} : {{ $receiptItem->item_qty }}  </small>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @elseif($searchByItemName != null)
                                                            @if(in_array($receiptItem->item->id, $this->item_ids))

                                                                <div class="text-center zoom-wrapper">
                                                                    <div class="zoom-content">
                                                                        <img src="{{ asset('storage/' . $receiptItem->item->image_path) }}"
                                                                            alt="{{ $receiptItem->item->name }}"
                                                                            class="img-thumbnail"
                                                                            style="height: 60px; object-fit: cover;">
                                                                        <!-- <small class="d-block mt-1">{{ $receiptItem->item->name }} : {{ $receiptItem->item_qty }}</small> -->
                                                                        <small class="d-block mt-1">{{ $receiptItem->item->name }} : {{ $receiptItem->item_qty }}  </small>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="text-center zoom-wrapper">
                                                                <div class="zoom-content">
                                                                    <img src="{{ asset('storage/' . $receiptItem->item->image_path) }}"
                                                                        alt="{{ $receiptItem->item->name }}"
                                                                        class="img-thumbnail"
                                                                        style="height: 60px; object-fit: cover;">
                                                                    <!-- <small class="d-block mt-1">{{ $receiptItem->item->name }} : {{ $receiptItem->item_qty }}</small> -->
                                                                    <small class="d-block mt-1">{{ $receiptItem->item->name }} : {{ $receiptItem->item_qty }} : {{ $searchByItem_id }} </small>
                                                                </div>
                                                            </div>
                                                        @endif



                                                    @endforeach
                                                </div>
                                            </td>

                                            <td>{{ $Receipt->total_amount  }}</td>

                                            <td>{{ $Receipt->entry_person->username }}</td>
                                            <td>{{ $Receipt->created_at }}</td>
                                            <!-- <td>
                                                @if($Receipt->is_active == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $Receipt->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $Receipt->id }}, 1)"></span>
                                                @endif
                                            </td> -->
                                            <td>
                                                <button wire:click="RowReceiptPrintOut({{ $Receipt->id }})" class="btn btn-success w-100">Print Slip</button>

                                                <!-- <a data-screen-pos-id="23" wire:click="EditData({{ $Receipt->id }})" class="btn btn-primary">Edit</a> -->
                                                <button data-screen-pos-id="24" onclick="confirmDelete('{{ $Receipt->id }}')" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center"> <h2> No enteries Found!!! </h2></td>
                                        </tr>
                                    @endforelse
                                @endif



                            </tbody>
                        </table>


            </div>
        </div>
    </div>
</div>
</div>

@endcan

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
