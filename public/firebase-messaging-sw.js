  importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
  importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

  firebase.initializeApp({
      apiKey: "AIzaSyDiGqH37TxMMRzRm1IPaMMFu3czAIbh1-c",
      authDomain: "tawsil-maa-mousafir.firebaseapp.com",
      projectId: "tawsil-maa-mousafir",
      storageBucket: "tawsil-maa-mousafir.appspot.com",
      messagingSenderId: "136026958277",
      appId: "1:136026958277:web:99309516c5bf837e52c3ac"
  });

  // Retrieve an instance of Firebase Messaging so that it can handle background
  // messages.
  const messaging = firebase.messaging();
  const channel = new BroadcastChannel('sw-messages');

  messaging.onBackgroundMessage(function(payload) {
    channel.postMessage({payload});

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
      body: payload.notification.body,
      icon: '',
      badge:'',
    };

  //   self.registration.showNotification(notificationTitle,
  //     notificationOptions);
  // });
  //
  // self.addEventListener('notificationclick', function (event) {
  //     event.notification.close();
  //     event.waitUntil(self.clients.openWindow(event.notification.data));
  });




