


@push('styles')
    <style>
        .signin-btn {
            background-color: #ffcb05 ;
            border-radius: 27px;
            color: white;
        }
        .btn-search {
        align-items: center;
        background-color: #ffcb05; /* Yellow background */
        color: white; /* White text */
        }
        .close_form
        {
            float: right;
            margin-top: 10px;
        }
        .add_student
        {
            float: right;
            margin-top: 10px;
        }
        .custom-margin-bottom {
            margin-bottom: 1% !important;
        }
        .decorated-headings {
            color: #ffcb05;
            font-style: italic;
            text-decoration: underline;
        }
    </style>
@endpush 

@section('content')


    <div class="right_col" role="main">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-4 col-lg-4">
                            <input type="search" wire:model="title" class="form-control" placeholder="Search By Name...">
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
                        <div class="col-lg-12 text-center"> 
                            <h1 > {{ $ecom_lecture->title }} </h1>
                         
                            @php  
                                $level_ids = $this->ecom_lecture->QuestionLevels->pluck('assessment_level')->unique();
                            @endphp 
                            
                        </div>
                        <div class="x_content">          
                            <div class="row" style="padding-left: 30px; padding-top: 20px; font-weight: bold;">
                                <div class="col-lg-12" > 
                                    <!-- <img src="{{ asset('videos/demo-video.mp4') }}" alt="" class="img-fluid"> -->
                                    <video id='video-player' width="1200" height="500" controls>
                                        <source src="{{ asset('storage/'.$ecom_lecture->local_video ) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <!-- <iframe id="video-player" width="560" height="315" src="https://www.youtube.com/embed/9JZeDi0P9o8" frameborder="0" allowfullscreen></iframe> -->

                                        <h1 style="padding-top: 25px;">Description </h1>
                                        <p>
                                            {{ $ecom_lecture->description }}
                                        </p>
                                </div>
                                <div class="col-lg-6">
                                        @include('Admin.manage_course.lecture.partials.question_model')  
                                </div>
                            </div>
                        </div>
                    </div>                  
                </div>                  
            </div>                  
        </div>
    </div>
                                        
                                        
    <!-- tableContent.blade -->



@endsection 

@push('scripts')

      <script>
          
          var count=0;
          var assessmentData;
          var assessmentStatus;
          var quizFormContainer = $('#quiz-form-container'); //document.getElementById('quiz-form-container');
          var quizModal = $('#quizModal');
          var quizForm = document.getElementById('quiz-form');
          var video = document.getElementById('video-player');
          var currentIndex = 0;
          var AssessmentLevel = 0;
          var lecture_id;

          $(document).ready(function() 
          {

                assessmentData = {!! json_encode($assessmentData) !!};
                assessmentStatus = {!! json_encode($assessmentStatus) !!};
                lecture_id = '{!! json_encode($ecom_lecture->id) !!}';
                // console.log(assessmentStatus);
                // return false;
 

                // TestassessmentData();

                video.addEventListener('play', function() 
                {
                    video.muted = true; 
                    console.log('played and timer started');
                    startTimer();
                });
                
                video.addEventListener('pause', function() 
                {
                    console.log('video paused');
                    stopTimer();
                });
                
                video.addEventListener('ended', function() 
                {
                    console.log('ended');
                    
                    // Livewire.emit('UpdateUserLectureResult');

                    
                    $.ajax({
                            url: "{{ api_url('UpdateUserLectureResult') }}", 
                            type: "POST",
                            dataType: "json",
                            data: 
                            {
                                lecture_id: lecture_id
                            },
                            headers: headers,
                            success: function (data) 
                            {
                                if(data.status == 200)
                                {
                                    console.log('record updated');
                                    console.log(data);
                                    // Swal.fire({
                                    //     icon: 'success',
                                    //     title: 'Answers submitted Successfully!',
                                    //     text: 'The Answer submission has been done!!!.',
                                    // });    
                                    // stopTimer();
                                    // RemoveCurrentAsessmentQuestions();
                                    // video.play();
                                    // $('#quizModal').modal('hide');
                                }
                                // console.log(data);
                                // Your success handling code here
                            },
                            error: function (xhr, status, error) {
                                // Your error handling code here
                            }
                        });

                    
                    stopTimer();
                    RemoveCurrentAsessmentQuestions();
                });
                quizModal.on('hidden.bs.modal', function () 
                {
                    console.log('modal closed and timer started');
                    stopTimer();
                    RemoveCurrentAsessmentQuestions();
                    video.play();
                });

                //------step02: set the first asssessment timer to pause the video and show assessment questions.                 
                function startTimer()
                {
                    var timeDuration

                    if (AssessmentLevel < assessmentData.length)  //first:   0 < 3
                    {
                        if(AssessmentLevel==0)
                        {
                            timeDuration = assessmentData[AssessmentLevel].assessment_time * 1000;
                        }
                        else
                        {
                            PreviousDuration = assessmentData[(AssessmentLevel-1)].assessment_time * 1000;
                            NextDuration = assessmentData[AssessmentLevel].assessment_time * 1000;
                            timeDuration = (NextDuration - PreviousDuration);                                
                        }

                        // if (Array.isArray(assessmentStatus) && assessmentStatus.length === 0)   // status are in db
                        // {
                        //     setTimeout(function() 
                        //     {
                        //         showQuizForm(assessmentData[AssessmentLevel]);
                        //         AssessmentLevel++; 
                        //     }, (timeDuration)); 
                        // }
                        // else
                        // {
                        //     console.log('no status yet for lecture');
                        //     return;
                        // }
                        // return;

                            // if (Array.isArray(assessmentStatus) && assessmentStatus.length === 0)   // status are in db
                            // {
                            //     setTimeout(function() 
                            //     {
                            //         showQuizForm(assessmentData[AssessmentLevel]);
                            //         AssessmentLevel++; 
                            //     }, (timeDuration)); 
                            // }
                            // else 
                            // {
                                // console.log('not coming here');
                                setTimeout(function() 
                                {
                                    showQuizForm(assessmentData[AssessmentLevel]);
                                    AssessmentLevel++; 

                                }, (timeDuration)); 
                            // }

                            // AssessmentLevel++; 
                        // setTimeout(function() 
                        // {
                        //     if(AssessmentLevel == 0)
                        //     {
                        //         var WrongQuestion = {};
                                
                        //         assessmentStatus.forEach(function(StatusDetail) 
                        //         {
                        //             if(StatusDetail.status == 0)
                        //             {
                        //                 WrongQuestion.question = StatusDetail.question_level; 
                        //                 WrongQuestion.status = StatusDetail.status;
                        //                 // console.log('wrong question found');
                        //                 return true;
                        //             }

                        //         });
                        //         if(WrongQuestion.status == 0)
                        //         {
                        //             console.log(WrongQuestion);
                        //             console.log('wrong found');
                        //             return false;
                        //         }
                        //     }

                        //     showQuizForm(assessmentData[AssessmentLevel]);
                        //     AssessmentLevel++; 

                        // }, (timeDuration)); 
                    }
                    else
                    {
                        console.log('No duration for ' + AssessmentLevel);
                    }           
                }

                function showQuizForm(assessment) 
                {    
                    var hiddenField = $("<input>", {
                                        type: "hidden",
                                        value: AssessmentLevel,
                                        name: "assessment_level",
                                        id: "assessment_level"
                                    });

                    // alert(AssessmentLevel);

                    $('#questionlevel').last().after(hiddenField);

                    var QuestionLevel=0;
             
                    assessment.questions.forEach(function(question) 
                    {
                        let ParentAssessmentLevel = AssessmentLevel; 
                        let DivQuestionLevel = QuestionLevel; 
                        ParentAssessmentLevel++;
                        DivQuestionLevel++;

                        // console.log(question);
                        var clonedDiv = $('#questionlevel').clone();
                        clonedDiv.attr('id', 'questionlevel' + QuestionLevel).attr('data-grand_parent_id', ParentAssessmentLevel).attr('data-parent_id', DivQuestionLevel).attr('data-correctAnswer', JSON.parse(question.answer).correctAnswer);
                        clonedDiv.find('#question').text(question.question);


                        clonedDiv.find('input[name="radio1"]').attr('name', 'Radio' + QuestionLevel);
                        clonedDiv.find('input[name="radio2"]').attr('name', 'Radio' + QuestionLevel);
                        clonedDiv.find('input[name="radio3"]').attr('name', 'Radio' + QuestionLevel);
                        clonedDiv.find('input[name="radio4"]').attr('name', 'Radio' + QuestionLevel);

                        clonedDiv.find('#answer1').text(JSON.parse(question.answer).Answer1);
                        clonedDiv.find('#answer2').text(JSON.parse(question.answer).Answer2);
                        clonedDiv.find('#answer3').text(JSON.parse(question.answer).Answer3);
                        clonedDiv.find('#answer4').text(JSON.parse(question.answer).Answer4);
                        
                        clonedDiv.css('display', 'block');
                        clonedDiv.css('margin-bottom', '10px');

                        if(QuestionLevel == 0)
                        {
                            $('#questionlevel').last().after(clonedDiv);
                        }
                        else
                        {
                            $('#questionlevel' + (QuestionLevel-1)).last().after(clonedDiv);  // AssessmentDiv1
                        }
                        QuestionLevel++;
                    });
                    
                    // RemoveCurrentAsessmentQuestions();
                    quizModal.modal('show');
                    // count = count+1;
                    // $('#quizModal').val(count);
                    video.pause();
                }

                function hideQuizForm()
                {
                    $('#quizModal').modal('hide'); // Hide the modal using Bootstrap jQuery
                }
                function stopTimer()
                {
                    clearTimeout(); 
                }

                // Handle form submission


                // $(document).on('click', '#ModalFormSubmit', function(event) 
                // {
                //     event.preventDefault();
                    
                //     alert('yes submitting ');
                //     Livewire.emit('lectureQuestionSubmission');
                // });


                const token = getToken();
                const headers = {
                    "Authorization": `Bearer ${token}`,
                };
                

                quizForm.addEventListener('submit', function(event) 
                {
                    event.preventDefault(); 

                    // alert('yes submitting ');
                    // Livewire.emit('lectureQuestionSubmission');
                    
                    // return false;

                    let LectureAssessmentDetails = [];
                    var Validation=false;
                    

                    $('[id^="questionlevel"]').each(function(i) 
                    {
                        var questionDiv = $(this);

                        if(i!=0)
                        {
                            let Radio = 'Radio'+(i-1)
                            var RadioButton = questionDiv.find('input[name="' + Radio + '"]');

                            if(RadioButton.length)
                            {
                                let isRadioChecked = RadioButton.is(':checked');
                                
                                if (!isRadioChecked) 
                                {
                                    Swal.fire({
                                        icon: 'error', 
                                        title: 'Oops...',
                                        text: 'No Answer is selected for Question: ' + questionDiv.find('[id^="question"]').text(),
                                    });    

                                    // Validation= true;
                                    return false;
                                }
                            }
                            
                            questionDiv.find('[id^="question"]')
                            let parentID = RadioButton.closest('[id]').attr('id');
                            var QuestionDiv = $('div[id^=' + parentID + ']');

                            // let assessmentDetail = {};
                            // assessmentDetail.lecture_id = lecture_id;
                            // assessmentDetail.assessmentlevel = QuestionDiv.attr('data-grand_parent_id');
                            // assessmentDetail.question = QuestionDiv.attr('data-parent_id');
                            // assessmentDetail.answergiven = RadioButton.filter(':checked').val();
                            // assessmentDetail.CorrectAnswer = QuestionDiv.attr('data-correctAnswer');

                            let assessmentDetail = {
                                lecture_id: lecture_id,
                                assessmentlevel: QuestionDiv.attr('data-grand_parent_id'),
                                question: QuestionDiv.attr('data-parent_id'),
                                answergiven: RadioButton.filter(':checked').val(),
                                CorrectAnswer: QuestionDiv.attr('data-correctAnswer')
                            };

                            LectureAssessmentDetails.push(assessmentDetail);
                        }
                    });

                    if (LectureAssessmentDetails.length) 
                    {
                        // console.log('sending');
                        // console.log(LectureAssessmentDetails);                        
                        // Route::post('/UpdateLectureAssessmentQuestions', [DataListController::class, 'getCityForSearch'])->name('update.assessment');

                        $.ajax({
                            url: "{{ api_url('UpdateLectureAssessmentQuestions') }}", 
                            type: "POST",
                            dataType: "json",
                            data: {
                                LectureAssessmentDetails: LectureAssessmentDetails
                            },
                            headers: headers,
                            success: function (data) 
                            {
                                if(data.status == 200)
                                {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Answers submitted Successfully!',
                                        text: 'The Answer submission has been done!!!.',
                                    });    
                                    stopTimer();
                                    RemoveCurrentAsessmentQuestions();
                                    video.play();
                                    $('#quizModal').modal('hide');
                                }
                                // console.log(data);
                                // Your success handling code here
                            },
                            error: function (xhr, status, error) {
                                // Your error handling code here
                            }
                        });
                        
                        // ajax: {
                        // url: "{{ api_url('get_cities') }}", // Replace with your actual server endpoint
                        // dataType: "json",
                        // delay: 250, // Delay before sending the request in milliseconds
                        // headers: headers,
                        // processResults: function (data) {
                        //         return {
                        //             results: data.map(function (item) {
                        //                 return {
                        //                     id: item.id,
                        //                     text: item.label // 'text' property is required by Select2
                        //                 };
                        //             })
                        //         };
                        //     },
                        //     cache: true // Enable caching of AJAX results
                        // }
                    
                        // Livewire.emit('lectureQuestionSubmission', JSON.stringify(LectureAssessmentDetails));
                        // Array is not empty
                    }

                    return false;
                  
                    hideQuizForm();
                    stopTimer();
                    startTimer();
                    RemoveCurrentAsessmentQuestions();
                    video.play();
                });

            });

            $(document).on('visibilitychange', function() 
            {
                var video = $('#video-player')[0]; 

                if (document.visibilityState === 'hidden') 
                {
                    video.pause();
                }
                else if (document.visibilityState === 'visible')
                {
                    // video.play();
                }
            });

    
                    // coun=1;
                    // alert(count);
                    // Set timeout to show quiz after 60 seconds (60000 milliseconds)
                    // setTimeout(function() 
                    // {
                        
                    //     showQuizForm();
                    // }, 4000);
                    
                    // if (0 < assessmentData.length)
                    // {
                    //     for (let i = 0; i < assessments.length; i++) 
                    //     {
                    //         setTimeout(function() 
                    //         {
                    //             showQuizForm(assessments[i]);
                    //             AssessmentLevel++;
                    //         }, assessments[i].assessment_time * 1000);
                    //     }
                    // }

                    // alert(assessmentData.length);
                    // return false; -->

           
            function RemoveCurrentAsessmentQuestions() 
            {
                $('[id^="questionlevel"]').each(function(i) {    
                    if (i !== 0) 
                    {
                        var parentID = 'questionlevel' + (i-1); 
                        var Parent = $('div[id^="' + parentID + '"]'); 
                        // console.log(parentID);

                        if (Parent.length) 
                        {
                            Parent.remove();
                            // alert('removed questionlevel' + (i-1));
                        }
                        // else
                        // {
                        //     // alert('not exists questionlevel ' + (i-1));
                        // }
                    }
                });
            }
            function TestassessmentData()
            {
                assessmentData.forEach(function(assessment) 
                {
                    var assessmentLevel = assessment.assessment_level;
                    var assessmentTime = assessment.assessment_time;
                    
                    console.log("Assessment Level: " + assessmentLevel);
                    console.log("Assessment Time: " + assessmentTime);
                    
                    assessment.questions.forEach(function(question) {
                        var questionText = question.question;
                        var answer1 = JSON.parse(question.answer).Answer1;
                        var answer2 = JSON.parse(question.answer).Answer2;
                        var answer3 = JSON.parse(question.answer).Answer3;
                        var answer4 = JSON.parse(question.answer).Answer4;
                        
                        console.log("Question: " + questionText);
                        console.log("Answer 1: " + answer1);
                        console.log("Answer 2: " + answer2);
                        console.log("Answer 3: " + answer3);
                        console.log("Answer 4: " + answer4);
                    });
                });

            }
            function AnyAnswerIsWrongAndUnAnsweredQuestion(assessmentStatus, AssessmentLevel)
            {
                // var WrongQuestion = {};
                // let AssessmentLEVELNumber = AssessmentLevel;
                // AssessmentLEVELNumber++; 

                // assessmentStatus.forEach(function(StatusDetail) 
                // {
                //     // console.log(AssessmentLevel);
                //     // console.log(assessmentData[AssessmentLevel]);
                //     // return false;
                    
                //     // console.log(StatusDetail);
                //     if(StatusDetail.assessment_level == AssessmentLEVELNumber)
                //     {
                //         if(StatusDetail.status == 0)
                //         {
                //             WrongQuestion.question = StatusDetail.question_level; 
                //             WrongQuestion.status = StatusDetail.status;
                //             return true;
                //         }
                //     }
                // });

                // if (WrongQuestion.status == 0 || assessmentStatus.length < assessmentData[AssessmentLevel].questions.length) 
                // {
                                                            
                //     console.log('total questions: ' + assessmentData[AssessmentLevel].questions.length);
                //     console.log('questions answered: ' + assessmentStatus.length);
                //     console.log('must show the form');

                //     showQuizForm(assessmentData[AssessmentLevel]);
                //     AssessmentLevel++; 
                // }
                // else
                // {
                //     console.log('all are valid answers, no need to show form');
                //     return false;
                // }


            }
    </script>

@endpush 
