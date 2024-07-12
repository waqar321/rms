    <div class="table-responsive">
        <table class="table table-bordered" style="font-weight: bold;">
        <tbody>
            <tr>
                <td>Course Code</td>
                <td> {{ $ecom_course->course_code }} </td>
            </tr>
            <tr>
                <td>Course Levels</td>
                <td> {{ $ecom_course->level }} </td>
            </tr>
            <tr>
                <td>Course Duration</td>
                <td> {{ $ecom_course->duration }} </td>
            </tr>
            <tr>
                <td>Start Date</td>
                <td>{{ \Carbon\Carbon::parse($ecom_course->start_date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>End Date</td>
                <td>{{ \Carbon\Carbon::parse($ecom_course->end_date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Who Can Join</td>
                <td>Concerns</td>
            </tr>
            <tr>
                <!-- <td>Total Trained</td>
                <td>1500</td> -->
            </tr>
            <tr>
                <td>Video Medium</td>
                <td> {{ $ecom_course->end_date }} </td>
            </tr>
            <tr>
                <td>Tags</td>
                <td> {{ $ecom_course->tags }} </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
        </table>
    </div>
    
    <!-- <button wire:click="JoinNow()" style="background-color: #ffcb05;" type="button" class="btn  btn-lg btn-block">Join Now</button>

    <h1>What Will You Learn</h1>
    <p>After completion of this course student will be able to:</p>
    <ul style="list-style: none;">
        <li>
            <button type="button" class="btn btn-warning btn-sm rounded-circle">
            <i class="fas fa-check text-white" style="font-size: 10px;"></i>
            </button>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consequuntur
        </li>
        <br> -->
        <!-- <li>
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
        </li> -->
        <!-- <br>
    </ul>                   -->