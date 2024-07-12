
@if(Permission(46))

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
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th> </th>
                                <th>ID#</th>
                                <th>Title</th>
                                <!-- <th>Image</th> -->
                                <th>Course</th>
                                <th>Description</th>
                                <th>Instructor</th>
                                <th>Duration</th>
                                <th>Tags</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                        
                            <tbody>

                                    @if($readyToLoad)
                                        @forelse($lectures as $lecture)

                                            <tr>
                                                <td>
                                                    <input type="checkbox" wire:model="selectedRows.{{ $lecture->id }}">
                                                </td>
                                                <td>{{ $lecture->id }}</td>
                                                <td>{{ $lecture->title ?? 'not found '}}</td>
                                                <!-- <td>
                                                    @if($lecture->course_image)
                                                        <img src="{{ asset('/storage/'.$lecture->course_image) }}" style="width: 70px; height: 45px;" class="me-4" alt="Img">
                                                    @endif
                                                </td> -->
                                                <td>{{ $lecture->course->name }}</td>
                                                <td>{{ $lecture->description }}</td>
                                                <td>{{ $lecture->Teacher->first_name }}</td>
                                                <td>{{ $lecture->duration }}</td>
                                                <td>{{ $lecture->tags }}</td>
                                                <td>
                                                    @if($lecture->is_active == 1)
                                                        <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $lecture->id }}, 0)"></span>
                                                    @else
                                                        <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $lecture->id }}, 1)"></span>
                                                    @endif
                                                </td>
                                                <td>{{ $lecture->created_at }}</td>
                                                <td colspan="2">
                                                    <a href="{{ url_secure_api('content-management/LectureUpload?id=') . base64_encode($lecture->id) }}" class="btn btn-primary">Edit</a>
                                                    <button onclick="confirmDelete('{{ $lecture->id }}')" class="btn btn-danger">Delete</button>

                                                    @if ($lecture->local_video)
                                                        <a href="{{ asset('/storage/'.$lecture->local_video) }}" class="btn btn-info" target="__blank" >Preview Video</a>
                                                    @endif

                                                    @if ($lecture->local_document)
                                                        <a href="{{ asset('/storage/'.$lecture->local_document) }}" class="btn btn-info" target="__blank">Preview Document</a>
                                                    @endif
                                                    

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="17" class="text-center"> <h2> No Record Found For Courses !!! </h2></td>
                                            </tr>
                                        @endforelse
                                    @endif 

                                    @include('Admin.partial.livewire.loadingData')

                            </tbody>

                        </table>
                        <div>
                            @if($readyToLoad)
                                {{ $lectures->links() }} 
                            @endif 
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@else

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
                            <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID#</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Sub-Category</th>
                                <th>Instructor</th>
                                <th>Duration</th>
                                <th>Level</th>
                                <th>Prerequisites</th>
                                <th>Language</th>
                                <th>Code</th>
                                <th>Tags</th>
                                @if(auth()->user()->role->id == 31)
                                    <th>Status</th>
                                @endif 
                                <th>Date Created</th>
                                @if(auth()->user()->role->id == 31)
                                    <th>Actions</th>
                                @endif 
                            </tr>
                            </thead>
                        
                            <tbody>

                                    @if($readyToLoad)
                                        @forelse($courses as $course)

                                            <tr>

                                                <td>{{ $course->id }}</td>
                                                <td>{{ $course->name ?? 'not found '}}</td>
                                                <td>
                                                    @if($course->course_image)
                                                        <img src="{{ asset('/storage/'.$course->course_image) }}" style="width: 70px; height: 45px;" class="me-4" alt="Img">
                                                    @endif
                                                </td>
                                                <td>{{ $course->description }}</td>
                                                <td>{{ $course->category->name }}</td>
                                                <td>{{ $course->subCategory->name }}</td>
                                                <td>{{ $course->Teacher->first_name }}</td>
                                                <td>{{ $course->duration }}</td>
                                                <td>{{ $course->level }}</td>
                                                <td>{{ $course->prerequisites }}</td>
                                                <td>{{ $course->language }}</td>
                                                <td>{{ $course->course_code }}</td>
                                                <td>{{ $course->tags }}</td>
                                                @if(auth()->user()->role->id == 31)
                                                    <td>
                                                        @if($course->is_active == 1)
                                                            <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $course->id }}, 0)"></span>
                                                        @else
                                                            <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $course->id }}, 1)"></span>
                                                        @endif
                                                    </td>
                                                @endif 
                                                <td>{{ $course->created_at }}</td>
                                                @if(auth()->user()->role->id == 31)
                                                    <td>
                                                        <a href="{{ url_secure_api('content-management/course?id=') . base64_encode($course->id) }}" class="btn btn-primary">Edit</a>
                                                        <!-- <button onclick="confirmDelete('{{ $course->id }}')" class="btn btn-danger">Delete</button>
                                                        @if ($course->local_video)
                                                            <a href="{{ asset('/storage/'.$course->local_video) }}" class="btn btn-info" target="__blank" >Preview Video</a>
                                                        @endif

                                                        @if ($course->local_document)
                                                            <a href="{{ asset('/storage/'.$course->local_document) }}" class="btn btn-info" target="__blank">Preview Document</a>
                                                        @endif -->
                                                        

                                                    </td>
                                                @endif 
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="21" class="text-center"> <h2> No Record Found For Courses !!! </h2></td>
                                            </tr>
                                        @endforelse
                                    @endif 

                                    <div wire:init="pageLoaded">
                                        @if(!$readyToLoad)
                                            <tr>
                                                <td colspan="17" class="text-center"> <h2>Loading !!! </h2></td>
                                            </tr>
                                        @endif 
                                    </div> 

                            </tbody>

                        </table>
                        <div>
                            @if($readyToLoad)
                                {{ $courses->links() }} 
                            @endif 
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
