@extends('Admin.layout.main')

@push('styles')
    <style>
  


    </style>
@endpush 

@section('content')
      


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           
                <button onclick="startFCM()"
                    class="btn btn-danger btn-flat">Allow notification
                </button>
            <div class="card mt-3">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        <!-- {{ session('status') }} -->
                    </div>
                    @endif
                    <form action="{{ route('notification.sendNotification') }} " id="notification-form" method="POST">
                        @csrf

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Message Body</label>
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@push('LinkscriptsAtTop')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush 

<script>

    var NotificaitonSent = {!! json_encode(session('status') ? true : false) !!};

    if(NotificaitonSent)
    {
        Swal.fire({
            icon: 'success',
            title: 'Notification Sent Successfully!',
            text: 'The Notification has been generated!!!.',
        });    
    }

</script>



 <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyBzrs8qWFaw-d2PtWI61ZWYao3-I8wY9a0",
        authDomain: "learning-manage-system-446a5.firebaseapp.com",
        projectId: "learning-manage-system-446a5",
        storageBucket: "learning-manage-system-446a5.appspot.com",
        messagingSenderId: "261055150652",
        appId: "1:261055150652:web:38b334cecd6efef6a06139",
        measurementId: "G-47XFJ4N8J6"
        
    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    function startFCM() {
        messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function (response) {

                // var csrfToken = $('#notification-form input[name="_token"]').val();

                $.ajaxSetup({
                    headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        'X-CSRF-TOKEN': $('#notification-form input[name="_token"]').val()
                    }
                });
                $.ajax({
                    url: '{{ route("notification.updateDeviceToken") }}',
                    type: 'POST',
                    data: {
                        // _token: csrfToken, // Include CSRF token
                        token: response
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token stored.');
                    },
                    error: function (error) {
                        alert(error);
                    },
                });
            }).catch(function (error) {
                alert(error);
            });
    }
    messaging.onMessage(function (payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>

<!-- Service Worker Registration -->
<script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then(function(registration) {
                    console.log('Service Worker registered:', registration);
                })
                .catch(function(error) {
                    console.error('Service Worker registration failed:', error);
                });
        });
    }
</script>


@endsection