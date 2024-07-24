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
    .deleteButtonEditForm
    {
        background-color: red;
        border-radius: 3px;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        margin-left: 10px;
        margin-top: 24px;
        /* display: none; */
    }
    .NoAssessmentRequired
    {
        background-color: red;
        border-radius: 3px;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        margin-left: 10px;
        margin-top: 24px;
        /* display: none; */
    }
    .AssessmentRequired
    {
        background-color: red;
        border-radius: 3px;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        margin-left: 10px;
        margin-top: 24px;
        /* display: none; */
    }

</style>

@endpush



    <div class="row" id="addCategoryPanel">  
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
                        <form id="lectureForm">

                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Title <span class="danger">*</span></label>
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

                                @can('select_instructor')
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label>Instructor <span class="danger">*</span></label>
                                            <select wire:model.debounce.500ms="ecom_lecture.instructor_id"  name="instructor_id" id="instructor_id" class="form-control" required>
                                            
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
                                                        <option value="{{ $instructor->id }}">{{ $instructor->full_name }}</option>
                                                    @endforeach 
                                            </select>
                                        </div>
                                    </div>
                                @endcan 

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
                            <!-- ========================= Duration ======================================= -->
                                <!-- <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Duration<span class="required">*</span></label>
                                        <input type="text" wire:model.debounce.500ms="ecom_lecture.duration" id="duration" placeholder="Enter Duration" required class="form-control">
                                    </div>
                                </div> -->
                            <!-- ========================= Tags ======================================= -->
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Lecture Tag </label>
                                    <input type="text" wire:model.debounce.500ms="ecom_lecture.tags" placeholder="Enter Lecture tags" class="form-control">
                                </div>
                            </div>
                            <!-- ========================= video ======================================= -->
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
                            <div class="col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="passing_ratio">Passing % </label>
                                    <input type="text" wire:model.debounce.500ms="ecom_lecture.passing_ratio" class="form-control" id="passing_ratio" name="passing_ratio" placeholder="Enter Course Passing % On the basis of Questions">
                                </div>
                            </div>

                            @php  
                                $count=0
                            @endphp

                                <div class="col-md-12">
                                    <button 
                                            wire:ignore 
                                            id="noAssessmentButton" 
                                            style="padding-top: 10px; display:none;"
                                            class="btn btn-danger NoAssessmentRequired float-right" 
                                            style="margin-bottom: 15px;">
                                            No Assessments Update Required
                                    </button>
                                </div>
                                <div class="col-md-12"> 
                                    <button 
                                        wire:ignore  
                                        id="AssessmentButton"
                                        class="btn btn-warning clone-table-button ci-btn-secondary float-right" 
                                        style="padding: 10px 10px; margin: 10px">
                                        Show Assessment Forms</button>
                                </div>

                            <!-- ==================================Assessment========================================== -->
                            @if(count($assessmentData) > 0)
                                    @foreach($assessmentData as $assessmentLevel => $assessment)    
                                        
                                    @php  
                                        $AssessmentDiv = $assessmentLevel == 0 ? 'AssessmentDiv' : 'AssessmentDiv'.$assessmentLevel;  
                                        $AssessmentDiv = $assessmentLevel == 0 ? 'AssessmentDiv' : 'AssessmentDiv'.$assessmentLevel;  
                                        $count++;
                                        $AssessmentDivcount = 'Assessment '.$count;
                                    @endphp  

                                    <div id="{{ $AssessmentDiv }}" class="col-md-12" style="border: 16px solid #ccc; padding: 15px; margin: 10px;">
                                        <label class="Title" style="justify-content: center;"> <b><i> <u> {{ $AssessmentDivcount }} </u> </i></b></label>
                                        @if(isset($assessment['questions']))
                                            @php 
                                                $countQuestions=0   
                                            @endphp  

                                            @php  
                                                $Questioncount=0
                                            @endphp


                                            @foreach($assessment['questions'] as $question)

                                                @php  
                                                    if($assessmentLevel == 0)
                                                    {
                                                        $questionDiv = 'questionDiv';
                                                    }
                                                    else if($assessmentLevel == 1)
                                                    {   
                                                        $questionDiv = 'questionDivFirst';
                                                    }
                                                    else if($assessmentLevel == 2)
                                                    {
                                                        $questionDiv = 'questionDivSecond';
                                                    }
                                                    else if($assessmentLevel == 3)
                                                    {
                                                        $questionDiv = 'questionDivThird';
                                                    }

                                                    $questionDiv = $countQuestions == 0 ? $questionDiv : $questionDiv.$countQuestions;  


                                                    $Questioncount++;
                                                    $QuestionDivcount = 'Question '.$Questioncount;

                                                @endphp
                                        
                                                
                                                <div id="{{ $questionDiv }}" class="col-md-12 ChildOfParent" style="padding: 15px;" data-parent_id="{{ $AssessmentDiv }}">
                                                    <div class="col-md-12" style="border: 1px solid #ccc; "> 
                                                        <label class="ChildTitle" style="margin-top: 10px; justify-content: center;"> <b> {{ $QuestionDivcount }} </b></label>
                                                        <div class="col-md-12 col-lg-12 form-group">
                                                            <div class="form-group">
                                                                <label for="document_url" class="text-center col-lg-12" style="padding-top:10px;">Question</label>
                                                                <input type="text" value="{{ isset($question['question']) ? $question['question'] : '' }}" class="form-control" id="question" name="question" placeholder="Enter Question">
                                                            </div>
                                                        </div>
                                                        @if(isset($question['answer']))

                                                            @php 
                                                                $answers = json_decode($question['answer']);
                                                                $AnswerCount=0;
                                                            @endphp 

                                                           @if(!empty($answers)) 
                                                                @foreach($answers as $key => $answer)
                                                                    @if($key != 'correctAnswer')
                                                                        <div class="col-md-6 col-lg-6 form-group">
                                                                            <div class="form-group">
                                                                                <label for="{{ $key }}">{{ $key }}</label>
                                                            
                                                                                @php 
                                                                                    $RadioID = ($AnswerCount == 0) ? 'RadioAnswer'.$questionDiv : 'RadioAnswer'.$AnswerCount.$questionDiv;
                                                                                @endphp  
                                                            
                                                                                
                                                                                @if($key == $answers->correctAnswer)
                                                                                    <input type="radio" checked value="{{ $key }}" id="{{ $RadioID }}" name="{{ $questionDiv }}RadioAnswer"> <span class="checkmark"></span> 
                                                                                @else 
                                                                                    <input type="radio" value="{{ $key }}" id="{{ $RadioID }}" name="{{ $questionDiv }}RadioAnswer"> <span class="checkmark"></span> 
                                                                                @endif 
                                                                                <input type="text"  value="{{ $answer }}" class="form-control" id="{{ $key }}" name="Answer1" placeholder="Enter Answer">
                                                                            </div>
                                                                        </div>    

                                                                        @php $AnswerCount++; @endphp
                                                                    @endif
                                                                @endforeach 
                                                            @endif
                                                        @endif

                                                        @if($countQuestions != 0)
                                                            <div class="form-group col-md-12">
                                                                        <button class="delete-row-button new-row-1711435788501 deleteButtonEditForm deleteQuestion float-right"
                                                                        data-parent_id="{{ $questionDiv }}"
                                                                        data-grand-parent_id="{{ $AssessmentDiv }}"
                                                                        data-current-question-quantity = "{{ count($assessment['questions']) }} "
                                                                        > 
                                                                            Delete Question Section {{ count($assessment['questions']) }} </button>
                                                            </div>   
                                                        @else
                                                            <div class="form-group col-md-12">
                                                                        <button class="delete-row-button new-row-1711435788501 deleteButtonForm deleteQuestion float-right"
                                                                        data-parent_id="{{ $questionDiv }}"
                                                                        data-grand-parent_id="{{ $AssessmentDiv }}"
                                                                        data-current-question-quantity = "{{ count($assessment['questions']) }} "
                                                                        > 
                                                                            Delete Question Section  </button>
                                                            </div>
                                                        @endif 
                                
                                                    </div>
                                                </div> 
                                                @php  $countQuestions++ @endphp 
                                            @endforeach 
                                        @endif 
                                    

                                        <div class="col-md-12 form-group">
                                            <button type="button" 
                                            
                                                    class="AddMoreQuestion btn btn-warning clone-table-button ci-btn-secondary float-right" 
                                                    style="padding: 10px 10px; margin: 10px" 
                                                    data-current-question-quantity = "{{ count($assessment['questions']) }} "
                                                    data-target="kyc_from_1">
                                                    Add More Question {{ count($assessment['questions']) }} 
                                            </button>
                                        </div> 
            
                                        <div class="col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="document_url">Duration occurance </label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control occurrence_duration" value="{{ $assessment['assessment_time'] }}" id="occurrence_duration" name="occurrence_duration" placeholder="Enter duration">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Seconds</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($AssessmentDiv == 'AssessmentDiv')
                                            <div class="form-group col-md-6">
                                                <button class="delete-row-button new-row-1711435788501 deleteButtonForm deleteAssessment deleteButtonForm1 float-right" data-parent_id="{{ $AssessmentDiv }}"> 
                                                            Delete Assessment Section </button>
                                            </div>
                                        @else
                                            <div class="form-group col-md-6">
                                                <button class="delete-row-button new-row-1711435788501 deleteButtonEditForm deleteAssessment deleteButtonForm1 float-right" data-parent_id="{{ $AssessmentDiv }}"> 
                                                    Delete Assessment Section </button>
                                            </div> 
                                        @endif 


                                    </div> 

                                    <!-- ==================================Assessment========================================== -->
                                    @endforeach
                            @else 


                                <div id="AssessmentDiv" class="col-md-12" wire:ignore  style="display:none; border: 16px solid #ccc; padding: 15px; margin: 10px;">
                                    <label class="Title" style="justify-content: center;"> <b><i> <u> Assessment 1 </u> </i></b></label>

                                    <div id="questionDiv" class="col-md-12 ChildOfParent" style="padding: 15px;" data-parent_id="AssessmentDiv">
                                        <div class="col-md-12" style="border: 1px solid #ccc; "> 
                                            <label class="ChildTitle" style="margin-top: 10px; justify-content: center;"> <b>Question 1</b></label>
                                            <div class="col-md-12 col-lg-12 form-group">
                                                <div class="form-group">
                                                    <label for="document_url" class="text-center col-lg-12" style="padding-top:10px;">Question </label>
                                                    <input type="text"  class="form-control" id="question" name="question" placeholder="Enter Question">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 form-group">
                                                <div class="form-group">
                                                    <label for="Answer1">Answer 1 </label>
                                                    <input type="radio" value="Answer1" id="RadioAnswerquestionDiv" name="questionDivRadioAnswer"> <span class="checkmark"></span> 
                                                    <input type="text"  class="form-control" id="Answer1" name="Answer1" placeholder="Enter Answer">
                                                </div>
                                            </div>     
                                            <div class="col-md-6 col-lg-6 form-group ">
                                                <div class="form-group">
                                                    <label for="Answer2">Answer 2 </label>
                                                    <input type="radio" value="Answer2" id="RadioAnswer1questionDiv" name="questionDivRadioAnswer"> <span class="checkmark"></span> 
                                                    <input type="text"  class="form-control" id="Answer2" name="Answer2" placeholder="Enter Answer">
                                                </div>
                                            </div>     
                                            <div class="col-md-6 col-lg-6 form-group ">
                                                <div class="form-group">
                                                    <label for="Answer3">Answer 3 </label>
                                                    <input type="radio" value="Answer3" id="RadioAnswer2questionDiv" name="questionDivRadioAnswer"> <span class="checkmark"></span> 
                                                    <input type="text"  class="form-control" id="Answer3" name="Answer3" placeholder="Enter Answer">
                                                </div>
                                            </div>     
                                            <div class="col-md-6 col-lg-6 form-group lastquestion">
                                                <div class="form-group">
                                                    <label for="Answer4">Answer 4 </label>
                                                    <input type="radio" value="Answer4" id="RadioAnswer3questionDiv" name="questionDivRadioAnswer"> <span class="checkmark"></span> 
                                                    <input type="text"  class="form-control" id="Answer4" name="Answer4" placeholder="Enter Answer">
                                                </div>
                                            </div>   
                                            <div class="form-group col-md-12">
                                                        <button class="delete-row-button new-row-1711435788501 deleteButtonForm deleteQuestion float-right"> 
                                                            Delete Question Section </button>
                                            </div>   
                                        </div>
                                    </div> 
                                    <div class="col-md-12 form-group">
                                        <button type="button" wire:ignore
                                        
                                                class="AddMoreQuestion btn btn-warning clone-table-button ci-btn-secondary float-right" 
                                                style="padding: 10px 10px; margin: 10px" 
                                                data-target="kyc_from_1">Add More Question </button>
                                    </div> 
        
                                    <div class="col-md-6 col-lg-6">
                                        <div class="form-group">
                                            <label for="document_url">Duration occurance </label>
                                            <div class="input-group">
                                                <input type="number" class="form-control occurrence_duration" id="occurrence_duration" name="occurrence_duration" placeholder="Enter duration" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Seconds</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                                <button class="delete-row-button new-row-1711435788501 deleteButtonForm deleteAssessment deleteButtonForm1 float-right"> 
                                                    Delete Assessment Section </button>
                                    </div> 
                                </div> 

                            @endif 
                            <!-- ==================================Assessment========================================== -->

                            <div class="form-group col-md-12">
                                <button type="button"  wire:ignore  style="display:none; padding: 10px 10px; margin-bottom: 10px;"
                                        class="AddAssessment btn btn-primary clone-table-button ci-btn-secondary float-right" 
                                        data-target="kyc_from_1">Add Assessment</button>
                            </div> 

                            <!-- <div id="form-container"></div> -->
                            <div class="col-md-12 col-lg-12">
                                <div class="form-group">
                                    <button type="submit" id="FormSubmission" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




@push('scripts')
    <script src="{{ url_secure('build/js/livewire/lecture.js')}}"></script>
    <script>

        var update = false;
        var ValidateAssessmentForm = true;
        var AssessmentEditCount = {!! json_encode(count($assessmentData)) !!};

        if(AssessmentEditCount > 0)
        {
            var AssessmentLevel=AssessmentEditCount;
            var update = {!! json_encode($update) !!};
        }
        else
        {
            var AssessmentLevel=1;
        }
        if(!update)
        {
            var QuestionLevel=1;
            var QuestionFirstLevel=1;
            var QuestionSecondLevel=1;
            var QuestionThirdLevel=1;
        }
        else
        {
            var QuestionLevel;
            var QuestionFirstLevel;
            var QuestionSecondLevel;
            var QuestionThirdLevel;
        }

        var LectureAssessmentData = {};

        $(document).ready(function ()
        {
            // if assessment has data, show it on load, and also show the button Show Assessment Forms
            UpdateHiddenStatusOfAssessmentDivs();      
        });

        $(document).on('click', '#FormSubmission', function(event) 
        {
            event.preventDefault();

            if(!ValidateAssessmentForm)
            {
                // alert('submit form assessment');
                // return false;

                if(CheckOccurrencesDuration() !== false)
                {
                    if(GetFinalData() !== false)
                    {
                        Livewire.emit('lectureSubmitted', JSON.stringify(GetFinalData()));
                    }
                    else
                    {
                        console.error('validation failed');
                    }
                }
                else
                {
                    console.error('validation failed for assessment durations ');
                }
            }
            else
            {      
                // alert('submit without assessment');
                // return false;
            
                Livewire.emit('lectureSubmitted');
            }
            // alert(ValidateAssessmentForm);
            // return false;
            // if(!ValidateAssessmentForm)
                // {
                //     if(CheckOccurrencesDuration() == false)
                //     {
                //         console.error('validation failed');
                //         retur false;
                //     }
                // }
                // if(GetFinalData() !== false)
                // {
                //     // return false;
                //     Livewire.emit('lectureSubmitted', JSON.stringify(GetFinalData()));
                // }
                // else
                // {
                //     console.error('validation failed');
                // }

                // if(CheckOccurrencesDuration() !== false)
                // {
                //     if(GetFinalData() !== false)
                //     {
                //         // return false;
                //         Livewire.emit('lectureSubmitted', JSON.stringify(GetFinalData()));
                //     }
                //     else
                //     {
                //         console.error('validation failed');
                //     }
                // }
                // else
                // {
                //     console.error('validation failed for assessment durations ');
            // }
        });  
        $(document).on('click', '#AssessmentButton, #noAssessmentButton', function(event) 
        {
            event.preventDefault();
            UpdateShowOrHideAsessments(this.id === 'noAssessmentButton', $(this));
        });
        $(document).on('click', '.AddAssessment', function(event)
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
            clonedDiv.find('.deleteAssessment').css('display', 'block').attr('data-parent_id', 'AssessmentDiv' + AssessmentLevel);
            clonedDiv.find('.Title').html('<b><i><u>Assessment ' + (AssessmentLevel+1) + '</u></i></b>');


            if(AssessmentLevel==1)
            {
                clonedDiv.find('#questionDiv').attr('id', 'questionDivFirst').attr('data-parent_id', 'AssessmentDiv' + AssessmentLevel);  
                clonedDiv.find('[data-parent_id="AssessmentDiv"]').not('#questionDiv').remove();

                RadioButton = clonedDiv.find('#RadioAnswerquestionDiv');
                RadioButton.attr('id', 'RadioAnswerquestionDivFirst').attr('name', 'questionDivFirst' + 'RadioAnswer');
                RadioButton = clonedDiv.find('#RadioAnswer1questionDiv');
                RadioButton.attr('id', 'RadioAnswer1questionDivFirst').attr('name', 'questionDivFirst' + 'RadioAnswer');
                RadioButton = clonedDiv.find('#RadioAnswer2questionDiv');
                RadioButton.attr('id', 'RadioAnswer2questionDivFirst').attr('name', 'questionDivFirst' + 'RadioAnswer');
                RadioButton = clonedDiv.find('#RadioAnswer3questionDiv');
                RadioButton.attr('id', 'RadioAnswer3questionDivFirst').attr('name', 'questionDivFirst' + 'RadioAnswer');

                // Assessment1 Question1
                // --------------------------------
                // questionDivRadioAnswer
                // questionDivRadioAnswer
                // questionDivRadioAnswer
                // questionDivRadioAnswer


                // Assessment2 Question1
                // --------------------------------
                // questionDivFirstRadioAnswer
                // questionDivFirstRadioAnswer
                // questionDivFirstRadioAnswer
                // questionDivFirstRadioAnswer


                // Assessment3 Question1
                // --------------------------------
                // questionDivSecondRadioAnswer
                // questionDivSecondRadioAnswer
                // questionDivSecondRadioAnswer

                // Assessment4 Question1
                // --------------------------------
                // questionDivThirdRadioAnswer
                // questionDivThirdRadioAnswer
                // questionDivThirdRadioAnswer
                // questionDivThirdRadioAnswer
    
                if(update)
                {
                    clonedDiv.find('.AddMoreQuestion').attr('data-current-question-quantity', 1);
                } 
            }
            else if(AssessmentLevel==2)
            {
                clonedDiv.find('#questionDiv').attr('id', 'questionDivSecond').attr('data-parent_id', 'AssessmentDiv' + AssessmentLevel);
                clonedDiv.find('[data-parent_id="AssessmentDiv"]').not('#questionDiv').remove();  

                RadioButton = clonedDiv.find('#RadioAnswerquestionDiv');
                RadioButton.attr('id', 'RadioAnswerquestionDivSecond').attr('name', 'questionDivSecond' + 'RadioAnswer');
                RadioButton = clonedDiv.find('#RadioAnswer1questionDiv');
                RadioButton.attr('id', 'RadioAnswer1questionDivSecond').attr('name', 'questionDivSecond' + 'RadioAnswer');
                RadioButton = clonedDiv.find('#RadioAnswer2questionDiv');
                RadioButton.attr('id', 'RadioAnswer2questionDivSecond').attr('name', 'questionDivSecond' + 'RadioAnswer');
                RadioButton = clonedDiv.find('#RadioAnswer3questionDiv');
                RadioButton.attr('id', 'RadioAnswer3questionDivSecond').attr('name', 'questionDivSecond' + 'RadioAnswer');

                if(update)
                {
                    clonedDiv.find('.AddMoreQuestion').attr('data-current-question-quantity', 1);
                } 
            }
            else if(AssessmentLevel==3)
            {
                clonedDiv.find('#questionDiv').attr('id', 'questionDivThird').attr('data-parent_id', 'AssessmentDiv' + AssessmentLevel);  
                clonedDiv.find('[data-parent_id="AssessmentDiv"]').not('#questionDiv').remove(); 

                RadioButton = clonedDiv.find('#RadioAnswerquestionDiv');
                RadioButton.attr('id', 'RadioAnswerquestionDivThird').attr('name', 'questionDivThird' + 'RadioAnswer');
                RadioButton = clonedDiv.find('#RadioAnswer1questionDiv');
                RadioButton.attr('id', 'RadioAnswer1questionDivThird').attr('name', 'questionDivThird' + 'RadioAnswer');
                RadioButton = clonedDiv.find('#RadioAnswer2questionDiv');
                RadioButton.attr('id', 'RadioAnswer2questionDivThird').attr('name', 'questionDivThird' + 'RadioAnswer');
                RadioButton = clonedDiv.find('#RadioAnswer3questionDiv');
                RadioButton.attr('id', 'RadioAnswer3questionDivThird').attr('name', 'questionDivThird' + 'RadioAnswer');
                
                if(update)
                {
                    clonedDiv.find('.AddMoreQuestion').attr('data-current-question-quantity', 1);
                } 
            }

            // clonedDiv.find('.deleteAssessment').css('display', 'block').attr('data-parent_id', 'AssessmentDiv' + AssessmentLevel);
            
            // Verify if the element has .deleteAssessment class and its display is set to block
            // var deleteAssessmentElement = clonedDiv.find('.deleteAssessment');
            // if (deleteAssessmentElement.length && deleteAssessmentElement.css('display') === 'block' ) {
            //     console.log('.deleteAssessment element exists and its display is set to block.');
            // } else {
            //     console.error('.deleteAssessment element is either missing or its display is not set to block.');
            // }

            if(AssessmentLevel == 1)
            {
                $('#AssessmentDiv').last().after(clonedDiv);
            }
            else
            {
                $('#AssessmentDiv' + (AssessmentLevel - 1)).last().after(clonedDiv);  // AssessmentDiv1
            }

            AssessmentLevel = AssessmentLevel+1;
        
        });
        $(document).on('click', '.deleteAssessment', function(event) 
        {
            event.preventDefault();  
            
            parentID  = $(this).attr('data-parent_id'); 
            $(this).closest('div[id^=' + parentID + ']').remove();
            SortQuestionsDivs(parentID, "NotAny", 1, 'deleteAssessment');
            AssessmentLevel = AssessmentLevel - 1;
        });
        $(document).on('click', '.AddMoreQuestion', function(event) 
        {   
            var parentID = $(this).closest('[id]').attr('id');

            if(parentID == 'AssessmentDiv')
            {
                // ============================== testing ==============================
                    if(update)
                    {
                        QuestionLevel = $(this).attr('data-current-question-quantity');
                        QuestionLevel = Number(QuestionLevel);
                    }                
                    if(QuestionLevel == 4 || QuestionLevel > 4)
                    {
                        Swal.fire({
                            icon: 'error', 
                            title: 'Oops...',
                            text: 'You can add only ' + (QuestionLevel) + ' questions!',
                        });

                        return false;
                    }
                    
                    let questionDivClone = $('#questionDiv').clone();
                    questionDivClone.attr('id', 'questionDiv' + QuestionLevel); 
                    questionDivClone.find('.ChildTitle').html('<b><i><u>Question ' + (QuestionLevel+1) + '</u></i></b>');
                    questionDivClone.find('.deleteQuestion').css('display', 'block').attr('data-parent_id', 'questionDiv' + QuestionLevel).attr('data-grand-parent_id', parentID);

                    if (update) 
                    {
                        questionDivClone.find('.deleteQuestion')
                            .attr('data-current-question-quantity', QuestionLevel);
                    }
                // ============================== testing ==============================

                // var DivID = 'questionDiv';
                // var LevelID = QuestionLevel;

                // for (var i = 0; i <= 3; i++) 
                // {
                //     // var selector = (i === 0) ? '#' + DivID + 'RadioAnswer' : '#' + DivID + 'RadioAnswer' + i;
                //     var selector = '#' + 'RadioAnswer' + DivID;
                    
                //     RadioClone = questionDivClone.find(selector);
                //     RadioClone.attr('id', 'RadioAnswer' + DivID + LevelID);
                //     RadioClone.attr('name', DivID + LevelID + 'RadioAnswer');
                // }
                // return false;

                RemoveDuplicationForAddQuestion(questionDivClone, 'questionDiv', QuestionLevel)

                // ============================== testing ==============================

                    if(QuestionLevel == 1)
                    {
                        $('#questionDiv').last().after(questionDivClone);
                    }
                    else
                    {
                        $('#questionDiv' + (QuestionLevel - 1)).last().after(questionDivClone);  // questionDiv questionDiv1  questionDiv2
                    }

                    QuestionLevel = QuestionLevel+1;   

                    if(update)
                    {
                        $(this).attr('data-current-question-quantity', QuestionLevel);
                    }
                // ============================== testing ==============================

            }
            else if(parentID == 'AssessmentDiv1')
            {
                // ============================== testing ==============================

                    if(update)
                    {
                        QuestionFirstLevel = $(this).attr('data-current-question-quantity');
                        QuestionFirstLevel = Number(QuestionFirstLevel);
                        // $(this).attr('data-current-question-quantity', (QuestionFirstLevel + 1));
                        // var issetparentID = $('div[id^=' + parentID + ']');       // get questionDiv,

                        // alert(issetparentID.length);
                        // return false;
                        // clonedDiv.find('#questionDiv').attr('id', 'questionDivFirst').attr('data-parent_id', 'AssessmentDiv' + AssessmentLevel);  
                    }

                    if(QuestionFirstLevel == 4)
                    {
                        Swal.fire({
                            icon: 'error', 
                            title: 'Oops...',
                            text: 'You can add only ' + (QuestionFirstLevel) + ' questions!',
                        });

                        return false;
                    }          
                
                    var questionDivClone = $('#questionDivFirst').clone();
                    questionDivClone.attr('id', 'questionDivFirst' + QuestionFirstLevel); 
                    questionDivClone.find('.ChildTitle').html('<b><i><u>Question ' + (QuestionFirstLevel+1) + '</u></i></b>');
                    questionDivClone.find('.deleteQuestion').css('display', 'block').attr('data-parent_id', 'questionDivFirst' + QuestionFirstLevel).attr('data-grand-parent_id', parentID);

                    if (update) 
                    {
                        questionDivClone.find('.deleteQuestion')
                            .attr('data-current-question-quantity', QuestionFirstLevel);
                    }
                // ============================== testing ==============================

                RemoveDuplicationForAddQuestion(questionDivClone, 'questionDivFirst', QuestionFirstLevel)

                // ============================== testing ==============================

                    if(QuestionFirstLevel == 1)
                    {
                        $('#questionDivFirst').last().after(questionDivClone);
                    }
                    else
                    {
                        $('#questionDivFirst' + (QuestionFirstLevel - 1)).last().after(questionDivClone);  // questionDivFirst1
                    }

                    QuestionFirstLevel = QuestionFirstLevel+1;  

                    if(update)
                    {
                        $(this).attr('data-current-question-quantity', QuestionFirstLevel);
                    } 
                // ============================== testing ==============================
              
            }
            else if(parentID == 'AssessmentDiv2')
            {
                // ============================== testing ==============================
                    if(update)
                    {
                        QuestionSecondLevel = $(this).attr('data-current-question-quantity');
                        QuestionSecondLevel = Number(QuestionSecondLevel);
                        // $(this).attr('data-current-question-quantity', (QuestionSecondLevel++));
                    }

                    if(QuestionSecondLevel == 4)
                    {
                        Swal.fire({
                            icon: 'error', 
                            title: 'Oops...',
                            text: 'You can add only ' + (QuestionSecondLevel) + ' questions!',
                        });

                        return false;
                    }

                    var questionDivClone = $('#questionDivSecond').clone();
                    questionDivClone.attr('id', 'questionDivSecond' + QuestionSecondLevel); 
                    questionDivClone.find('.ChildTitle').html('<b><i><u>Question ' + (QuestionSecondLevel+1) + '</u></i></b>');
                    questionDivClone.find('.deleteQuestion').css('display', 'block').attr('data-parent_id', 'questionDivSecond' + QuestionSecondLevel).attr('data-grand-parent_id', parentID);
                // ============================== testing ==============================

                RemoveDuplicationForAddQuestion(questionDivClone, 'questionDivSecond', QuestionSecondLevel)

                // ============================== testing ==============================
                    if (update) 
                    {
                        questionDivClone.find('.deleteQuestion')
                            .attr('data-current-question-quantity', QuestionSecondLevel);
                    }

                    // questionDivClone.find('.deleteQuestion').css('display', 'block').attr('data-parent_id', 'questionDivSecond' + QuestionSecondLevel).attr('data-grand-parent_id', parentID);

                    if(QuestionSecondLevel == 1)
                    {
                        $('#questionDivSecond').last().after(questionDivClone);
                    }
                    else
                    {
                        $('#questionDivSecond' + (QuestionSecondLevel - 1)).last().after(questionDivClone);  // questionDivSecond1
                    }
                    QuestionSecondLevel = QuestionSecondLevel+1;
                    $(this).attr('data-current-question-quantity', QuestionSecondLevel);  
                // ============================== testing ==============================
            }
            else if(parentID == 'AssessmentDiv3')
            {
                // ============================== testing ==============================
                    if(update)
                    {
                        QuestionThirdLevel = $(this).attr('data-current-question-quantity');
                        QuestionThirdLevel = Number(QuestionThirdLevel);
                        // $(this).attr('data-current-question-quantity', (QuestionThirdLevel++));
                    }

                    if(QuestionThirdLevel == 4)
                    {
                        Swal.fire({
                            icon: 'error', 
                            title: 'Oops...',
                            text: 'You can add only ' + (QuestionThirdLevel) + ' questions!',
                        });

                        return false;
                    }


                    var questionDivClone = $('#questionDivThird').clone();
                    questionDivClone.attr('id', 'questionDivThird' + QuestionThirdLevel);
                    questionDivClone.find('.ChildTitle').html('<b><i><u>Question ' + (QuestionThirdLevel+1) + '</u></i></b>');
                    questionDivClone.find('.deleteQuestion').css('display', 'block').attr('data-parent_id', 'questionDivThird' + QuestionThirdLevel).attr('data-grand-parent_id', parentID);

                    if (update) 
                    {
                        questionDivClone.find('.deleteQuestion')
                            .attr('data-current-question-quantity', QuestionThirdLevel);
                    }
                // ============================== testing ==============================

                RemoveDuplicationForAddQuestion(questionDivClone, 'questionDivThird', QuestionThirdLevel)

                // questionDivClone.find('.deleteQuestion').css('display', 'block').attr('data-parent_id', 'questionDivThird' + QuestionThirdLevel).attr('data-grand-parent_id', parentID);
                // ============================== testing ==============================

                    if(QuestionThirdLevel == 1)
                    {
                        $('#questionDivThird').last().after(questionDivClone);
                    }
                    else
                    {
                        $('#questionDivThird' + (QuestionThirdLevel - 1)).last().after(questionDivClone);  // questionDivThird1
                    }
                    QuestionThirdLevel = QuestionThirdLevel+1;  
                    $(this).attr('data-current-question-quantity', QuestionThirdLevel);
                // ============================== testing ==============================
            }
        });
        $(document).on('click', '.deleteQuestion', function(event) 
        {    
            event.preventDefault();       
            
            var grand_parent_div_id  = $(this).attr('data-grand-parent_id');    // AssessmentDiv      AssessmentDiv1       AssessmentDiv2       AssessmentDiv3
            var ParentClone = $(this).closest('[id]'); 
            var parentID = ParentClone.attr('id');                              // questionDiv       questionDivFirst    questionDivSecond   questionDivThird
            $(this).closest('div[id^=' + parentID + ']').remove();              //questionDiv1
 
            // console.log(QuestionLevel);
            // return false;

            if(grand_parent_div_id == 'AssessmentDiv')
            {
                if(update)
                {
                    GrandParentClone = $('div[id^=' + grand_parent_div_id + ']')
                    QuestionLevel = GrandParentClone.find('.AddMoreQuestion').attr('data-current-question-quantity');    
                }
                
                SortQuestionsDivs(parentID, grand_parent_div_id, 1, 'deleteQuestion');
                QuestionLevel = QuestionLevel - 1;
                if(update)
                {
                    GrandParentClone.find('.AddMoreQuestion').attr('data-current-question-quantity', QuestionLevel); 
                }
            }
            else if(grand_parent_div_id == 'AssessmentDiv1')
            {
                if(update)
                {
                    GrandParentClone = $('div[id^=' + grand_parent_div_id + ']')
                    QuestionFirstLevel = GrandParentClone.find('.AddMoreQuestion').attr('data-current-question-quantity');    
                    // alert(QuestionFirstLevel);
                }
                SortQuestionsDivs(parentID, grand_parent_div_id, 2, 'deleteQuestion');
                QuestionFirstLevel = QuestionFirstLevel - 1;

                if(update)
                {
                    GrandParentClone.find('.AddMoreQuestion').attr('data-current-question-quantity', QuestionFirstLevel); 
                }
            }
            else if(grand_parent_div_id == 'AssessmentDiv2')
            {
                if(update)
                {
                    GrandParentClone = $('div[id^=' + grand_parent_div_id + ']')
                    QuestionSecondLevel = GrandParentClone.find('.AddMoreQuestion').attr('data-current-question-quantity');    
                }
                SortQuestionsDivs(parentID, grand_parent_div_id, 3, 'deleteQuestion');
                QuestionSecondLevel = QuestionSecondLevel - 1;
                if(update)
                {
                    GrandParentClone.find('.AddMoreQuestion').attr('data-current-question-quantity', QuestionSecondLevel); 
                }
            }
            else if(grand_parent_div_id == 'AssessmentDiv3')
            {    
                if(update)
                {
                    GrandParentClone = $('div[id^=' + grand_parent_div_id + ']')
                    QuestionThirdLevel = GrandParentClone.find('.AddMoreQuestion').attr('data-current-question-quantity');    
                }
                SortQuestionsDivs(parentID, grand_parent_div_id, 4, 'deleteQuestion');
                QuestionThirdLevel = QuestionThirdLevel - 1;
                if(update)
                {
                    GrandParentClone.find('.AddMoreQuestion').attr('data-current-question-quantity', QuestionThirdLevel); 
                }
            }   



        });
        $(document).on('keyup', '.occurrence_duration', function(event) 
        {
            setTimeout(function() 
            {
                CheckOccurrencesDuration();
                // console.log('response while keyup is: ' + CheckOccurrencesDuration());
                // return false;

            }, (500));

            // return false;

            // if(typeof $(this).val() === 'number' && isNaN($(this).val()))
            // {
            //     showErrorPopUp($(this), "Please Don't Leave Field An Empty, Insert Time");
            //     return false;
            // }

            // // setTimeout(function() 
            // // {
            //     var secondClosestID = $(this).parent().closest('[id]').attr('id');  // could contain assessmentDiv1 or assessmentDiv2 or assessmentDiv3
            //     let regex = /\d$/;

            //     if (regex.test(secondClosestID))
            //     {
            //         var ParentID = secondClosestID.replace(/Div(\d)$/, function(match, capturedDigit)  // minus 1 with last digit 
            //                                     {
            //                                         return "Div" + (parseInt(capturedDigit) - 1);
            //                                     });

            //         var EnteredDuration = parseInt($(this).val().replace(/\D+/g, ""));
                    
            //         if(secondClosestID == 'AssessmentDiv1')
            //         {
            //             var ParentID = ParentID.replace(/Div\d+$/, "Div");                                // remove 0 from end 
            //             var Parent = $('div[id^=' + ParentID + ']');                                          // get assessmentDiv,
            //             FirstParentTime = Parent.find('.occurrence_duration').val();
            //             var FirstParentTime = parseInt(FirstParentTime.replace(/\D+/g, ""));

            //             if(typeof FirstParentTime === 'number' && isNaN(FirstParentTime))
            //             {
            //                 showErrorPopUp($(this), "Please Insert Time For First Asssessment");
            //                 return false;
            //             }
            //             else if (FirstParentTime >= EnteredDuration)
            //             {
            //                 showErrorPopUp($(this), "Second Assessment Time: " + EnteredDuration + " Should Be Greater Then First Asessment's Time: " + FirstParentTime);
            //             }
            //         }
            //         else if(secondClosestID == 'AssessmentDiv2')
            //         {
            //             var SecondParent = $('div[id^=' + ParentID + ']');
            //             SecondParentTime = SecondParent.find('.occurrence_duration').val();
            //             var SecondParentTime = parseInt(SecondParentTime.replace(/\D+/g, ""));
                        
            //             if(typeof SecondParentTime === 'number' && isNaN(SecondParentTime))
            //             {
            //                 showErrorPopUp($(this), "Please Insert Time For Second Asssessment");
            //                 return false;
            //             }
            //             else if(SecondParentTime >= EnteredDuration)
            //             {
            //                 showErrorPopUp($(this), "Third Assessment Time: " + EnteredDuration + " Should Be Greater Then Second Asessment's Time: " + SecondParentTime);
            //                 return false;
            //             }
            //         }
            //         else if(secondClosestID == 'AssessmentDiv3')
            //         {
            //             var ThirdParent = $('div[id^=' + ParentID + ']');
            //             ThirdParentTime = ThirdParent.find('.occurrence_duration').val();
            //             var ThirdParentTime = parseInt(ThirdParentTime.replace(/\D+/g, ""));

            //             if(typeof ThirdParentTime === 'number' && isNaN(ThirdParentTime))
            //             {
            //                 showErrorPopUp($(this), "Please Insert Time For Third Asssessment");
            //                 return false;
            //             }
            //             else if (ThirdParentTime >= EnteredDuration)
            //             {
            //                 showErrorPopUp($(this), "Forth Assessment Time: " + EnteredDuration + " Should Be Greater Then First Asessment's Time: " + ThirdParentTime);
            //                 return false;
            //             }                   
            //         }
            //         return false;
            //     }
        });
        window.addEventListener('testingFormWorking', event => 
        {
            Swal.fire({
                icon: 'success',
                title: 'form submitted Successfully!',
                text: 'The form submission has been done!!!.',
            });              
        })
        function showErrorPopUp(Object=null, Message)
        {
            Swal.fire({
                    icon: 'error', 
                    title: 'Oops...',
                    text: Message,
                });

            if(Object != null)
            {
                Object.val('');
            }
        }

    </script>


@endpush