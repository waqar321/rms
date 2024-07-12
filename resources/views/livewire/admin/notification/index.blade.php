@push('styles')
        <!-- ------------------- stack  styles ------------------------ -->
        <link href="{{ url_secure('vendors/multi_select/jquery.multiselect.css')}}" rel="stylesheet"/>
        <!-- <link href="{{ url_secure('vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet"> -->
        <link href="{{ url_secure('vendors/sweet_alert/sweetalert2.min.css')}}"  rel="stylesheet"/>
        <link href="{{ url_secure('build/css/livewire_components_action.css')}}" rel="stylesheet">
        <link href="{{ url_secure('build/css/livewireSelect2.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{ url_secure('build/css/jquery_ui.css')}}">

        <style>


            .select2
            {
                background-color: #f0f8ff; 
                color: #000 !important; 
                width: 100% !important;
            }
            .select2-selection--multiple
            {
                min-height: 32px;
            }
            .select2-search__field
            {
                width: 300px !important;
                height: 26px !important;
                padding: 4px !important;
            }

            /* .select2-container
            {
                display: block !important;

                width: 598px !important;
            }

            .selectFieldToCentre{
                text-align: center;"
            }

            .select2
            {
                background-color: #f0f8ff; 
                color: #000 !important; 
                width: 100% !important;
            }
            .select2-selection--multiple
            {
                min-height: 32px;
            }
            .select2-search__field
            {
                width: 300px !important;
                height: 26px !important;
                padding: 4px !important;
            }
            .selectFieldToCentre{
                text-align: center;"
            } */


            .TitleElement
            {
                width: 100% !important;
            }
            .BodyElement
            {
                width: 193% !important;
            }
            .CkEditorCSSLabel
            {
                padding-left: 10px;
            }
            .CkEditorCSS
            {
                width: 99%;
                margin-left: 9px;
            }
            .csv-info {
                color: blue;
            }
            
            .not-aligned-info {
                color: red;
            }

        </style>
        
        <style>

            /*       
                .container h1 {
                    color: #fff;
                    text-align: center;
                }

                details {
                    background-color: #303030;
                    color: #fff;
                    font-size: 1.5rem;
                }

                summary {
                    padding: .5em 1.3rem;
                    list-style: none;
                    display: flex;
                    justify-content: space-between;
                    transition: height 1s ease;
                }

                summary::-webkit-details-marker {
                    display: none;
                }

                summary:after {
                    content: "\002B";
                }
                details[open] summary {
                    border-bottom: 1px solid #aaa;
                    margin-bottom: .5em;
                }

                details[open] summary:after {
                    content: "\00D7";
                }

                details[open] div {
                    padding: .5em 1em;
                }

                .rights-section {
                    margin-top: 5%;
                }

                .rights-section details {
                    background-color: #ffcb05;
                    color: black;
                    margin-top: 1%;
                } 
                */
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

                    @include('Admin.notification.add')  
                    
                    @include('Admin.notification.list')  

            </div>
        </div>

       
      
@push('scripts')

        <!-- ------------------- stack  scripts ------------------------ -->        
        <script src="{{ url_secure('build/js/livewire_components_action.js')}}"></script>
        <script src="{{ url_secure('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
        <script src="{{ url_secure('vendors/validate/jquery.validate.min.js')}}"></script>
        <script src="{{ url_secure('build/js/main.js')}}"></script>
        <script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>
        <script src="{{ url_secure('build/js/livewireSelect2.js')}}"></script>
        <script src="{{ url_secure('build/js/ckeditor.js')}}"></script> <!-- ckeditor 5 -->
        <!-- <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script> -->
        <!-- ------------------- stack  scripts end  ------------------------ -->

    <script>

        $(document).ready(function() 
        { 
            ApplyAllSelect2(); 
        })

        var ModuleName = '{!! $JsMainTitle !!}';
        var readyToLoad = {!! json_encode($readyToLoad) !!};
        var GetEmployeeDataRoute = "{{ route('get.EmployeeData') }}";
        
    </script>
    
    <script src="{{ url_secure('build/js/LivewireDropDownSelect2.js')}}"></script>

@endpush