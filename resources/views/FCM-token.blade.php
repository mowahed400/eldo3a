<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>FCM-Token</title>
</head>

<body>

    <div class="container mt-5">

        <div class="alert alert-danger" id="error" style="display: none;"></div>

        <div class="alert alert-success" id="success" style="display: none;"></div>

        <form class="form" id="add-form" action="/sendFCM" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <label for="fcm_token" class="form-control-label">FCM-Token </label>
                <input value="" class="form-control" type="text" name="fcm_token" required >
            </div>

            <button type="submit" class="btn btn-primary mt-3">
                <span class="d-none d-md-inline">Send</span>
            </button>
        </form>

    </div>

    <div class="container mt-5">
        <div class="alert alert-success" id="successResponse" style="display: none;">
            <p id="successTitle"></p>
            <p id="successBody"></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script><!-- The core Firebase JS SDK is always required and must be listed first -->

    <!-- TODO: Add SDKs for Firebase products that you want to use
         https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>

    <script>

        // Your web app's Firebase configuration
        @include('firebase-config');

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const channel = new BroadcastChannel('sw-messages');
        const messaging = firebase.messaging();

        messaging.requestPermission()
            .then(() => {
                return messaging.getToken()
            })
            .then((token) => {
                $("#success").text(token);
                $("#success").show();
            })
            .catch((err) => {
                $("#error").text(err);
                $("#error").show();
            })

        $("#add-form").on('submit', function (e) {
            e.preventDefault();
            let action = $(this).attr('action');
            $.ajax({
                type: 'POST',
                url: action,
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,

                success: function (result) {
                    //
                }
            });
        });

        messaging.onMessage((payload) => {
            console.log(payload)
            $('#successTitle').text(payload.notification.title);
            $('#successBody').text(payload.notification.body);
            $('#successResponse').show();
        });

    </script>

</body>
</html>
