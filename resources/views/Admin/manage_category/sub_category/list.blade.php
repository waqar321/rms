


@can('course_subcategory_listing') 
<div class="row" data-screen-permission-id="16">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-4 col-lg-4">
                    <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Sub Category Name...">
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
                                @if($column != 'Image' && $column != 'Actions' && $column)
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
                                <th>ID#</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Parent Category</th>
                                <th>Date Created</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                                @if($readyToLoad)
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
                                            <td>{{ $category->parentCategory->name ?? ''}}</td>
                                            <td>{{ $category->created_at }}</td>
                                            <td>
                                                @if($category->is_active == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $category->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $category->id }}, 1)"></span>
                                                @endif
                                            </td>
                                            <td>
                                                <a data-screen-permission-id="18" href="{{ url_secure_api('category-management/sub_category/?id=') . base64_encode($category->id) }}" class="btn btn-primary">Edit</a>
                                                <button data-screen-permission-id="19" onclick="confirmDelete('{{ $category->id }}')" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center"> <h2> No Record Found </h2></td>
                                        </tr>
                                    @endforelse
                                @endif 

                                @include('Admin.partial.livewire.loadingData')
                                
                        </tbody>
                    </table>


                    <div>
                        @if($readyToLoad)
                            {{ $categoryListing->links() }} 
                        @endif 
                    </div>      
                 
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