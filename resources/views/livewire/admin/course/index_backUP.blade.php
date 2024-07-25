@push('styles')

    <style>
        .select2-container{
            display: block!important;   
            width: 100%!important;
        }
    </style>

@endpush 

        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Manage Sub Category</h3>
                    </div>
                </div>
                <div class="clearfix"></div>

                    <!-- <div class="row">
                        <div class="col-md-12 col-lg-12" wire:ignore>
                            <a href="javascript:void(0)" onclick="uncollapsePanel(1)" class="close_form" >  </a>
                        </div>
                    </div> -->
                    <div wire:loading>
                        <div id="loadingBar">
                                please wait!!!            
                        </div>
                    </div>

                    <div class="row" id="addCategoryPanel"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2> Add Category </h2>
                                    <ul class="nav navbar-right panel_toolbox justify-content-end">
                                            <li>
                                                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                        </ul> 
                                    <div class="clearfix"></div>

                                </div>
                                <div wire:ignore.self class="x_content AddPanel">
                                    <!-- Form for creating a Category -->

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

                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Title<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="title" id="title" placeholder="Enter Title" class="form-control">
                                                    <!-- @error('title') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Description<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="description" id="description" placeholder="Enter Description" class="form-control">
                                                    <!-- @error('description') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Category<span class="danger">*</span></label>
                                                    <select wire:model="ecom_course.category_id" wire:click="ParentCategoryUpdated()"  name="category" id="category" class="form-control select2">
                                                        <option value="{{ $ecom_course->category->id ?? '' }}">{{ $ecom_course->category->name ?? '- Select a Parent Category -' }}</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Sub category - {{  $ecom_course }} <span class="danger">*</span></label>
                                                    <select wire:model="ecom_course.sub_category_id" name="sub_category" id="sub_category" class="form-control select2">
                                                        <option value="{{ $ecom_course->subCategory->name?? '' }}">{{ $ecom_course->subCategory->name ?? '- Select a Sub Category -' }}</option>
                                                            @if($ecom_course->category_id != null)
                                                                @foreach($subcategories as $subcategory)
                                                                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                                                @endforeach
                                                            @endif 
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-6" wire:ignore.self>
                                                <div class="form-group">
                                                    <label>Instructor <span class="danger">*</span></label>
                                                    <select wire:model="ecom_course.instructor_id" name="parent_category" id="parent_category" class="form-control select2">
                                                        <option value="{{ $ecom_course->instructor_id ?? '' }} ">{{ $ecom_course->Instructor->name ?? '- Select a Instructor -' }}  </option>
                                                        @foreach($instructors as  $instructor)
                                                            <option value="{{ $instructor->id }}">{{ $instructor->first_name }} </option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Duration<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="duration" id="duration" placeholder="Enter Duration" class="form-control">
                                                    <!-- @error('duration') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>level<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="ecom_course.level" id="name" placeholder="Enter Category level" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>price<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="ecom_course.price" id="name" placeholder="Enter Category price" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>prerequisites<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="ecom_course.prerequisites" id="name" placeholder="Enter Category prerequisites" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>language<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="ecom_course.language" id="name" placeholder="Enter Category language" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>course_material<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="ecom_course.course_material" id="name" placeholder="Enter Category course_material" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>enrollment_limit<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="ecom_course.enrollment_limit" id="name" placeholder="Enter Category enrollment_limit" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>end_date<span class="danger">*</span></label>
                                                    <input type="date" wire:model.debounce.1000ms="ecom_course.start_date" id="name" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>end_date<span class="danger">*</span></label>
                                                    <input type="date" wire:model.debounce.1000ms="ecom_course.end_date" id="name" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>course_format<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="ecom_course.course_format" id="name" placeholder="Enter Category course_format" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>course_code<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="ecom_course.course_code" id="name" placeholder="Enter Category course_code" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 ">
                                                <div class="form-group">
                                                    <label>tags<span class="danger">*</span></label>
                                                    <input type="text" wire:model.debounce.1000ms="ecom_course.tags" id="name" placeholder="Enter Category tags" class="form-control">
                                                    <!-- @error('name') <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span> @enderror -->
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Image</label>
                                                    <input type="file" wire:model="photo" id="imageInput"  class="form-control">
                                            </div>
                                            </div>

                                            @if($photo)
                                                @include('Admin.partial.imageshow', ['path' => $photo->temporaryUrl()])
                                            @elseif($ecom_course->image)
                                                @include('Admin.partial.imageshow', [
                                                                                        'path' => "/storage/".str_replace('category-management', '', $ecom_course->course_image)
                                                                                    ])
                                            @endif

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
    
                    <!-- <div class="row">
                        <div class="col-md-12 col-lg-12" wire:ignore>
                            <a href="javascript:void(0)" onclick="uncollapsePanel(0)" class="add_Category" >  </a>
                        </div>
                    </div> -->

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <div class="col-md-7 col-lg-7">
                                        <input type="search" wire:model="searchByName" class="form-control" placeholder="Search By Name...">
                                    </div>
                                    <div  class="col-md-2 col-lg-2">
                                        <button type="button" wire:click="resetInput(true)" class="btn btn-danger">
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
                                            <th>Description</th>
                                            <th>Category</th>
                                            <th>Sub-Category</th>
                                            <th>Instructor</th>
                                            <th>Duration</th>
                                            <th>Level</th>
                                            <th>Price</th>
                                            <th>Prerequisites</th>
                                            <th>Language</th>
                                            <th>Image</th>
                                            <th>Material</th>
                                            <th>Enrollment Limit</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Format</th>
                                            <th>Code</th>
                                            <th>Tags</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th>Actions</th>
                                        </tr>

                                        </thead>
                                    

                                        <tbody>
                                            @forelse($courses as $course)
                                                <tr>
                                                    <td>{{ $course->id }}</td>
                                                    <td>{{ $course->title }}</td>
                                                    <td>{{ $course->description }}</td>
                                                    <td>{{ $course->category->name }}</td>
                                                    <td>{{ $course->subCategory->name }}</td>
                                                    <td>{{ $course->instructor->name }}</td>
                                                    <td>{{ $course->duration }}</td>
                                                    <td>{{ $course->level }}</td>
                                                    <td>{{ $course->price }}</td>
                                                    <td>{{ $course->prerequisites }}</td>
                                                    <td>{{ $course->language }}</td>
                                                    <td>
                                                        @if($course->course_image)
                                                            <img src="{{ asset($course->course_image) }}" style="width: 70px; height: 45px;" class="me-4" alt="Img">
                                                        @endif
                                                    </td>
                                                    <td>{{ $course->course_material }}</td>
                                                    <td>{{ $course->enrollment_limit }}</td>
                                                    <td>{{ $course->start_date }}</td>
                                                    <td>{{ $course->end_date }}</td>
                                                    <td>{{ $course->course_format }}</td>
                                                    <td>{{ $course->course_code }}</td>
                                                    <td>{{ $course->tags }}</td>
                                                    <td>
                                                        @if($course->is_active == 1)
                                                            <span class="fa fa-toggle-on" wire:click="updateStatus({{ $course->id }}, 0)"></span>
                                                        @else
                                                            <span class="fa fa-toggle-off" wire:click="updateStatus({{ $course->id }}, 1)"></span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $course->created_at }}</td>
                                                    <td>
                                                        <a href="{{ url_secure_api('category-management/sub_category/?id=') . base64_encode($course->id) }}" class="btn btn-primary">Edit</a>
                                                        <button onclick="confirmDelete('{{ $course->id }}')" class="btn btn-danger">Delete</button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="21" class="text-center"> <h2> No Record Found For Sub Category !!! </h2></td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                    <div>
                                        {{ $courses->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php  
            // $collapse = (request()->has('id') || request()->has('page')) ?? true;
            // dd($collapse);
            // echo $collapse;
        ?>         

@push('scripts')

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
        
                $(document).ready(function() 
                {
                    // $('.parent_category').select2();
                });

                const urlParams = new URLSearchParams(window.location.search);                
                const collapse = urlParams.has('id') || urlParams.has('page');

                if(!collapse)
                {
                    $('.AddPanel').addClass('collapse');
                }

                if(collapse)
                {
                    // $('.Categorylabel').css('margin-top', '26px');
                }

                // Assuming you have an input element with the id "imageInput" for selecting the image
                // $('#imageInput').on('change', function() 
                // {                   
                //     if (this.files && this.files[0]) 
                //     {
                //         $('.Categorylabel').css('margin-top', '26px');
                //     } else {
                //         // No image selected, remove CSS
                //         $('.Categorylabel').css('margin-top', '0');
                //     }
                // });


                // $(document).ready(function() 
                // {
                //     $('#addCategoryPanel').css('display', 'none'); 
                // });
                
                function uncollapsePanel(collapse) 
                {
                    if(collapse == 0)
                    {
                        $('#addCategoryPanel').css('display', 'block');
                        $('.add_Category').css('display', 'none');
                        $('.close_form').css('display', 'block');
                    }
                    else
                    {
                        $('#addCategoryPanel').css('display', 'none');
                        $('.close_form').css('display', 'none');
                        $('.add_Category').css('display', 'block');
                    }
                }
                function confirmDelete(CategoryId) 
                {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You won\'t be able to revert this!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => 
                    {
                        if (result.isConfirmed) 
                        {
                            Livewire.emit('deleteCategory', CategoryId); 
                        }
                    });
                }

                window.addEventListener('deleted_scene', event => 
                {
                    const CategoryName = event.detail.category.name;
                    Swal.fire({
                        icon: 'success',
                        title: 'Category Deleted Successfully!',
                        text: `The Category ${CategoryName} has been deleted.`,
                    });                
                })
                window.addEventListener('status_updated', event => 
                {
                    const CategoryName = event.detail.category.name;
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated!!!!',
                        text: `The Category ${CategoryName} has been deleted.`,
                    });                
                })
                window.addEventListener('created_Category', event => 
                {
                    const categoryId = event.detail.category.id;
                    const imageElement = document.querySelector(`.selected-photo[data-category-id="${categoryId}"]`);
                    if (imageElement) {
                        imageElement.parentNode.removeChild(imageElement);
                    }
                    // $('#createCategoryModal').model('hide');
                    // const CategoryName = event.detail.Category.name;
                    Swal.fire({
                        icon: 'success',
                        title: 'Category Created Successfully!',
                        text: `The Category has been created.`,
                    });                
                })


        </script>

@endpush 
