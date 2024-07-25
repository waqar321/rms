<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" >
                <div class="x_title">
                    <div class="col-md-4 col-lg-4">
                        <input type="search" wire:model="title" class="form-control" placeholder="Search Notification by Title...">
                    </div>
                    <div  class="col-md-2 col-lg-2">
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
                                    @if(auth()->user()->isAdmin())
                                        <th> </th>
                                    @endif 
                                    @foreach($availableColumns as $column)
                                        @if(auth()->user()->isAdmin())
                                            <th>{{ $column }}</th>
                                        @elseif($column == 'ID' || $column == 'Title' || $column == 'Message')
                                            <th>{{ $column }}</th>
                                        @endif 
                                    @endforeach
                                </tr>
                        </thead>
                    
                        <tbody wire:poll.10s>

                            
                            @if($readyToLoad)
                                    @php  
                                        $count = 0 
                                    @endphp 

                                    @forelse($notifications as $notification)
                                        @if(CheckAlignment($notification, 'notification'))
                                            <?php   
                                            
                                                $CsvColumns = json_decode($notification->upload_csv_json_data);

                                                $checked = false;
                                                if(!$selectedRows->isEmpty())
                                                {
                                                    $checked = $selectedRows->contains($notification->id);
                                                }
                                                
                                            ?>
                                            <tr>

                                                @if(auth()->user()->isAdmin())
                                                    <th> </th>
                                                @endif
                                                <td>{{ $notification->id }} </td>
                                                <td>{{ $notification->title }}</td>
                                                <td>{!! $notification->messagebody !!}</td>
                                                
                                                @if(auth()->user()->isAdmin())
                                                    <td>{{ $notification->instructor_id ? $notification->Instructor->first_name.' '. $notification->Instructor->last_name : 'NOT Align' }} </td>
                                                    <td>{{ $notification->employee_id ? $notification->Employee->first_name.' '. $notification->Instructor->last_name : 'NOT Align emp' }} </td>
                                                    <td>{{ $notification->department_id ? $notification->Department->name : 'NOT Align depart' }} </td>
                                                    <td>{{ $notification->sub_department_id ? $notification->SubDepartment->name : 'NOT Align sub depart' }} </td>
                                                    <td>{{ $notification->zone_code ? $notification->Zone->zone_name. '( '.$notification->Zone->zone_short_name. ')' : 'NOT Align city' }} </td>
                                                    <td>{{ $notification->city_id ? $notification->City->city_name : 'NOT Align city ' }} </td>
                                                    <td>{{ $notification->branch_id ? $notification->Branch->branch_name : 'NOT Align branch' }} </td>
                                                    <td>{{ $notification->role_id ? $notification->Role->role_name : 'NOT Align role' }} </td>
                                                    <td>{{ $notification->shift_time_id ? $notification->Shifttime->start_time.' to '.$notification->Shifttime->end_time : 'NOT Align' }} </td>

                                                    <td>{{ $notification->created_at }}   </td>
                                                    <td>
                                                        @if($notification->is_active == 1)
                                                            <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $notification->id }}, 0)"></span>
                                                        @else
                                                            <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $notification->id }}, 1)"></span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <!-- <a data-screen-permission-id="43" href="{{ url_secure_api('content-management/notification?id=') . base64_encode($notification->id) }}" class="btn btn-primary">Edit</a> -->
                                                        <button data-screen-permission-id="44" onclick="confirmDelete('{{ $notification->id }}')" class="btn btn-danger">Delete</button>                                       
                                                    </td>
                                                @endif 
                                            </tr>
                                            @php  
                                                $count++
                                            @endphp 
                                        @endif
                                    @empty
                                                
                                        <tr>
                                            <td colspan="18" class="text-center"> <h2> No Notifications Found  !!! </h2></td>
                                        </tr>
                                    @endforelse

                                    @if($count == 0)
                                                
                                            <!-- <tr>
                                            <td colspan="18" class="text-center"> <h2> No Notifications !!!! </h2></td>
                                        </tr> -->

                                    @endif 

                            @endif 

                                @include('Admin.partial.livewire.loadingData')

                        </tbody>

                    </table>
                    <div>
                        @if($readyToLoad)
                            {{ $notifications->links() }} 
                        @endif 
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> 

