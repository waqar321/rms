


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


                        <h3 style="padding-left: 15px;"> {{ $ecom_course->name }} </h3>
                        <div class="x_content">          
                            <div class="row" style="padding-left: 30px; padding-top: 20px; font-weight: bold;">
                                <div class="col-lg-6" > 
                                    <!-- <img src="{{ asset('videos/demo-video.mp4') }}" alt="" class="img-fluid"> -->
                                    <img id='video-player' src="{{ asset('storage/'.$ecom_course->course_image) }} " width="580" height="360" controls>
                                    <!-- <iframe id="video-player" width="560" height="315" src="https://www.youtube.com/embed/9JZeDi0P9o8" frameborder="0" allowfullscreen></iframe> -->

                                    <!-- =================== about section ================== -->
                                        <h3 style="padding-top: 25px;">Description</h3>
                                        <p>
                                            {{ $ecom_course->description }}
                                        </p>
                                        
                                    <!-- =================== end about section ================== -->

                                </div>
                                <div class="col-lg-6">
                                    @include('Admin.manage_course.course_content.partials.question_model')  
                                    @include('Admin.manage_course.course_content.partials.tableContent') 

                                    <a href="{{ url_secure('content-management/courseList/CourseEnroll?id=') . base64_encode($ecom_course->id) }}">
                                        <button style="background-color: #ffcb05;" type="button" class="btn  btn-lg btn-block">Join Now</button>
                                    </a>

                                        <h1>What Will You Learn</h1>
                                        <p>After completion of this course student will be able to:</p>
                                        <ul style="list-style: none;">
                                            <li>
                                                <button type="button" class="btn btn-warning btn-sm rounded-circle">
                                                <i class="fas fa-check text-white" style="font-size: 10px;"></i>
                                                </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
                                            </li>
                                            <br>
                                        </ul>    
                                </div>
                            </div>
                        </div>
                    </div>                  
                </div>                  
            </div>                  
        </div>
    </div>



@endsection 

@push('scripts')

      <script>
             
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