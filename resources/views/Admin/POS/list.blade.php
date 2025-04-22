
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

@can('permission_listing') 

<div class="row" data-screen-permission-id="22">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-4 col-lg-4">
                    <input type="search" wire:model="searchByID" class="form-control" placeholder="Enter Receipt Number...">
                </div>
                
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
                                    <button class="btn btn-info btn-sm uppercase mr-1" type="button"> Total Sale: {{ $readyToLoad ? $Receipts->getCollection()->sum('total_amount') : 0.0 }} </button>
                                </div>
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
                                                        <div class="text-center" style="width: 80px;">
                                                            <img src="{{ asset('storage/' . $receiptItem->item->image_path) }}" 
                                                                alt="{{ $receiptItem->item->name }}" 
                                                                class="img-thumbnail" 
                                                                style="height: 60px; object-fit: cover;">
                                                            <small class="d-block mt-1">{{ $receiptItem->item->name }}</small>
                                                        </div>
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

                                @include('Admin.partial.livewire.loadingData') 

                            </tbody>
                        </table>

                        @include('Admin.partial.livewire.pagination', ['ModelListing' => $Receipts, 'Model' => 'PermissionListing'])       
            
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