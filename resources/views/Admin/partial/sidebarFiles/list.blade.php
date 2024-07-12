
@push('styles')

 
    <style>
        .testForm
        {  
            display: block !important;
            margin-top: 0em !important;
            unicode-bidi: isolate !important;
            padding-top: 20px;
        }
        .NoFoundID
        {
            color: #1b1a1a !important;
            background-color: #d26e78 !important;
            border-color: #dc3545 !important;
        }
        a
        {
            color: #040a10 !important;
        }

    </style>
@endpush 

@can('sidebar_operation_listing') 

<div class="row" data-screen-permission-id="22">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <div class="col-md-4 col-lg-4">
                    <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Title...">
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> </th>
                            @foreach($availableColumns as $column)
                                    <th>{{ $column }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody wire:sortable="updateOrder">
                        
                        @if($readyToLoad)
                            @forelse($SideBars as $sidebar)
                                @if($sidebar->title != 'Manage Sidebars')
                                    <tr wire:sortable.item="{{ $sidebar->id }}" wire:key="sidebar-{{ $sidebar->id }}">
                                        <td>
                                            <input type="checkbox" wire:model="selectedRows.{{ $sidebar->id }}">
                                        </td>
                                        <td>{{ $sidebar->id }}</td>
                                        <td>{{ $sidebar->title }}</td>                                            
                                        <td>{{ $sidebar->order }}</td>                                            
                                        <td>{{ $sidebar->ParentMenu->title ?? ' Parent Sidebar' }}</td>                                            
                                        <td>{{ $sidebar->permission->title ?? ' Not Set' }}</td>                                            
                                        <td>
                                            @if($sidebar->url != null)
                                                <span style="font-size: 13px;" class="btn btn-danger NoFoundID">
                                            @php
                                                $urlRoute = '#';
                                                if ($sidebar->url && url_secure($sidebar->url)) {
                                                    $urlRoute = url_secure($sidebar->url);
                                                } else {
                                                    $urlRoute = route($sidebar->url);
                                                }
                                            @endphp
                                                <a href="{{ $urlRoute }}">
                                                    {{ $sidebar->url }}                                            
                                                </a>
                                            </span>
                                            @else
                                                    --
                                            @endif
                                        </td> 
                                        <td>{{ $sidebar->ParentMenu->icon ?? ' --  ' }}</td>                                            
                                        <td>
                                            @if($sidebar->IdNames != null)
                                                {{ implode(' ', $sidebar->IdNames) }}
                                            @else
                                                    --
                                            @endif
                                        </td>                                       
                                        <td>
                                            @if($sidebar->ClassNames != null)
                                                {{ implode(' ', $sidebar->ClassNames) }}
                                            @else
                                                    --
                                            @endif
                                        </td>                                       
                                        <td>
                                            @if($sidebar->is_active == 1)
                                                <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $sidebar->id }}, 0)"></span>
                                            @else
                                                <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $sidebar->id }}, 1)"></span>
                                            @endif
                                        </td>
                                        <td>
                                            <a data-screen-permission-id="23" href="{{ route('sidebarEdit', base64_encode($sidebar->id)) }}" class="btn btn-primary">Edit</a>
                                            <button data-screen-permission-id="24" onclick="confirmDelete('{{ $sidebar->id }}')" class="btn btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                @endif 
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center"> <h2> No sidebar Record Found!!! </h2></td>
                                </tr>
                            @endforelse
                        @endif 

                        @include('Admin.partial.livewire.loadingData') 

                    </tbody>
                </table>
                    
                <div>
                    @if($readyToLoad)
                        {{ $SideBars->links() }} 
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