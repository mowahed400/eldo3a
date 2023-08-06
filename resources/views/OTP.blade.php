<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('assets/admin/app-assets/css/plugins/loading.min.css')}}">
    <link
        rel="stylesheet" type="text/css"
        href="//cdn.jsdelivr.net/gh/loadingio/ldbutton@v1.0.1/dist/ldbtn.min.css"
    />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>OTP TEST</title>
</head>
<body>
<div class="container mt-5" style="max-width: 550px">
    <div class="btn btn-primary ld-ext-right"
         onclick="this.classList.toggle('running')">
        Clike Me
        <div class="ld ld-ring ld-spin"></div>
    </div>
    <div class="alert alert-danger" id="error" style="display: none;"></div>

    <h3>Add Phone Number</h3>

    <div class="alert alert-success" id="successAuth" style="display: none;"></div>

    <form>
        <label>Phone Number:</label>

        <input type="text" id="number" class="form-control" placeholder="+213 05*******">

        <div id="recaptcha-container"></div>

        <button type="button" class="btn btn-primary mt-3" onclick="sendOTP();">Send OTP</button>
    </form>


    <div class="mb-5 mt-5">
        <h3>Add verification code</h3>

        <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>

        <form>
            <input type="text" id="verification" class="form-control" placeholder="Verification code">
            <button type="button" class="btn btn-danger mt-3" onclick="verify()">Verify code</button>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script><!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-auth.js"></script>

<script>
    // Your web app's Firebase configuration
    @include('firebase-config');

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    window.onload = function () {
        render();
    };

    function render() {
        window.recaptchaVerifier = new firebase.default.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }

    function sendOTP() {
        var number = $("#number").val();
        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
            window.confirmationResult = confirmationResult;
            coderesult = confirmationResult;
            console.log(coderesult);
            $("#successAuth").text("Message sent");
            $("#successAuth").show();
        }).catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
        });
    }

    function verify() {
        var code = $("#verification").val();
        coderesult.confirm(code).then(function (result) {
            var user = result.user;
            console.log(user);
            $("#successOtpAuth").text("Auth is successful");
            $("#successOtpAuth").show();
        }).catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
        });
    }
</script>
</body>
</html>
