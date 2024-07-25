@extends('Admin.layout.main')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
                                    </div><h1>Course Information</h1>
                                    <div class="x_content">
                                        
                                    <div class="row" style="padding-left: 30px; padding-top: 20px; font-weight: bold;">
                                        <div class="col-lg-6" > 
                                            <!-- <img src="{{ asset('videos/demo-video.mp4') }}" alt="" class="img-fluid"> -->
                                            <video id='video-player' width="580" height="360" controls>
                                                <source src="{{ asset('videos/demo-video.mp4') }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <!-- <iframe id="video-player" width="560" height="315" src="https://www.youtube.com/embed/9JZeDi0P9o8" frameborder="0" allowfullscreen></iframe> -->

                                                
                                            <h1 style="padding-top: 25px;">About</h1>
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                Nisi, impedit autem at voluptatum officiis reprehenderit,
                                                esse, quia culpa nesciunt excepturi quam incidunt molestiae?
                                                Provident, vero  facere!
                                            </p>
                                            <br>
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti,
                                                ex asperiores sapiente beatae fugit dolor provident optio atque inventore
                                                voluptate a rem perferendis dicta doloribus aspernatur esse explicabo ab.
                                            Perferendis soluta, vero architecto  autem atque!
                                            </p>
                                            <br>
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti,
                                                ex asperiores sapiente beatae fugit dolor provident optio atque inventore
                                                voluptate a rem perferendis dicta doloribus aspernatur esse explicabo ab.
                                            Perferendis soluta, vero architecto  autem atque!
                                            </p>
                                            <br>
                                            <p>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                Nisi, impedit autem at voluptatum officiis reprehenderit,
                                                esse, quia culpa nesciunt excepturi quam incidunt molestiae?
                                                Provident, vero  facere!
                                            </p>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" style="font-weight: bold;">
                                                <tbody>
                                                    <tr>
                                                    <td>Course Levels</td>
                                                    <td>3</td>
                                                    </tr>
                                                    <tr>
                                                    <td>Course Duration</td>
                                                    <td>30 Mins</td>
                                                    </tr>
                                                    <tr>
                                                    <td>Start Date</td>
                                                    <td>22-Apr-2024</td>
                                                    </tr>
                                                    <tr>
                                                    <td>End Date</td>
                                                    <td>22-May-2024</td>
                                                    </tr>
                                                    <tr>
                                                    <td>Who Can Join</td>
                                                    <td>Everyone</td>
                                                    </tr>
                                                    <tr>
                                                    <td>Total Trained</td>
                                                    <td>1500</td>
                                                    </tr>
                                                    <tr>
                                                    <td>Video Medium</td>
                                                    <td>English & Urdu</td>
                                                    </tr>
                                                    <!-- Add more rows as needed -->
                                                </tbody>
                                                </table>
                                            </div>
                                            <button style="background-color: #ffcb05;" type="button" class="btn  btn-lg btn-block">Join Now</button>
                                            <h1>What Will You Learn</h1>
                                            <p>After completion of this course student will be able to:</p>
                                            <ul style="list-style: none;">
                                                <li>
                                                    <button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white" style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                                <li>
                                                    <button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white"style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                                <li>
                                                    <button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white"style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                                <li>
                                                    <button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white"style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                                <li><button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white"style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                                <li>
                                                    <button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white"style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                                <li>
                                                    <button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white"style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                                <li><button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white"style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                                <li>
                                                    <button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white"style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                                <li>
                                                    <button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                    <i class="fas fa-check text-white"style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                                </li>
                                                <br>
                                            </ul>


                  
            </div>
            <!-- <div class="col-lg-1"></div> -->
        </div>
                                     <!-- Row end  -->
        </div>

    </div>


@endsection 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var video = document.getElementById('video-player');
        var quizFormContainer = document.getElementById('quiz-form-container');
        var quizForm = document.getElementById('quiz-form');
        var quizModal = document.getElementById('quizModal');

        function showQuizForm() {
            $('#quizModal').modal('show'); // Show the modal using Bootstrap jQuery
            video.pause();
        }

        function hideQuizForm() {
            $('#quizModal').modal('hide'); // Hide the modal using Bootstrap jQuery
        }

        function startTimer() {
            // Set timeout to show quiz after 60 seconds (60000 milliseconds)
            setTimeout(function() {
                showQuizForm();
            }, 2000);
        }

        function stopTimer() {
            clearTimeout(); // Clear the timeout
        }

        video.addEventListener('play', function() {
            startTimer();
        });

        video.addEventListener('pause', function() {
            stopTimer();
        });

        video.addEventListener('ended', function() {
            stopTimer();
        });

        // Handle form submission
        quizForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission behavior

            // Retrieve user's answer
            var answer = document.getElementById('question1').value;

            // Check answer (assuming correct answer is '4')
            if (answer === '4') {
                alert('Correct!');
            } else {
                alert('Incorrect. Please try again.');
            }

            // Hide the quiz form
            hideQuizForm();
            // Resume video playback
            video.play();
        });
    });
  
    // document.addEventListener('DOMContentLoaded', function() {
    //     var video = document.querySelector('video');
    //     var quizFormContainer = document.getElementById('quiz-form-container');
    //     var quizForm = document.getElementById('quiz-form');
    //     var quizModal = document.getElementById('quizModal');
    //     var timer;

    //     function showQuizForm() {
    //         $('#quizModal').modal('show'); // Show the modal using Bootstrap jQuery
    //         video.pause();
    //     }

    //     function hideQuizForm() {
    //         $('#quizModal').modal('hide'); // Hide the modal using Bootstrap jQuery
    //     }

    //     function startTimer() {
    //         // Set timeout to show quiz after 60 seconds (60000 milliseconds)
    //         timer = setTimeout(function() {
    //             showQuizForm();
    //         }, 20000);
    //     }

    //     function stopTimer() {
    //         clearTimeout(timer); // Clear the timeout
    //     }

    //     // Add event listener to the video element
    //     video.addEventListener('play', function() {
    //         startTimer();
    //     });

    //     video.addEventListener('pause', function() {
    //         stopTimer();
    //     });

    //     video.addEventListener('ended', function() {
    //         stopTimer();
    //     });

    //     // Handle form submission
    //     quizForm.addEventListener('submit', function(event) {
    //         event.preventDefault(); // Prevent default form submission behavior

    //         // Retrieve user's answer
    //         var answer = document.getElementById('question1').value;

    //         // Check answer (assuming correct answer is '4')
    //         if (answer === '4') {
    //             alert('Correct!');
    //         } else {
    //             alert('Incorrect. Please try again.');
    //         }

    //         // Hide the quiz form
    //         hideQuizForm();
    //         // Resume video playback
    //         video.play();
    //     });
    // });
</script>



@push('scripts')

      <script>l 
             
             $(document).ready(function() 
             {
                // $('#addStudentPanel').css('display', 'none'); 

                $('.add_student').css('display', 'block');
                $('.add_student').addClass('btn btn-primary float-end custom-margin-bottom');
                $('.add_student').text('Add Student');
                
                $('.close_form').css('display', 'none');
                $('.close_form').addClass('btn btn-primary float-end custom-margin-bottom');
                $('.close_form').css('background-color', 'red'); 
                $('.close_form').text('Close Form');
                
                // const url = window.location.search;
                // if (!url) 
                // {
                //     // $('.AddPanel').addClass('collapse');
                //     // $('#addStudentPanel').css('display', 'none'); 
                //     const urlParams = new URLSearchParams(url);
                //     const id = atob(urlParams.get('id'));           
                // }

            });
        </script>

@endpush 