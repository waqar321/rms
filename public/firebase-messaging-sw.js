// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyBzrs8qWFaw-d2PtWI61ZWYao3-I8wY9a0",
    authDomain: "learning-manage-system-446a5.firebaseapp.com",
    projectId: "learning-manage-system-446a5",
    storageBucket: "learning-manage-system-446a5.appspot.com",
    messagingSenderId: "261055150652",
    appId: "1:261055150652:web:38b334cecd6efef6a06139",
    measurementId: "G-47XFJ4N8J6"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});