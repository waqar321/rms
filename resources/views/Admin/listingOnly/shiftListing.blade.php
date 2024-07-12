

@can('schedule_listing') 

    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-4 col-lg-4">
                            <input type="search" wire:model="shift_code" class="form-control" placeholder="Search Shift Code...">
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
                                    @foreach($availableColumns as $column)
                                        <th> {{ $column }} </th>                                        
                                    @endforeach 
                                </tr>
                            </thead>
                        
                            <tbody>

                                    @if($readyToLoad)
                                        @forelse($AllShift as $shift)
                                            <tr>
                                                <td>{{ $shift->shift_code ?? 'not found '}}</td>
                                                <td>{{ $shift->start_time ?? 'not found '}}</td>
                                                <td>{{ $shift->end_time ?? 'not found '}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="21" class="text-center"> <h2> No Record Found For Shifts !!! </h2></td>
                                            </tr>
                                        @endforelse
                                    @endif 

                                    @include('Admin.partial.livewire.loadingData')

                            </tbody>

                        </table>
                        <div>
                            @if($readyToLoad)
                                {{ $AllShift->links() }} 
                            @endif 
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan
