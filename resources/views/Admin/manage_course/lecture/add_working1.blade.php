@push('styles')

<style>

    /* Set height for label and file input field */
    label, input[type="file"] {
        /* height: 100%; */
        display: flex;
        align-items: center; /* Vertically center content */
    }
    .deleteButtonForm
    {
        background-color: red;
        border-radius: 3px;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        margin-left: 10px;
        margin-top: 24px;
        display: none;
    }

</style>

@endpush


@if(Permission(32))
    <div class="row" id="addCategoryPanel">  
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                <h2> {{ $pageTitle }} </h2>
                    <ul class="nav navbar-right panel_toolbox justify-content-end">
                            <li>
                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul> 
                    <div class="clearfix"></div>

                </div>
                <div class="x_content {{ $Collapse  }}">
                    @foreach ($errors->all() as $key => $error)
                        <div class="col-mb-12 col-lg-12">
                            <div class="alert alert-danger" style="font-size: 13.5px;">
                                {{ $error }} !!!
                            </div>
                        </div>    
                    @endforeach

                    <div class="col-mb-12 col-lg-12">
                        <form wire:submit.prevent="saveLecture">

                            @csrf

                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Title<span class="danger">*</span></label>
                                    <input type="text" wire:model.debounce.500ms="ecom_lecture.title"  id="title" placeholder="Enter Title" class="form-control">
                                    <!-- @error('title') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Description<span class="danger">*</span></label>
                                    <input type="text" wire:model.debounce.500ms="ecom_lecture.description"  id="description" placeholder="Enter Description" class="form-control">
                                    <!-- @error('description') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                </div>
                            </div>

                            <!-- ========================= Instructor ======================================= -->

                            @if(auth()->user()->role->id == 1 || auth()->user()->role->id == 29  )

                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Instructor <span class="danger">*</span></label>
                                        <select wire:model.debounce.500ms="ecom_lecture.instructor_id"  name="instructor_id" id="instructor_id" class="form-control">
                                        
                                                @if($ecom_lecture->instructor_id)
                                                    <option value="{{ $ecom_lecture->instructor_id ?? '' }}"> {{ $ecom_lecture->instructor->first_name ?? '- Select an Instructor -' }} </option>                                                    
                                                    <option disabled>───────────</option>                                                
                                                @elseif ($instructors->count() == 0)
                                                        <option value="">-- choose Instructor first --</option>
                                                        <option disabled>───────────</option>   
                                                @elseif ($instructors->count() != 0)
                                                        <option value="">-- choose Instructor --</option>
                                                        <option disabled>───────────</option>   
                                                @endif

                                                @foreach($instructors as $instructor)
                                                    <option value="{{ $instructor->id }}">{{ $instructor->first_name }}</option>
                                                @endforeach 
                                        </select>
                                    </div>
                                </div>

                            @endif 


                            <!-- ========================= Course ======================================= -->

                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Course <span class="danger">*</span></label>
                                    <select wire:model.debounce.500ms="ecom_lecture.course_id"  name="course_id" id="course_id" class="form-control">
                                    
                                            @if($ecom_lecture->course_id)
                                                <option value="{{ $ecom_lecture->course_id ?? '' }}"> {{ $ecom_lecture->Course->name ?? '- Select A Course -' }} </option>                                                    
                                                <option disabled>───────────</option>                                                  
                                            @elseif ($courses->count() != 0)
                                                    <option value="">-- choose Course --</option>
                                                    <option disabled>───────────</option>   
                                            @endif

                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach 
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Duration<span class="required">*</span></label>
                                    <input type="text" wire:model.debounce.500ms="ecom_lecture.duration" id="duration" placeholder="Enter Duration" class="form-control">
                                    <!-- @error('duration') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Lecture Tag </label>
                                    <input type="text" wire:model.debounce.500ms="ecom_lecture.tags" placeholder="Enter Lecture tags" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="video">Upload Video</label>
                                            <input type="file" wire:model.debounce.500ms="video" id="video" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            @include('Admin.manage_course.lecture.preview-video')  
                                            <!-- <label for="video" style="padding-top: 30px;">Please upload video</label> -->
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="video_url">Video URL</label>
                                    <input type="text" wire:model.debounce.500ms="video_url" class="form-control" id="video_url" name="video_url" placeholder="Enter video URL">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="document">Upload Document</label>
                                            <input type="file" wire:model.debounce.500ms="document" id="document" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        @include('Admin.manage_course.lecture.preview-document')  
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="document_url">Document URL</label>
                                    <input type="text" wire:model.debounce.500ms="document_url" class="form-control" id="document_url" name="document_url" placeholder="Enter document URL">
                                </div>
                            </div>
                            <!-- <div class="col-md-6 col-lg-6">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="video">Upload Image</label>
                                            <input type="file" wire:model.debounce.500ms="photo" id="imageInput" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            @include('Admin.manage_course.lecture.preview-image')  
                                        </div>
                                    </div>
                                </div>
                            </div>  -->



                            <div id="AssessmentDiv" class="col-md-12" style="border: 16px solid #ccc; padding: 15px; margin: 10px;">
                            
                                <div id="questionDiv" class="col-md-12" style="padding: 15px;">
                                    <div class="col-md-12" style="border: 1px solid #ccc; "> 
                                        <div class="col-md-12 col-lg-12 form-group">
                                            <div class="form-group">
                                                <label for="document_url" class="text-center col-lg-12" style="padding-top:10px;">Question 1 </label>
                                                <input type="text" wire:model.debounce.500ms="question1" class="form-control" id="document_url" name="questions1[]" placeholder="Enter Question">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 form-group">
                                            <div class="form-group">
                                                <label for="document_url">Answer 1 </label>
                                                <input type="text" wire:model.debounce.500ms="question1" class="form-control" id="document_url" name="questions1[]" placeholder="Enter Answer">
                                            </div>
                                        </div>     
                                        <div class="col-md-6 col-lg-6 form-group ">
                                            <div class="form-group">
                                                <label for="document_url">Answer 2 </label>
                                                <input type="text" wire:model.debounce.500ms="question1" class="form-control" id="document_url" name="questions1[]" placeholder="Enter Answer">
                                            </div>
                                        </div>     
                                        <div class="col-md-6 col-lg-6 form-group ">
                                            <div class="form-group">
                                                <label for="document_url">Answer 3 </label>
                                                <input type="text" wire:model.debounce.500ms="question1" class="form-control" id="document_url" name="questions1[]" placeholder="Enter Answer">
                                            </div>
                                        </div>     
                                        <div class="col-md-6 col-lg-6 form-group ">
                                            <div class="form-group">
                                                <label for="document_url">Answer 4 </label>
                                                <input type="text" wire:model.debounce.500ms="question1" class="form-control" id="document_url" name="questions1[]" placeholder="Enter Answer">
                                            </div>
                                        </div>   
                                        <div class="form-group col-md-12">
                                                    <button class="delete-row-button new-row-1711435788501 deleteButtonForm deleteQuestion float-right"> 
                                                        Delete</button>
                                        </div>   
                                    </div>
                                </div> 
                                <div class="col-md-12 form-group">
                                    <button type="button" 
                                            onclick="DuplicateQuestion()" 
                                            class="btn btn-warning clone-table-button ci-btn-secondary float-right" 
                                            style="padding: 10px 10px; margin: 10px" 
                                            data-target="kyc_from_1">Add More Question </button>
                                </div> 
                                <!-- <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="document_url">Question 2 </label>
                                        <input type="text" wire:model.debounce.500ms="question2" class="form-control" id="document_url" name="questions1[]" placeholder="Enter document URL">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="document_url">Question 3 </label>
                                        <input type="text" wire:model.debounce.500ms="question3" class="form-control" id="document_url" name="questions1[]" placeholder="Enter document URL">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="document_url">Question 4 </label>
                                        <input type="text" wire:model.debounce.500ms="question4" class="form-control" id="document_url" name="questions1[]" placeholder="Enter document URL">
                                    </div>
                                </div> -->
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="document_url">Duration occurance </label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="occurrence_duration" name="occurrence_duration" placeholder="Enter duration">
                                            <div class="input-group-append">
                                                <span class="input-group-text">minutes</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                            <button class="delete-row-button new-row-1711435788501 deleteButtonForm deleteAssessment deleteButtonForm1 float-right"> 
                                                Delete</button>
                                </div> 
                            </div>

                            <div class="form-group col-md-12">
                                <button type="button" 
                                        onclick="Duplicate_Form1()" 
                                        class="btn btn-primary clone-table-button ci-btn-secondary float-right" 
                                        style="padding: 10px 10px; margin-bottom: 10px;" 
                                        data-target="kyc_from_1">Add Assessment </button>
                            </div> 

                            <!-- <div id="form-container"></div> -->
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif


@push('scripts')

    <script>

        var AssessmentLevel=1;
        var QuestionLevel=1;

        let person = {
            AssessmentLevel: "John",
        };

        function Duplicate_Form1(data = null) 
        {
            if(AssessmentLevel == 4)
            {
                Swal.fire({
                    icon: 'error', 
                    title: 'Oops...',
                    text: 'You can add only ' + AssessmentLevel + ' assessments!',
                });

                return false;
            }

            var clonedDiv = $('#AssessmentDiv').clone();
            clonedDiv.attr('id', 'AssessmentDiv' + AssessmentLevel);    // AssessmentDiv AssessmentDiv1 AssessmentDiv2
            clonedDiv.find('.deleteButtonForm1').css('display', 'block').attr('data-parent_id', 'AssessmentDiv' + AssessmentLevel);


            if(AssessmentLevel == 1)
            {
                $('#AssessmentDiv').last().after(clonedDiv);
            }
            else
            {
                $('#AssessmentDiv' + (AssessmentLevel - 1)).last().after(clonedDiv);  // AssessmentDiv1
            }

            AssessmentLevel = AssessmentLevel+1;
        }
        $(document).on('click', '.deleteAssessment', function(event) 
        {
            event.preventDefault();  
            parent_div_id  = $(this).attr('data-parent_id'); 
            $(this).closest('div[id^=' + parent_div_id + ']').remove();
            AssessmentLevel = AssessmentLevel - 1;
        });

        function DuplicateQuestion(data = null)
        {
            if(QuestionLevel == 4)
            {
                Swal.fire({
                    icon: 'error', 
                    title: 'Oops...',
                    text: 'You can add only ' + (QuestionLevel) + ' questions!',
                });

                return false;
            }

            var clonedDiv = $('#questionDiv').clone();
            clonedDiv.attr('id', 'questionDiv' + QuestionLevel); 
            clonedDiv.find('.deleteQuestion').css('display', 'block').attr('data-parent_id', 'questionDiv' + QuestionLevel);

            if(QuestionLevel == 1)
            {
                $('#questionDiv').last().after(clonedDiv);
            }
            else
            {
                $('#questionDiv' + (QuestionLevel - 1)).last().after(clonedDiv);  // questionDiv1
            }

            // $('#questionDiv').last().after(clonedDiv);
            QuestionLevel = QuestionLevel+1;
        }

        $(document).on('click', '.deleteQuestion', function(event) {
            
            event.preventDefault();                   
            parent_div_id  = $(this).attr('data-parent_id'); 
            $(this).closest('div[id^=' + parent_div_id + ']').remove();
            QuestionLevel = QuestionLevel - 1;
        });
     


    </script>


@endpush