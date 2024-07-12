<!-- <div> -->
    <!-- Some content -->
    <!-- Some content -->


    @push('scripts')

    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
    <script>
        
                // var tokenFound = {!! json_encode($tokenFound) !!};

                document.addEventListener('livewire:load', function () 
                {
                    
                    // ----------Register the Service Worker in Your Application---------------
                    if ('serviceWorker' in navigator) {
                        navigator.serviceWorker.register('/build/js/firebase-messaging-sw.js')
                            .then(function(registration) {
                                console.log('Service Worker registration successful with scope: ', registration.scope);
                            }).catch(function(err) {
                                console.log('Service Worker registration failed: ', err);
                            });
                    }

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

                    startFCM();

                    function startFCM() 
                    {
                        messaging
                            .requestPermission()
                            .then(function () {
                                return messaging.getToken()
                            })
                            .then(function (response) 
                            {
                                // console.log('emitted event');
                                Livewire.emit('CheckForDeviceToken', response);
                            }).catch(function (error) 
                            {
                                console.log('Error obtaining permission:', error);
                            });
                    }
                    messaging.onMessage(function (payload) 
                    {
                        const title = payload.notification.title;
                        const options = {
                            body: payload.notification.body,
                            icon: payload.notification.icon,
                        };

                        var notificationdDetail = new Notification(title, options);
                        console.log(notificationdDetail);
                        
                        //========================== update notification bar =====================
                        
                        Livewire.emit('refreshNotificationComponent');

                        //========================== update notification bar =====================
                    });
                });
            
                window.addEventListener('ReturnTokenCheckResponse', event => 
                {
                    if(event.detail.tokenFound == false)
                    {
                        Swal.fire({
                            title: "Allow Notification?",
                            // text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes"
                            }).then((result) => {
                            if (result.isConfirmed) 
                            {
                                Livewire.emit('add_token', event.detail.token_number);                            
                            }
                        });
                    } 
                    else
                    {
                        // alert('welcome ');
                    }        
                });
                window.addEventListener('token_added', event => 
                {
                    Swal.fire({
                        title: "Updated!!!",
                        text: "your will recieved notifications from onwards .",
                        icon: "success"
                    });
                });

        </script>
    @endpush

<script>
            // $(document).ready(function()
            // {
            //     alert('device token checking'); 
            //     Livewire.emit('CheckForDeviceToken');
            // });
            // // alert('it is working but ');
           
            
            // window.addEventListener('ReturnTokenCheckResponse', event => 
            // {
            //     alert('yes sweet alert not owr'); 

            //     Swal.fire({
            //         icon: 'success',
            //         title: 'Token check !',
            //         text: 'The Notification token has been updated on User.',
            //     });                
            // });
            
            // ============= check for device token ============= 
    </script>
<!-- </div> -->