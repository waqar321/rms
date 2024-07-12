
<div class="row" data-screen-permission-id="36">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="col-md-4 col-lg-4">
                        <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Course...">
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
                    
                        <tbody>

                                @if($readyToLoad)
                                    @forelse($course_assigned as $assign_course)
                                        <?php   
                                        
                                            $CsvColumns = json_decode($assign_course->upload_csv_json_data);

                                            //dd($assign_course, $assign_course->Department, $assign_course->SubDepartment);
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model="selectedRows.{{ $assign_course->id }}">
                                            </td>

                                            <td>{{ $assign_course->id }}</td>
                                            <td>{{ $assign_course->Course->name ?? 'Not Selected'}}</td>
                                            <td>{{ $assign_course->Uploader->first_name  }} {{ $assign_course->Uploader->last_name  }} </td>

                                            <td> {!! $assign_course->instructor_id ? $assign_course->Instructor->full_name : (isset($CsvColumns->InstructorIDs) ? 'CSV Contain IDs' : '<span class="not-aligned-info">NOT Aligned</span>' ) !!} </td>                                            
                                            <td> {!! $assign_course->employee_id ? $assign_course->Employee->full_name : (isset($CsvColumns->EmployeeIDs) ? 'CSV Contain IDs' : '<span class="not-aligned-info">NOT Aligned</span>' ) !!} </td>

                                            <td> {!! $assign_course->Department ? $assign_course->Department->name : (isset($CsvColumns->DepartmentIDs) ? 'CSV Contain IDs' : '<span class="not-aligned-info">NOT Aligned</span>' ) !!} </td>

                                            <td> {!! $assign_course->sub_department_id ? $assign_course->SubDepartment->name : (isset($CsvColumns->SubDepartmentIDs) ? 'CSV Contain IDs' : '<span class="not-aligned-info">NOT Aligned</span>' ) !!} </td>
                                            
                                            <td> {!! $assign_course->zone_code ? $assign_course->Zone->zone_name. '( '.$assign_course->Zone->zone_short_name. ')' : (isset($CsvColumns->ZoneIDs) ? 'CSV Contain IDs' : '<span class="not-aligned-info">NOT Aligned</span>' ) !!} </td>
                                            
                                            <!-- <td>
                                                {!! $assign_course->employee_id ? $assign_course->Employee->first_name : (isset($CsvColumns->EmployeeIDs) ? 'CSV Contain IDs' : '<h4 class="not-aligned-info">NOT Aligned</h4>') !!}
                                            </td> -->

                                            <td> {!! $assign_course->city_id ? $assign_course->City->city_name : (isset($CsvColumns->CityIDs) ? 'CSV Contain IDs' : '<span class="not-aligned-info">NOT Aligned</span>' ) !!} </td>
                                            <!-- <td> {{ $assign_course->city_id ? $assign_course->City->city_name : (isset($CsvColumns->CityIDs) ? 'CSV Contain IDs' : '<h4 class="not-aligned-info">NOT Aligned</h4>' ) }} </td> -->
                                            
                                            <td> {!! $assign_course->branch_id ? $assign_course->Branch->branch_name: (isset($CsvColumns->BranchIDs) ? 'CSV Contain IDs' : '<span class="not-aligned-info">NOT Aligned</span>' ) !!} </td>
                                            
                                            
                                            <td> {!! $assign_course->role_id ? $assign_course->Role->title: (isset($CsvColumns->RoleIDs) ? 'CSV Contain IDs' : '<span class="not-aligned-info">NOT Aligned</span>' ) !!} </td>
                                            <!-- <td> {{ $assign_course->shift_time_id ? ($assign_course->Shifttime->start_time ?? 'Not Aligned') . ' - ' . ($assign_course->Shifttime->end_time) : (isset($CsvColumns->ScheduleIDs) ? 'CSV Contain IDs' : ' NOT Aligned') }} </td> -->
                                            <td> {!! $assign_course->shift_time_id ? $assign_course->Shifttime->start_time: (isset($CsvColumns->RoleIDs) ? 'CSV Contain IDs' : '<span class="not-aligned-info">NOT Aligned</span>' ) !!} </td>
                                            

                                            <td>{{ $assign_course->created_at }}   </td>
                                            <td>
                                                @if($assign_course->is_active == 1)
                                                    <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $assign_course->id }}, 0)"></span>
                                                @else
                                                    <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $assign_course->id }}, 1)"></span>
                                                @endif
                                            </td>

                                            <td>
                                                <a data-screen-permission-id="38" href="{{ url_secure_api('content-management/assign_course?id=') . base64_encode($assign_course->id) }}" class="btn btn-primary">Edit</a>
                                                <button data-screen-permission-id="39" onclick="confirmDelete('{{ $assign_course->id }}')" class="btn btn-danger">Delete</button>
                                                
                                                @if ($assign_course->upload_csv)
                                                    <!-- <a href="{{ asset('/storage/'.$assign_course->upload_csv) }}" class="btn btn-info" target="__blank" >Preview CSV</a> -->
                                                    <a href="{{ asset('/storage/'.$assign_course->upload_csv) }}" class="btn btn-info" download>Download CSV</a>
                                                @endif

                                                @if ($assign_course->local_document)
                                                    <a href="{{ asset('/storage/'.$assign_course->local_document) }}" class="btn btn-info" target="__blank">Preview Document</a>
                                                @endif
                                        
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="18" class="text-center"> <h2> No Record Found  !!! </h2></td>
                                        </tr>
                                    @endforelse
                                @endif 

                                @include('Admin.partial.livewire.loadingData')

                        </tbody>

                    </table>
                     <div>
                        @if($readyToLoad)                          
                            {{ $course_assigned->links() }} 
                        @endif 
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

