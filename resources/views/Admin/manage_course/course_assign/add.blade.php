

@push('styles')

<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered 
    {
        color: #999 !important;
        line-height: 28px;
    }
    /* .select2-container:not(.CourseSelect2) 
    {
        display: block !important;
    } */

    /* .CourseSelect2
    {
        display: none  !important;
    } */

</style>
@endpush 

@php 
    if ($errors->any())
    {
        $this->ErrorLoaded(); 
    }
@endphp 

<div class="row" id="addCategoryPanel" data-screen-permission-id="37">  
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
            <h2> {{ $pageTitle }} 

                           <span wire:init="pageLoaded" style="padding-left: 20px;">
                                 @if($total_employees == 0)
                                    <label for=""> Feeding Data For Course Alignment... </label>
                                    <td colspan="18" class="text-center"> 
                                            <img style="height:70px;" src="{{ url_secure('build/images/transpatent_leopard.gif') }}" alt="Loading123!!">
                                    </td>
                                @endif 
                            </span>

                   <?php 
                        // echo 'course_id: '.$ecom_course_assign->course_id."<br>";
                        // echo 'role_id: '.$ecom_course_assign->role_id."<br>";
                        // echo 'instructor_id: '.$ecom_course_assign->instructor_id."<br>";
                        // echo 'employee_id: '.$ecom_course_assign->employee_id."<br>";
                        // echo 'department_id: '.$ecom_course_assign->department_id."<br>";
                        // echo 'sub_department_id: '.$ecom_course_assign->sub_department_id."<br>";
                        // echo 'zone_code: '.$ecom_course_assign->zone_code."<br>";
                        // echo 'city_id: '.$ecom_course_assign->city_id."<br>";
                        // echo 'branch_id: '.$ecom_course_assign->branch_id."<br>";
                        // echo 'shift_time_id: '.$ecom_course_assign->shift_time_id."<br>";                   
                   ?> 


            </h2>
                    <ul class="nav navbar-right panel_toolbox justify-content-end">
                       
                        <li>
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                    </ul> 
                    <!-- <button onclick="startFCM()"
                        class="btn btn-danger btn-flat ml-2">          Allow notification
                    </button> -->
                <div class="clearfix"></div>

            </div>

            <div class="x_content {{ $Collapse  }}">

                @foreach ($errors->all() as $key => $error)
                    @if (strpos($error, 'CSV For') !== false)
                        @if (strpos($error, 'Valid IDs') !== false) 
                            <div class="col-mb-12 col-lg-12">   
                                <div class="alert alert-success" style="font-size: 13.5px;">
                                    {{ $error }} 
                                </div>
                            </div>    
                        @else  
                            <div class="col-mb-12 col-lg-12">   
                                <div class="alert alert-danger" style="font-size: 13.5px;">
                                    {{ $error }} 1
                                </div>
                            </div>    
                        @endif 
                    @else                      
                        <div class="col-mb-12 col-lg-12">   
                            <div class="alert alert-danger" style="font-size: 13.5px;">
                                {{ $error }} !!! 12
                            </div>
                        </div>    
                    @endif
                @endforeach

                @error('csv_file')
                <!-- <div class="alert alert-danger" style="font-size: 13.5px;">
                    {{ $message }}
                </div> -->
                @enderror
                
                <div class="col-mb-12 col-lg-12">
                    <form>

                        @csrf

                        @include('Admin.partial.livewire.select2Elements', ['Component' => 'courseAlign'])
                        
                        <!-- ========================= Upload CSV ======================================= -->
                        <div class="col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Align In Bulk IDs <span class="danger">*</span></label>
                                <input type="file" wire:model="csv_file" name="csv_file" accept=".csv" class="form-control-file">
                                <small class="form-text text-muted">Upload a CSV file containing employee Ids.</small>
                            </div>
                        </div>

                        <!-- Display sample CSV file for reference -->
                        <div class="col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Sample CSV File</label><br>
                                <a href="#" wire:click.prevent="exportTemplate(true)" download>Download Sample CSV</a>
                            </div>
                        </div>

                        @include('Admin.manage_course.course_assign.download-csv')  

                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit"  id="SendFormRequest" data-component="SendCourseAlignment" class="btn btn-primary"> {{ $update ? 'Update' : 'Save' }} </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')

    <script>

        

    </script>
@endpush 
