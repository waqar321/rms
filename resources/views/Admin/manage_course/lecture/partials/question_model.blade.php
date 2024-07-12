



@push('styles')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

    /* *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body{
        background-color: #333;
    }
    .container{
        background-color: #555;
        color: #ddd;
        border-radius: 10px;
        padding: 20px;
        font-family: 'Montserrat', sans-serif;
        max-width: 700px;
    }
    .container > p{
        font-size: 32px;
    }
    .question{
        width: 75%;
    }
    .options{
        position: relative;
        padding-left: 40px;
    }
    #options label{
        display: block;
        margin-bottom: 15px;
        font-size: 14px;
        cursor: pointer;
    }
    .options input{
        opacity: 0;
    }
    .checkmark {
        position: absolute;
        top: -1px;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #555;
        border: 1px solid #ddd;
        border-radius: 50%;
    }
    .options input:checked ~ .checkmark:after {
        display: block;
    }
    .options .checkmark:after{
        content: "";
        width: 10px;
        height: 10px;
        display: block;
        background: white;
        position: absolute;
        top: 50%;
        left: 50%;
        border-radius: 50%;
        transform: translate(-50%,-50%) scale(0);
        transition: 300ms ease-in-out 0s;
    }
    .options input[type="radio"]:checked ~ .checkmark{
        background: #21bf73;
        transition: 300ms ease-in-out 0s;
    }
    .options input[type="radio"]:checked ~ .checkmark:after{
        transform: translate(-50%,-50%) scale(1);
    }
    .btn-primary{
        background-color: #555;
        color: #ddd;
        border: 1px solid #ddd;
    }
    .btn-primary:hover{
        background-color: #21bf73;
        border: 1px solid #21bf73;
    }
    .btn-success{
        padding: 5px 25px;
        background-color: #21bf73;
    }
    @media(max-width:576px){
        .question{
            width: 100%;
            word-spacing: 2px;
        } 
    } */

</style>

@endpush 


<div id="quiz-form-container" >
    <div class="modal" id="quizModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $ecom_lecture->title }} Quiz  
                            @php 
                                // echo "<pre>";
                                // print_r($answers);
                                // echo "</pre>";
                            @endphp 
                        </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" >
                    <form  id="quiz-form">
                        <div class="row">
                            <div class="row mt-6 mb-6 col-lg-12">

                                <!-- --------------------questionlevel--------------------- -->
                                <div id="questionlevel" style="display:none;">
                                    <div class="col-12">
                                        <label for=""> <div class="py-2 h5"><b id="question">Q. which option best describes your job role?</b></div> 
                                        </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="radio" value="Answer1" name="radio1"> <span class="checkmark"></span> 
                                        <label class="options" id="answer1">Small Business Owner or Employee </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="radio" value="Answer2" name="radio2"> <span class="checkmark"></span>
                                        <label class="options" id="answer2">Nonprofit Owner or Employee </label>
                                    </div>
                                    <div class="col-12">
                                            <input type="radio" value="Answer3" name="radio3"> <span class="checkmark"></span>
                                            <label class="options" id="answer3">Journalist or Activist </label>
                                    </div>
                                    <div class="col-12">
                                        <input type="radio" value="Answer4" name="radio4"> <span class="checkmark"></span>
                                            <label class="options" id="answer4">Other </label>
                                    </div>
                                </div>
                                <!-- --------------------questionlevel--------------------- -->

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" id="ModalFormSubmit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div> 


@push('scripts')
      <script>
             
            $(document).ready(function() 
            {

            });
            
        </script>
@endpush 

<!-- =======================================================================================================

<div id="quiz-form-container" >
    <div class="modal" id="quizModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ $ecom_lecture->title }} Quiz  
                            @php 
                                // echo "<pre>";
                                // print_r($answers);
                                // echo "</pre>";
                            @endphp 
                        </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body" >
                    <form  id="quiz-form">
                        <div class="row">
                                <div class="question ml-sm-5 pl-sm-5 pt-2">
                                    <div class="py-2 h5"><b>Q. which option best describes your job role?</b></div>
                                    <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">
                                        <label class="options">Small Business Owner or Employee
                                            <input type="radio" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="options">Nonprofit Owner or Employee
                                            <input type="radio" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="options">Journalist or Activist
                                            <input type="radio" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="options">Other
                                            <input type="radio" name="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</div> -->
