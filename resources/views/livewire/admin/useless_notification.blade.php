
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        
                <button onclick="startFCM()"
                    class="btn btn-danger btn-flat">Allow notification
                </button>
            <div class="card mt-3">
                <div class="card-body">
                  
                    @foreach ($errors->all() as $key => $error)
                        <div class="col-mb-12 col-lg-12">
                            <div class="alert alert-danger" style="font-size: 13.5px;">
                                {{ $error }} !!!
                            </div>
                        </div>    
                    @endforeach

                    <form wire:submit.prevent="sendNotification" id="notification-form" method="POST">

                    <div class="form-group">
                            <label>Category</label>

                            <select wire:model="category_id"  name="category_id" id="category_id" class="form-control">
                                
                                    <!-- @if($category_id)
                                        <option value="{{ $category_id ?? '' }}"> {{ $ecom_course_assign->Course->name  ?? '- Select an Course -' }} </option>                                                    
                                        <option disabled>───────────</option>                                                  
                                    @elseif (!empty($parent_categories))

                                    @endif -->
                                    <option value="">-- choose Category  --</option>
                                    <option disabled>───────────</option>                          

                                    @foreach($parent_categories as $category_id => $category)
                                        <option value="{{ $category_id }} "> {{ $category }} </option>   
                                    @endforeach 
                            </select>

                        </div>

                        <div class="form-group">
                            <label>Department</label>
                                <select wire:model="department_id"  name="department_id" id="department_id" class="form-control">
                                    <option value="">-- choose Department  --</option>
                                    <option disabled>───────────</option>   
                       
                                    @foreach($departments as $department_id => $department)
                                        <option value="{{ $department_id }} "> {{ $department }} </option>   
                                    @endforeach 
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Sub Department</label>
                                <select wire:model="childDepartment_id"  name="childDepartment_id" id="childDepartment_id" class="form-control">
                                    <option value="">-- choose Department  --</option>
                                    <option disabled>───────────</option>   
                       
                                    @foreach($sub_departments as $childDepartment_id => $department)
                                        <option value="{{ $childDepartment_id }} "> {{ $department }} </option>   
                                    @endforeach 
                                </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Designation</label>
                                <select wire:model="designation_id"  name="designation_id" id="designation_id" class="form-control">
                                    <option value="">-- choose Designation  --</option>
                                    <option disabled>───────────</option>   
                    
                                    @foreach($designations as $designation_id => $Designation)
                                        <option value="{{ $designation_id }} "> {{ $Designation }} </option>   
                                    @endforeach 
                                </select>
                        </div>

                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="text" wire:model='title' class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Message Body</label>
                            <textarea class="form-control" wire:model='bodyMessage' name="body"></textarea>
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
        
    <script>

        // var NotificaitonSent = {!! json_encode(session('status') ? true : false) !!};

        // if(NotificaitonSent)
        // {
        //     Swal.fire({
        //         icon: 'success',
        //         title: 'Notification Sent Successfully!',
        //         text: 'The Notification has been generated!!!.',
        //     });    
        // }
        document.addEventListener('livewire:load', function () 
        {
            Livewire.on('notificationSent', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Notification Sent Successfully!',
                    text: 'The Notification has been generated!!!.',
                });    
            });
            
        });
        window.addEventListener('token_created', event => 
        {
            Swal.fire({
                icon: 'success',
                title: 'Token Saved Successfully!',
                text: 'The Notification token has been updated on User.',
            });                
        });


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
                .then(function (response) 
                {

                    Livewire.emit('updateDeviceToken', response);

                    // var csrfToken = $('#notification-form input[name="_token"]').val();

                    // $.ajaxSetup({
                    //     headers: {
                    // //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    //         'X-CSRF-TOKEN': $('#notification-form input[name="_token"]').val()
                    //     }
                    // });
                    // $.ajax({
                    //     url: '{{ route("notification.updateDeviceToken") }}',
                    //     type: 'POST',
                    //     data: {
                    //         // _token: csrfToken, // Include CSRF token
                    //         token: response
                    //     },
                    //     dataType: 'JSON',
                    //     success: function (response) {
                    //         alert('Token stored.');
                    //     },
                    //     error: function (error) {
                    //         alert(error);
                    //     },
                    // });
                }).catch(function (error) {
                    // alert(error);
                    alert('Error obtaining permission:', error);
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

@endpush 
