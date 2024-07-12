@push('styles')

    <link href="{{ url_secure('build/css/livewire_components_action.css')}}" rel="stylesheet">
    
    <style>

        /* .select2-container{
            display: block!important;   
            width: 100%!important;
        } */

        .decorated-headings {
            color: #ffcb05;
            font-style: italic;
            text-decoration: underline;
        }

    </style>

@endpush 

    @php
        $JsMainTitle = $MainTitle;
        $MainTitle = preg_split('/(?=[A-Z])/', $MainTitle);
        $MainTitle = $MainTitle[1] . ' ' . $MainTitle[2];
    @endphp
    
    @section('title') {{ $MainTitle }} Listing  @endsection


        <div class="right_col" role="main">
                <div class="">
                @include('Admin.partial.livewire.header')   

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
                                    </div>
                                    <div class="x_content">

                                    <div class="container-fluid">
                                        <div class="row">
                                            
                                            <div class="col-lg-9"> 
                                                <!-- ------------------- 1 ------------------------ -->
                                                @forelse($courses as $key => $course)
                                                    <div class="col-lg-3" style="padding-top: 10px;">
                                                        <div class="card text-center">
                                                            <div class="card-header">
                                                                    @if(isset($course->category))
                                                                        {{ $course->category->name }} 
                                                                    @endif 
                                                                    @if(isset($course->subCategory)) 
                                                                       - {{ $course->subCategory->name }} 
                                                                    @endif 
                                                            </div>
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $course->name ?? 'not found '}} </h5>
                                                                <p class="card-text">{{ $course->description ?? 'not found '}}</p>

                                                                    @if($course->local_video != null)
                                                                        <a href="{{ asset('storage/'.$course->local_video) }}" class="btn btn-primary">
                                                                            Watch Video
                                                                        </a>
                                                                    @elseif($course->url_video != null )
                                                                        <a href="{{ asset('storage/'.$course->url_video) }}" class="btn btn-primary">
                                                                            Watch Video
                                                                        </a>
                                                                    @else   
                                                                        @if($course->course_image)
                                                                            <img src="{{ asset('/storage/'.$course->course_image) }}" style="width: 70px; height: 45px;" class="me-4" alt="Img">
                                                                        @endif
                                                                        
                                                                        <!-- <a href="#" class="btn btn-primary">
                                                                            Video is Not Uploaded Yet 
                                                                        </a>  -->
                                                                    @endif 

                                                            <!-- <a href="#" class="btn btn-primary"> -->
                                                                        <!-- <video width="500px" 
                                                                                height="400px" 
                                                                                controls="controls">
                                                                            <source 
                                                                                    src=
                                                                    "https://media.geeksforgeeks.org/wp-content/uploads/20231020155223/
                                                                    Full-Stack-Development-_-LIVE-Classes-_-GeeksforGeeks.mp4" 
                                                                                    type="video/mp4" />
                                                                        </video> -->
                                                                <!-- </a> -->
                                                            </div>
                                                            <div class="card-footer text-muted">
                                                               
                                                            <td>{{ getTimeDifference($course->created_at) }}</td>

                                                            </div>
                                                        </div>
                                                    </div>
                                                        
                                                    @if($key==2)

                                                        
                                                    @endif
                                                @empty 
                                                    <div class="col-lg-12 text-center">
                                                            not Found !!
                                                    </div>
                                                @endforelse 
                                              
                                                    


                                                <!-- ------------------- 2 ------------------------ -->
                                                <!-- <div class="col-lg-3">
                                                    <div class="card text-center">
                                                        <div class="card-header">
                                                            Featured
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Special title treatment</h5>
                                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            2 days ago
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- ------------------- 3 ------------------------ -->
                                                <!-- <div class="col-lg-3">
                                                    <div class="card text-center">
                                                        <div class="card-header">
                                                            Featured
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Special title treatment</h5>
                                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            2 days ago
                                                        </div>
                                                    </div>
                                                </div>
                                                -->


                                            </div>

                                            <!-- <div class="col-lg-12"> -->
                                                <!-- ------------------- 4 ------------------------ -->
                                                <!-- <div class="col-lg-3">
                                                    <div class="card text-center">
                                                        <div class="card-header">
                                                            Featured
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Special title treatment</h5>
                                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            2 days ago
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- ------------------- 5------------------------ -->
                                                <!-- <div class="col-lg-3">
                                                    <div class="card text-center">
                                                        <div class="card-header">
                                                            Featured
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Special title treatment</h5>
                                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            2 days ago
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- ------------------- 6------------------------ -->
                                                <!-- <div class="col-lg-3">
                                                    <div class="card text-center">
                                                        <div class="card-header">
                                                            Featured
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Special title treatment</h5>
                                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            2 days ago
                                                        </div>
                                                    </div>
                                                </div> -->
                                            <!-- </div> -->
                                            <!-- <div class="col-lg-12"> -->
                                                <!-- ------------------- 7 ----------------------- -->
                                                <!-- <div class="col-lg-3">
                                                    <div class="card text-center">
                                                        <div class="card-header">
                                                            Featured
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Special title treatment</h5>
                                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            2 days ago
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- -------------------8  ----------------------- -->
                                                <!-- <div class="col-lg-3">
                                                    <div class="card text-center">
                                                        <div class="card-header">
                                                            Featured
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Special title treatment</h5>
                                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            2 days ago
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <!-- -------------------9 ----------------------- -->
                                                <!-- <div class="col-lg-3">
                                                    <div class="card text-center">
                                                        <div class="card-header">
                                                            Featured
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="card-title">Special title treatment</h5>
                                                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                                            <a href="#" class="btn btn-primary">Go somewhere</a>
                                                        </div>
                                                        <div class="card-footer text-muted">
                                                            2 days ago
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-3" style="height: 292px;">
                                                <div>
                                                    <h3 class="decorated-headings">
                                                        Circular
                                                    </h3>
                                                    <p class="text-dark" style="font-style: italic;">On Account Of Aug 14, 2024 Our Offices Will Remain Closed.....</p>
                                                    <h4 class="decorated-subheadings">HR Policies</h4>
                                                    <h4 class="decorated-subheadings">Departmental Policies</h4>
                                                    <h4 class="decorated-subheadings">Core Values</h4>
                                                    <h4 class="decorated-subheadings">Leadership</h4>
                                                    <h4 class="decorated-subheadings">I Have An Idea</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="row">

                                        </div> -->
                                         <!-- Pagination -->
                                    <div class="row mt-3">
                                        <div class="col-lg-9">
                                            {{ $courses->links() }}
                                        </div>
                                    </div>
                                    </div>  <!-- Row end -->
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>




                   



       
@push('scripts')
        <script>
                var ModuleName = '{!! $JsMainTitle !!}';

                $(document).ready(function()
                {
                    // alert(ModuleName);
                    // return false;
                });

                document.addEventListener('livewire:submit', function () 
                {

                    document.getElementById('imageInput').value = '';
                });
        </script>
        <script src="{{ url_secure('build/js/livewire_components_action.js')}}"></script>
@endpush 