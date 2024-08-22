

@push('styles')

    <style>
        .LabelLoader {
            display: flex;
            align-items: center;
        }
        .LabelLoader label {
            margin-right: 10px; /* Adjust the spacing between label and image if needed */
        }
        .LabelLoader img {
            vertical-align: middle;
        }
    </style>
@endpush 

                    <!-- ========================= Course ======================================= -->

                    @if($Component == 'courseAlign')
                        <div class="col-md-6 col-lg-6" wire:ignore>
                            <div class="form-group" >
                                <label id="HRCourse">Course ( {{ count($courses) }} ) <span class="danger">*</span></label>
                                    <select name="course_id" id="course_id" 
                                                data-id="HRCourse"
                                                data-table="ecom_course"
                                                data-table-field="course_id"
                                                class="form-control HRCourse" required
                                        
                                        @if($Component == 'courseAlign') 
                                            class="courseAlign"
                                        @else 
                                            class="notification"
                                        @endif
                                        
                                        @if($Component == 'courseAlign' && $update) 
                                            
                                        @endif 
                                    >

                                        <option value="" disabled selected style="color: #131212 !important">Select Course </option> 
                                        @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }} </option>
                                        @endforeach 
                                    </select>
                            </div>
                        </div>
                    @endif 

                    <!-- ========================= instructor ======================================= -->

                    <div class="col-md-6 col-lg-6" >
                        <div class="form-group" wire:ignore> 
                            <label id="HRInstructors"> Instructor ( {{ count($instructors) }} ) <span class="danger">*</span></label>
                            <select name="instructor_id" id="instructor_id"
                                    data-id="HRInstructors"
                                    data-table="ecom_admin_user"
                                    data-table-field="instructor_id"
                                class="form-control HRInstructors"
                            
                                    @if($Component == 'courseAlign') 
                                        class="courseAlign"
                                    @else 
                                        class="notification"
                                    @endif
                                    @if($Component == 'courseAlign' && $update) 
                                            
                                    @endif
                                    >                            
                          
                                   <option value="" disabled selected style="color: #131212 !important">Select Instructor </option>      
                                    @forelse($instructors as $instructor)    
                                        
                                        <option value="{{ $instructor->id }}">{{ $instructor->full_name }}  </option>
                                    @empty 

                                    @endforelse 
                            </select>
                        </div>
                    </div>

                    <!-- ========================= Role ======================================= -->

                    <div class="col-md-6 col-lg-6">
                        <div class="form-group" wire:ignore> 
                            <label id="HRRoles">Assign To Role ( {{ count($roles) }} )  <span class="danger">*</span></label>
                            
                                <select  name="role_id" id="role_id" 
                                            data-id="HRRoles" 
                                            data-table="ecom_user_roles"
                                            data-table-field="role_id"
                                            class="form-control HRRoles"

                                        @if($Component == 'courseAlign') 
                                            class="courseAlign"
                                        @else 
                                            class="notification"
                                        @endif
                                        
                                        @if($Component == 'courseAlign' && $update) 
                                            
                                        @endif 
                                    >

                                        <option value="" disabled selected style="color: #131212 !important">Select Role </option>      
                                        @forelse($roles as $role)                                
                                            <option value="{{ $role->id }}">{{ $role->title }} </option>
                                        @empty 
                                        @endforelse 
                                </select>
                        </div>
                    </div>
                
                    <!-- ========================= Employee ======================================= -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group" wire:ignore>
                        <label id="HREmployee"> Employees * ( {{ $total_employees}} ) </label>
                            <select class="select2 form-control" tabindex="-1" data-rule-required="true" 
                                        data-msg-required="Role field is required" name="employee_new_id"
                                        data-id="employee_new_id" 
                                        data-table="ecom_admin_user"
                                        data-table-field="employee_id"
                                        class="employee_new_id" id="employee_new_id" onchange="ChangedEmployee()"
                                        
                                        @if($Component == 'courseAlign') 
    
                                            class="courseAlign"
                                        @else 
                                             
                                            class="notification"
                                        @endif

                                        @if($Component == 'courseAlign' && $update) 
                                            
                                        @endif
                                        >
                                        
                                        
                            </select>
                            <span class="error-container danger w-100"></span>
                        </div>
                    </div>

                    <!-- ========================= department ======================================= -->
                    <div class="col-md-6 col-lg-6" >
                        <div class="form-group" wire:ignore>
                            <label id="HRDepartment"> Department ({{ count($departments) }})  <span class="danger">*</span></label>
                                <select  name="department" 
                                        data-id="HRDepartment" 
                                        data-table="ecom_department"
                                        data-table-field="department_id"
                                        class="form-control HRDepartment"
                                    
                                    @if($Component == 'courseAlign') 
                                         
                                        class="courseAlign"
                                    @else 
                                         
                                        class="notification"
                                    @endif

                                    @if($Component == 'courseAlign' && $update) 
                                        
                                    @endif

                                    >
                                    <option value="" disabled selected style="color: #131212 !important">Select Department </option>  
                                        @foreach($departments as $department_id => $name)   
                                            <option value="{{ $department_id }}"> {{ $name }} </option>
                                        @endforeach
                                </select>
                        </div>
                    </div>

                    <!-- ========================= Sub Department ======================================= -->
                    <div class="col-md-6 col-lg-6" >
                        <div class="form-group" wire:ignore>
                            
                        <div class="LabelLoader">
                            <label id="HRSubDepartment"> Sub Departments ({{ count($sub_departments) }})<span class="danger">*</span></label>
                            <img  id="SubDepartmentloader" style="height:17px; display:none;" class="loadingSubDepartments" src="{{ url_secure('build/images/loadingData.gif') }}" alt="Loading123!!"> 
                        </div>  

                                <select name="subdepartment" 
                                        data-id="HRSubDepartment" 
                                        data-table="ecom_department"
                                        data-table-field="sub_department_id"
                                        class="form-control HRSubDepartment"

                                        @if($Component == 'courseAlign') 
 
                                            class="courseAlign"
                                        @else 
 
                                            class="notification"
                                        @endif
                                        @if($Component == 'courseAlign' && $update) 
                                            
                                        @endif
                                        >

                                                 
                                    @if(!$sub_departments->isEmpty())
                                        <option value="" disabled selected style="color: #131212 !important">Select Sub Department </option> 
                                        @foreach ($sub_departments as $sub_department_id => $department_name)
                                            <option value="{{ $sub_department_id }}">{{ $department_name}}</option>
                                        @endforeach
                                    @endif 
                                    
                                </select>
                        </div>
                    </div>  
                    <!-- ========================= Zone ======================================= -->
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group" wire:ignore>
                            <label id="HRZone"> Assign To Zone ( {{ count($zones) }} ) {{ $ecom_notification->zone_code ?? 'empty' }}  <span class="danger">*</span></label>
                    
                            <select name="zone_code" id="zone_code" 
                                        data-id="HRZones" 
                                        data-table="zone"
                                        data-table-field="zone_code"
                                        class="form-control HRZones"

                                        @if($Component == 'courseAlign') 
                                             
                                            class="courseAlign"
                                        @else 
                                             
                                            class="notification"
                                        @endif
                                        @if($Component == 'courseAlign' && $update) 
                                            
                                        @endif
                                        >
                                        <option value="" disabled selected style="color: #131212 !important">Select Zone </option> 
                                    @foreach($zones as $zone)                                
                                        <option value="{{ $zone->zone_code }}"> {{ $zone->zone_short_name }} </option>
                                    @endforeach  
                            </select>
                        </div>
                    </div>         
                    <!-- ========================= City ======================================= -->
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group" wire:ignore>

                            <div class="LabelLoader">
                                <label id="HRCity"> Assign To City   <span class="danger">*</span></label>
                                <img  style="height:17px; display:none;" class="loadingCities" src="https://i.gifer.com/ZKZg.gif" alt="Loading123!!">
                                </div>  
                            <select 
                                name="city_id" id="city_id" 
                                            data-id="HRCities" 
                                            data-table="central_ops_city"
                                            data-table-field="city_id"
                                            class="form-control HRCities"


                                    @if($Component == 'courseAlign') 
                                         
                                        class="courseAlign"
                                    @else 
                                         
                                        class="notification"
                                    @endif
                                    @if($Component == 'courseAlign' && $update) 
                                        
                                    @endif
                                >
                            
                                @if(!$cities->isEmpty())
                                    <option value="" disabled selected style="color: #131212 !important">Select City </option> 
                                    @foreach($cities as $cityName => $city_id)
                                        <option value="{{ $city_id }}">{{ $cityName }} </option>
                                    @endforeach 
                                @endif  

                            </select>
                        </div>
                    </div>             

                    <!-- ========================= Branch ======================================= -->
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group" wire:ignore>
                            <label id="HRBranch"> Assign To Branch ( {{ count($branches) }} )  <span class="danger">*</span></label>
                            <select name="branch_id" id="branch_id" 
                                    data-id="HRBranches" 
                                    data-table="central_ops_branch"
                                    data-table-field="branch_id"
                                    class="form-control HRBranches"


                                    @if($Component == 'courseAlign') 
                                         
                                        class="courseAlign"
                                    @else 
                                         
                                        class="notification"
                                    @endif

                                    @if($Component == 'courseAlign' && $update) 
                                        
                                    @endif
                                    >
                                <option value="" disabled selected style="color: #131212 !important">Select Branch </option>  
                                @foreach($branches as $BranchName => $Branch_id)                    
                                    <option value="{{ $Branch_id }}">{{ $BranchName }} </option>
                                @endforeach 
                            </select>
                        </div>
                    </div>

                    <!-- ========================= Time Slot ======================================= -->
                    <div class="col-md-6 col-lg-6" >
                        <div class="form-group" wire:ignore>
                            <label id="HRTimeSlot"> Assign To Employee Schedules ( {{ count($schedules) }} )  <span class="danger">*</span></label>
                            <select name="shift_time_id"id="shift_time_id" 
                                        data-id="HRTimeSlots" 
                                        data-table="ecom_employee_time_slots"
                                        data-table-field="shift_time_id"
                                        class="form-control HRTimeSlots"
                                
                                    @if($Component == 'courseAlign') 
                                         
                                        class="courseAlign"
                                    @else 
                                         
                                        class="notification"
                                    @endif
                                    @if($Component == 'courseAlign' && $update) 
                                        
                                    @endif
                                    >

                                    <option value="" disabled selected style="color: #131212 !important">Select Time Slot </option>        
                                    @forelse($schedules as $schedule)               
                                        <option value="{{ $schedule->id }}">{{ $schedule->start_time }} To {{ $schedule->end_time }}  </option>
                                    @empty  
                                    @endforelse 
                            </select>
                        </div>
                    </div>