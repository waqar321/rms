@push('styles')

    <link href="{{ url_secure('build/css/livewire_components_action.css')}}" rel="stylesheet">
    
    <style>

        /* .select2-container{
            display: block!important;   
            width: 100%!important;
        } */

    </style>

@endpush 
    @section('title') {{ $MainTitle }} Listing  @endsection

        <div class="right_col" role="main">
            <div class="">

                @include('Admin.partial.livewire.header')                 

                @include('Admin.manage_course.course.add')      
      
                @include('Admin.manage_course.course.list')      
                
            </div>
        </div>

       
@push('scripts')
        <script>
                var ModuleName = '{!! $MainTitle !!}';
                document.addEventListener('livewire:submit', function () {
                    document.getElementById('imageInput').value = '';
                });
        </script>
        <script src="{{ url_secure('build/js/livewire_components_action.js')}}"></script>

        <!-- AAAAPMgZejw:APA91bFjS_TPXqLyyXxGj_qJHRwB_-xiV1DFfxDfOjpqeKvmxxKI81F4XWbD8uyYdhQSV6R-ilX9vg5rfS7Fe2NNLBIIUl7cXiTlGsKOiCzicvP7rhyBnUigWGSKundOG4zcUulrAucQ -->

        <script type="module">
                // Import the functions you need from the SDKs you need
                // import { initializeApp } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-app.js";
                // import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.11.1/firebase-analytics.js";
                // TODO: Add SDKs for Firebase products that you want to use
                // https://firebase.google.com/docs/web/setup#available-libraries

                // Your web app's Firebase configuration
                // For Firebase JS SDK v7.20.0 and later, measurementId is optional
                // const firebaseConfig = {
                //     apiKey: "AIzaSyBzrs8qWFaw-d2PtWI61ZWYao3-I8wY9a0",
                //     authDomain: "learning-manage-system-446a5.firebaseapp.com",
                //     projectId: "learning-manage-system-446a5",
                //     storageBucket: "learning-manage-system-446a5.appspot.com",
                //     messagingSenderId: "261055150652",
                //     appId: "1:261055150652:web:38b334cecd6efef6a06139",
                //     measurementId: "G-47XFJ4N8J6"
                // };

                // Initialize Firebase
                // const app = initializeApp(firebaseConfig);
                // const analytics = getAnalytics(app);
        </script>
@endpush 
