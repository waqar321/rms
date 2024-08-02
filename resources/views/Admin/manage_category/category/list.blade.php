
@push('styles')

 
    <style>
        .testForm
        {  
            display: block !important;
            margin-top: 0em !important;
            unicode-bidi: isolate !important;
            padding-top: 20px;
        }
        .card-header
        {
            padding-right: 75px;
        }

    </style>
@endpush 

@can('course_category_listing') 

<div class="row" data-screen-permission-id="11">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-4 col-lg-4">
                    <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Category...">
                </div>
                
                @include('Admin.partial.livewire.ClearDeleteButtons')  
                

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
                                    @if($column != 'Image' && $column != 'Actions' && $column != 'Parent Category')
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
                                        @if($column != 'Parent Category')
                                        <th>{{ $column }}</th>
                                        @endif 
                                    @endforeach
                                </tr>
                            </thead>
                            
                            <tbody>
                                
                                @if($readyToLoad)
                                    @if (!empty($categories))
                                        <!-- <tr>
                                            <td>
                                                <input type="search" class="form-control" placeholder="Search By ID...">
                                            </td>
                                            <td>
                                                <input type="search" class="form-control" placeholder="Search By Name...">
                                            </td>
                                            <td>
                                                <input type="search" class="form-control" placeholder="Search By ID...">
                                            </td>
                                            <td>
                                                <input type="search" class="form-control" placeholder="Search By ID...">
                                            </td>
                                            <td>
                                            </td>
                                            <td>
                                            </td>
                                        </tr> -->
                                    @endif 
                                    
                                    @forelse($categoryListing as $category)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model="selectedRows.{{ $category->id }}">
                                            </td>
                                            <td>{{ $category->id }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td> 
                                                @if($category->image)
                                                    @php
                                                        $imageUrl = str_replace('category-management', '', $category->image_path);
                                                    @endphp
                                                    <img src="/storage/{{$imageUrl}}" style="width: 70px; height: 45px;" class="me-4" alt="Img">
                                                @endif
                                            </td>
                                            <td>{{ $category->created_at }}</td>
                                            
                                            <td>
                                                @if($category->is_active == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $category->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $category->id }}, 1)"></span>
                                                @endif

                                            </td>
                                            <td>
                                                <a data-screen-permission-id="13" href="{{ url_secure_api('category-management/category/?id=') . base64_encode($category->id) }}" class="btn btn-primary">Edit</a>
                                                <button data-screen-permission-id="14" onclick="confirmDelete('{{ $category->id }}')" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center"> <h2> No Category Record Found!!! </h2></td>
                                        </tr>
                                    @endforelse
                                @endif
                                
                                @include('Admin.partial.livewire.loadingData')   
                                
                            </tbody>
                        </table>
                        
                        @include('Admin.partial.livewire.pagination', ['ModelListing' => $categoryListing, 'Model' => 'CategoryListing'])  

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

        $('.ExportButtonLivewire').on('click', function() 
        {       
            var selectedColumns = $('#framework').val();
            Livewire.emit('selectedColumns', selectedColumns.join(', '), $(this).data('export-type'));
        });

    });
</script>

@endpush 