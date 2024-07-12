
    <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <div class="col-md-4 col-lg-4">
                            <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Course Title...">
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
                                    @foreach($availableColumns as $column)
                                        <th> {{ $column }} </th>                                        
                                    @endforeach 
                                </tr>
                            </thead>
                        
                            <tbody>

                                    @if($readyToLoad)
                                        @forelse($coursesListing as $course)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" wire:model="selectedRows.{{ $course->id }}">
                                                </td>
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
                                                <td>{{ $course->duration }}</td>
                                                <td>{{ $course->level }}</td>
                                                <td>{{ $course->prerequisites }}</td>
                                                <td>{{ $course->language }}</td>
                                                <td>{{ $course->course_code }}</td>
                                                <td>{{ $course->tags }}</td>
                                                <td>
                                                    @if($course->is_active == 1)
                                                        <span class="fa fa-toggle-on toggle-icon" wire:click="updateStatus({{ $course->id }}, 0)"></span>
                                                    @else
                                                        <span class="fa fa-toggle-off toggle-icon" wire:click="updateStatus({{ $course->id }}, 1)"></span>
                                                    @endif
                                                </td>
                                                <td>{{ $course->created_at }}</td>
                                                <td>
                                                    <a data-screen-permission-id="33" href="{{ url_secure_api('content-management/course?id=') . base64_encode($course->id) }}" class="btn btn-primary">Edit</a>
                                                   
                                                    @can('delete_course') 
                                                        <button data-screen-permission-id="34" onclick="confirmDelete('{{ $course->id }}')" class="btn btn-danger">Delete</button>
                                                    @endcan 
                                                    @if ($course->local_video)
                                                        <a href="{{ asset('/storage/'.$course->local_video) }}" class="btn btn-info" target="__blank" >Preview Video</a>
                                                    @endif

                                                    @if ($course->local_document)
                                                        <a href="{{ asset('/storage/'.$course->local_document) }}" class="btn btn-info" target="__blank">Preview Document</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="21" class="text-center"> <h2> No Record Found For Courses !!! </h2></td>
                                            </tr>
                                        @endforelse
                                    @endif 

                                    @include('Admin.partial.livewire.loadingData')

                            </tbody>

                        </table>
                        <div>
                            @if($readyToLoad)
                                {{ $coursesListing->links() }} 
                            @endif 
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

