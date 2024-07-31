
@push('styles')

 
    <style>
        .testForm
        {  
            display: block !important;
            margin-top: 0em !important;
            unicode-bidi: isolate !important;
            padding-top: 20px;
        }
        .toggle-icon
        {
            cursor: pointer; /* Change cursor to pointer */
            font-size: 24px;
            color: blue;
            padding-left: 10px;
        }

        .toggle-icon:hover
        {
            cursor: grab; /* Change cursor to grab when hovering */
        }

    </style>
@endpush 

@can('user_listing')
    <div class="row" data-screen-permission-id="22">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">

                    <div wire:offline>
                        <div class="alert alert-warning" role="alert">
                            This is a warning alert—check it out!
                        </div>
                    </div>

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
                    <div  class="col-md-2 col-lg-2">
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
                        
                        <!-- <button type="button" id="selectAll">Select All</button>
                        <button type="button" id="deselectAll">Deselect All</button> -->

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
                    <div class="col-lg-4">
                        <div wire:loading wire:target="resetInput" class="loader">
                            <img  style="height:31px;" src="{{ url_secure('build/images/loadingData.gif') }}" alt="Loading123!!"> 
                        </div>
                        <div wire:loading wire:target="selectAllmethod" class="loader">
                            <img  style="height:31px;" src="{{ url_secure('build/images/loadingData.gif') }}" alt="Loading123!!"> 
                        </div>
                    </div>

                        @include('Admin.partial.livewire.exportButtons')  

                            <hr>
            
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>  </th>
                                        @foreach($availableColumns as $column)
                                            <th wire:click="sortBy('{{ $column }}')">
                                                    {{ $column }} {{ $sortByRealTime == $column }} 
                                                    @include('Admin.partial.livewire.sort-icon', ['field' => $column])
                                            </th>
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
   
   var AllselectedColumns;
   var Export_types;
   
   $(document).ready(function()
   {
    
        $('#framework').multiselect({
            nonSelectedText: 'Select Framework',
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonWidth:'400px'
        });

        
        $('#selectAll').click(function() 
        {
            // alert('select all');
            // var dataArray = ["Employee Code", "Name", "Email", "City", "Roles", "Designation", "Date", "Status", "Action"];
            // $("#framework").val(dataArray);
            // $('#framework').multiselect('selectAll', false); // Select all options
            // $('#framework').multiselect('updateButtonText'); // Update button text
        });

        // Deselect All
        $('#deselectAll').click(function() 
        {
            
            // alert('deselectAll all');
            // $('#framework').multiselect('deselectAll', false); // Deselect all options
            // $('#framework').multiselect('updateButtonText'); // Update button text
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
            
            if(selectedColumns != null)
            {
                AllselectedColumns = selectedColumns.join(', ');
                Export_types = $(this).data('export-type');
                Livewire.emit('CheckIfRowSelected');
                // Livewire.emit('selectedColumns', selectedColumns.join(', '), $(this).data('export-type'));
            }
            else
            {
                Swal.fire(
                        'Error!',
                        'please select columns before exports: ' + $(this).data('export-type'),
                        'error'
                );
            }
        });
        $('.selectingvalue').on('click', function() 
        {       
            Livewire.emit('selectAll', $(this).data('export-type'));
        });
        window.addEventListener('exportFile', event => 
        {                
            if(event.detail.value)
            {
                Swal.fire(
                        'Error!',
                        'please select rows before exports: ' + Export_types,
                        'error'
                ); 
                return false;
            }
            else
            {
                Livewire.emit('selectedColumns', AllselectedColumns, Export_types);
            }
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