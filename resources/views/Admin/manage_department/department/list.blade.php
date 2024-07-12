
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

<div class="row" data-screen-permission-id="22">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-4 col-lg-4">
                    <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Name...">
                </div>
                <div  class="col-md-1 col-lg-1">
                    <button type="button" wire:click="resetInput(true)" class="btn btn-danger SearchButton">
                        Clear  
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
                <div class="col-lg-4" wire:ignore>               
                    <select id="framework" name="framework[]" multiple class="form-control">
                            @foreach($availableColumns as $column)
                                @if($column != 'Image' && $column != 'Actions')
                                    <option value="{{ $column }}">{{ ucfirst($column) }}</option>
                                @endif 
                            @endforeach
                    </select>
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
                                    @forelse($departmentListing as $department)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model="selectedRows.{{ $department->id }}">
                                            </td>
                                            <td>{{ $department->id }}</td>
                                            <td>{{ $department->name }}</td>

                                            <td>{{ $department->created_at }}</td>
                                            
                                            <td>
                                                @if($department->is_active == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $department->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $department->id }}, 1)"></span>
                                                @endif
                                            </td>
                                            <td>
                                                <a data-screen-permission-id="23" href="{{ api_url('department-management/department/?id=') . base64_encode($department->id) }}" class="btn btn-primary">Edit</a>
                                                <button data-screen-permission-id="24" onclick="confirmDelete('{{ $department->id }}')" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center"> <h2> No Department Record Found!!! </h2></td>
                                        </tr>
                                    @endforelse
                                @endif 

                                @include('Admin.partial.livewire.loadingData') 

                            </tbody>
                        </table>
                      
                        <div>
                            @if($readyToLoad)
                                {{ $departmentListing->links() }} 
                            @endif 
                        </div>
            
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

        $('.ExportButtonLivewire').on('click', function() 
        {       
            var selectedColumns = $('#framework').val();
            Livewire.emit('selectedColumns', selectedColumns.join(', '), $(this).data('export-type'));
        });
    
    });
</script>

@endpush 