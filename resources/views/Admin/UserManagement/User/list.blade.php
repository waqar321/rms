
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

@can('user_listing')
    <div class="row" data-screen-permission-id="22">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="col-md-3 col-lg-3">
                        <input type="search" wire:model="searchByEmployeeCode" class="form-control" placeholder="Search By Employee Code...">
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Employee Name...">
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <input type="search" wire:model="searchByEmployeeRole" class="form-control" placeholder="Search By Employee Role...">
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <input type="search" wire:model="searchByEmployeeDesignation" class="form-control" placeholder="Search By Employee Designation...">
                    </div>
                    <div class="col-md-3 col-lg-3">
                        <input type="search" wire:model="searchByEmployeeCity" class="form-control" placeholder="Search By Employee City...">
                    </div>
                    <div  class="col-md-1 col-lg-1">
                        <button type="button" wire:click="resetInput(true)" class="btn btn-danger SearchButton" style="width: 130px;">
                            Clear Filter
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    
                    <ul class="nav navbar-right panel_toolbox justify-content-end">
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul> 

                    <div class="clearfix"></div>
                        
                </div>
                <div class="x_content">
                    <div class="col-lg-4" id="ColumnsDropDown" wire:ignore>     
                        
                        <select id="framework1" name="framework1[]" multiple class="form-control" style="display:none;">
                                @foreach($availableColumns as $column)
                                    @if($column != 'Status' && $column != 'Action')
                                        <option value="{{ $column }}">{{ ucfirst($column) }}</option>
                                    @endif 
                                @endforeach
                        </select>

                        <select id="framework" name="framework[]" multiple class="form-control">
                                @foreach($availableColumns as $column)
                                    @if($column != 'Status' && $column != 'Action')
                                        <option value="{{ $column }}">{{ ucfirst($column) }}</option>
                                    @endif 
                                @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <!-- <button
                            class="btn btn-primary btn-sm uppercase mr-1 selectingvalue"
                            type="button"
                            data-export-type="1"
                            wire:loading.attr="disabled"
                        >
                            Select All 
                        </button> -->
                        <!-- <button
                            class="btn btn-primary btn-sm uppercase mr-1 selectingvalue"
                            type="button"
                            data-export-type="0"
                            wire:loading.attr="disabled"
                        >
                            De-Select All 
                        </button> -->
                        <!-- <button
                            class="btn btn-primary btn-sm uppercase mr-1 selectingvalue"
                            type="button"
                            data-export-type="0"
                            wire:loading.attr="disabled"
                        >
                            {{ $selectedRows }}
                        </button> -->
                    </div>

                        @include('Admin.partial.livewire.exportButtons')  

                            <hr>
            
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
                                        @forelse($userListing as $user)
                                     
                                            <tr>
                                                <td>
                                                    <input type="checkbox" wire:model="selectedRows.{{ $user->id }}">
                                                    <!-- <input type="checkbox" wire:model="selectUserIDS" value="{{ $user->id }}"> -->
                                                </td>
                                                <td data-id="{{ $user->id }}">{{ $user->employee_id }}</td>
                                                <td>{{ $user->full_name  }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->city->city_name ?? ' - '  }}</td>

                                                <td>
                                                    <?php 
                                                        $roles = $user->roles->pluck('title')
                                                    ?>    
                                                    @foreach($roles as $role)
                                                        {{ $role.', ' }}
                                                    @endforeach

                                                </td>

                                                <td>{{ $user->designation }}</td>
                                                <td>{{ $user->created_at }}</td>
                                                
                                                <td>
                                                    @if($user->is_active == 1)
                                                        <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $user->id }}, 0)"></span>
                                                    @else
                                                        <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $user->id }}, 1)"></span>
                                                    @endif
                                                </td>
                                                <td>
                                                

                                                    <a data-screen-permission-id="23" href="{{ url_secure_api('manage_user/?id=' . base64_encode($user->id)) }}" class="btn btn-primary">Edit</a>
                                                    <button data-screen-permission-id="24" onclick="confirmDelete('{{ $user->id }}')" class="btn btn-danger">Delete</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center"> <h2> No User Record Found!!! </h2></td>
                                            </tr>
                                        @endforelse
                                    @endif 

                                    @include('Admin.partial.livewire.loadingData') 

                                </tbody>
                            </table>
                
                            @include('Admin.partial.livewire.pagination', ['ModelListing' => $userListing, 'Model' => 'UserListing'])       

                </div>
            </div>
        </div>
    </div>
    </div>
@endcan() 

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

        // $(document).on('click', '.SearchButton', function(event) 
        // {
        //     event.preventDefault();

        //     $('#framework').css('display', 'none');
        //     var clonedSelect = $('#framework1').clone();
        //     clonedSelect.css('display', 'block');
        //     clonedSelect.multiselect({
        //         nonSelectedText: 'Select Framework',
        //         enableFiltering: true,
        //         enableCaseInsensitiveFiltering: true,
        //         buttonWidth:'400px'
        //     });
        //     $('#ColumnsDropDown').append(clonedSelect);
            //     $('select[framework]').multiselect( 'reset' );

            //    // Clear selected options
            //     $('#framework option:selected').prop('selected', false);
                
            //     $('#framework').val('').multiselect('refresh');
            //     $('#framework').multiselect('deselectAll', false);    
            //     $('#framework').multiselect('updateButtonText');
            // console.log('print message');

        // });


        $('.ExportButtonLivewire').on('click', function() 
        {       
            var selectedColumns = $('#framework').val();
            Livewire.emit('selectedColumns', selectedColumns.join(', '), $(this).data('export-type'));
        });
        $('.selectingvalue').on('click', function() 
        {       
            // alert($(this).data('export-type'));
            // return false;
            // var selectedColumns = $('#framework').val();
            Livewire.emit('selectAll', $(this).data('export-type'));
        });

        
        // -------------------- load the dropdown data  ----------------------
        // window.addEventListener('ResetColumns', event => 
        // {  
        //     $('#framework').val('').multiselect('refresh');
        //     $('#framework').multiselect('deselectAll', false);    
        //     $('#framework').multiselect('updateButtonText');
        //     console.log('print message');
        // });
    
    });
</script>

@endpush 