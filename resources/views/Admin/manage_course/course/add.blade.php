@push('styles')

    <style>

        /* Set height for label and file input field */
        label, input[type="file"] 
        {
            height: 100%;
            display: flex;
            align-items: center; /* Vertically center content */
        }

    </style>

@endpush

@push('styles')
    <style>
        .form-group
        {
            margin-bottom: 12px !important;  
            /* waqar added */
        }
    </style>
@endpush 

<div class="row" id="DdddepartmentPanel" > 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          
            @include('Admin.partial.livewire.X_titles')   

            <div class="x_content {{ $Collapse  }}">
                @foreach ($errors->all() as $key => $error)
                    <div class="col-mb-12 col-lg-12">
                        <div class="alert alert-danger" style="font-size: 13.5px;">
                            {{ $error }} !!!
                        </div>
                    </div>    
                @endforeach

                <div class="col-mb-12 col-lg-12">
                    <form wire:submit.prevent="saveCourse">
                    @csrf

                        <!-- --------------- course Title --------------------  -->
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Title<span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.name"  id="title" placeholder="Enter Title" class="form-control" required>
                                <!-- @error('title') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                            </div>
                        </div>
                        <!-- --------------- course Description --------------------  -->
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Description<span class="danger">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.description"  id="description" placeholder="Enter Description" class="form-control" required>
                                <!-- @error('description') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                            </div>
                        </div>
                        <!-- ========================= Instructor ======================================= -->

                               @can('select_instructor')
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Instructor <span class="danger">*</span></label>
                                            <select wire:model.debounce.500ms="ecom_course.instructor_id"  name="instructor_id" id="instructor_id" class="form-control" required>
                                            
                                                    @if($ecom_course->instructor_id)
                                                        <option value="{{ $ecom_course->instructor_id ?? '' }}"> {{ $ecom_course->instructor->first_name ?? '- Select an Instructor -' }} </option>                                                    
                                                        <option disabled>───────────</option>                                                
                                                    @elseif ($instructors->count() == 0)
                                                            <option value="">-- choose Instructor first --</option>
                                                            <option disabled>───────────</option>   
                                                    @elseif ($instructors->count() != 0)
                                                            <option value="">-- choose Instructor --</option>
                                                            <option disabled>───────────</option>   
                                                    @endif

                                                    @foreach($instructors as $instructor)
                                                        <option value="{{ $instructor->id }}">{{ $instructor->full_name }}</option>
                                                    @endforeach 
                                            </select>
                                        </div>
                                    </div>
                                @endcan 
                        <!-- --------------- course Category --------------------  -->
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Category  <span class="danger">*</span></label>
                                    <select wire:model="ecom_course.category_id" name="category" class="form-control " required>
                                        @if($ecom_course->category_id)
                                        <option value="{{ $ecom_course->category_id ?? '' }}"> selected - {{ $ecom_course->category->name ?? '- Select Category -' }} </option>                                                    
                                            <option disabled>───────────</option>                                                
                                        @elseif ($categories->count() == 0)
                                            <option value="">-- choose category --</option>
                                            <option disabled>───────────</option>   
                                        @elseif ($categories->count() != 0)
                                            <option value="">-- choose category --</option>
                                            <option disabled>───────────</option>   
                                        @endif

                                        @foreach ($categories as $category)

                                                <option value="{{ $category->id }}">{{ $category->name }}</option>

                                        @endforeach
                                    </select>
                            </div>
                        </div>    
                        <!-- --------------- course Sub Category --------------------  -->
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Sub Category<span class="danger">*</span></label>
                                    <select wire:model="ecom_course.sub_category_id" name="subcategory" class="form-control " required>
                                    
                                    @if($ecom_course->sub_category_id)                                
                                        <option value="{{ $ecom_course->sub_category_id ?? '' }}"> {{ $ecom_course->subCategory->namme ?? '- Select a Sub Category -' }} </option>                                                    
                                        <option disabled>───────────</option>                                                
                                    @elseif ($subcategories->count() == 0)
                                            <option value="">-- choose parent category first --</option>
                                    @elseif ($subcategories->count() != 0)
                                            <option value="">-- choose subcategory --</option>
                                            <option disabled>───────────</option>   
                                    @endif

                                    @foreach ($subcategories as $category)
                                        @if($ecom_course->category_id != null)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                                            
                                    </select>
                            </div>
                        </div> 
                        <!-- --------------- course Duration --------------------  -->
                        <!-- <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Duration<span class="required">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.duration" id="duration" placeholder="Enter Duration" class="form-control">
                            </div>
                        </div> -->
                        <!-- --------------- course Level --------------------  -->
                        <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>Level <span class="required">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.level" id="name" placeholder="Enter Category level" class="form-control">
                            </div>
                        </div>
                        <!-- --------------- course Prerequisites --------------------  -->
                        <!-- <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>Prerequisites <span class="required">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.prerequisites" id="name" placeholder="Enter Category prerequisites" class="form-control">
                            </div>
                        </div> -->
                        <!-- --------------- course language --------------------  -->
                        <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>Language <span class="required">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.language" id="name" placeholder="Enter Category language" class="form-control">
                            </div>
                        </div>
                        <!-- --------------- course material --------------------  -->
                        <!-- <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>Course Material <span class="required">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.course_material" id="name" placeholder="Enter Category course_material" class="form-control">
                            </div>
                        </div> -->
                        <!-- --------------- course enrollment limit --------------------  -->
                        <!-- <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>Enrollment Limit <span class="required">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.enrollment_limit" id="name" placeholder="Enter Category enrollment_limit" class="form-control">
                            </div>
                        </div> -->
                        <!-- --------------- course start date --------------------  -->
                        <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                    <label>Start Date <span class="required">*</span></label>
                                <input type="date" wire:model.debounce.500ms="ecom_course.start_date" id="name" class="form-control">
                            </div>
                        </div>
                        <!-- --------------- course end date --------------------  -->
                        <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>End Date <span class="required">*</span></label>
                                <input type="date" wire:model.debounce.500ms="ecom_course.end_date" id="name" class="form-control">
                            </div>
                        </div>
                        <!-- --------------- course format --------------------  -->
                        <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>Course Format <span class="required">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.course_format" id="name" placeholder="Enter Category course_format" class="form-control">
                            </div>
                        </div>
                        <!-- --------------- course code --------------------  -->
                        <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>Course Code <span class="required">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.course_code" id="name" placeholder="Enter Category course_code" class="form-control">
                                @error('ecom_course.course_code') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <!-- --------------- tags --------------------  -->
                        <div class="col-md-6 col-lg-6 ">
                            <div class="form-group">
                                <label>Tags <span class="required">*</span></label>
                                <input type="text" wire:model.debounce.500ms="ecom_course.tags" id="name" placeholder="Enter Category tags" class="form-control">

                            </div>
                        </div>
                        <!-- --------------- course image upload --------------------  -->
                        <div class="col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="video">Upload Image</label>
                                        <input type="file" wire:model="photo" id="imageInput" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        @include('Admin.manage_course.course.preview-image')  
                                    </div>
                                </div>
                            </div>
                        </div> 
                        
                            <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary"> {{ $update ? 'Update Course' : 'Save Course' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->

    