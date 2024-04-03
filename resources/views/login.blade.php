<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NK DOOR FITTING</title>
    {{-- <meta name="theme-color" content="#ffb300"/> --}}
    {{-- <link rel="apple-touch-icon" href="{{ asset('app.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}"> --}}
    <link rel="stylesheet" href="{{asset('./assets/style/style.css')}}">
    <link rel="icon" href="{{asset('/assets/logo/logo.png')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Exo' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <style>
      body{
    font-family: 'Exo';
}
    </style>

    <style>
        body{
            background: linear-gradient(180deg, rgb(86, 84, 84) 50%, white 50%);
            height: 100vh;
        }
        span.field-icon {
    float: right;
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
    z-index: 2;
}
.inp{
    padding: 12px;
    width: 100%;
    border-bottom: 1px solid black;
    border-top: none;
    border-left: none;
    border-right: none;
}
input:focus{
    border-bottom: 1px solid green;
    border-top: none;
    border-left: none;
    border-right: none;
}
    </style>

</head>
<body ondblclick="window.location.reload();">
    <div>
        <div class="center">
            <img src="{{asset('/assets/logo/logo.png')}}" style="height: 200px;" alt="">
        </div>
    </div>
    <div class="container login-form">
        <div class="center">
            <span class="title">Login</span>
        </div>
        <form action="{{Route('auth')}}" autocomplete="off" method="post">
            {{ csrf_field() }}
            <span class="red-text center" style="font-size: 20px; font-weight:500; text-align:center;">{{session('error')}}</span>
            <div class="row">
                <div class="input-field col s12">
                  <input id="email" placeholder="User ID" type="text" name="username" class="validate browser-default inp" required>
                  {{-- <label for="email">User ID</label> --}}
                </div>
            </div> 
            {{-- <div class="row">
                <div class="col s11">
                    <div class="row">
                        <div class="input-field col s12">
                          <input id="password" type="password" name="password" class="validate" required>
                          <label for="password">Password</label>
                        </div>
                      </div>
                </div>
                <div class="col s1">
                    <i class="bi bi-eye-slash" id="togglepassword"></i>
                </div>
            </div> --}}
            <div class='row'>
                <div class='input-field col s12'>
                  <input class='validate browser-default inp' placeholder="password" type='password' name='password' id='password' required />
                  {{-- <label for='email'>Password</label> --}}
                  <span toggle="#password" class="field-icon toggle-password"><span class="material-icons">visibility</span></span>
                 </div>
             </div>
              <div class="center">
                <button class="theme btn waves-effect waves-light white-text grey darken-2" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                  </button>
              </div>
              
        </form>
    </div>
    <div >
        <div class="center" style="margin:60px; display:flex; align-items:center; justify-content:center;">
            <button class="waves-effect btn-large amber darknen-1 black-text" onclick="window.location.reload()" id="refreshbtn" style="display: block;">Refresh<i class="material-icons right">cached</i></button>
        </div>
    </div>
    <div style="height: 100px;">

    </div>
    <!--<div id="flash" class="popup section" style="margin-bottom: -2em; display: block; height: 214px; transform: translateY(0px);">
        <div class="container pWrapper">
        <div class="row">
        <div class="col s12 m8 offset-m2">
        <div class="card hoverable">
        <div class="card-content flow-text">
        {{-- <i class="close material-icons right" onclick="closeThis()" style="cursor: pointer;">close</i> --}}
        <p id="install-message">
        You can install this app for easy access.
        <button id="install" class="btn amber darken-1 black-text" style="margin: .5em auto auto auto; display: block;">Install Mypower Order</button>
        </p>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>-->

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    <script>
      let deferredPrompt;
      const addBtn = document.querySelector('#install');
      const card = document.querySelector('#flash');
      addBtn.style.display = 'none';
      card.style.display = 'none';
      window.addEventListener('beforeinstallprompt', (e) => {
     // Prevent Chrome 67 and earlier from automatically showing the prompt
     e.preventDefault();
     // Stash the event so it can be triggered later.
     deferredPrompt = e;
     // Update UI to notify the user they can add to home screen
     addBtn.style.display = 'block';
     card.style.display = 'block';
     addBtn.addEventListener('click', (e) => {
       // hide our user interface that shows our A2HS button
       addBtn.style.display = 'none';
      card.style.display = 'none';
       // Show the prompt
       deferredPrompt.prompt();
       // Wait for the user to respond to the prompt
       deferredPrompt.userChoice.then((choiceResult) => {
           if (choiceResult.outcome === 'accepted') {
             console.log('User accepted the A2HS prompt');
           } else {
             console.log('User dismissed the A2HS prompt');
           }
           deferredPrompt = null;
         });
     });
});
    </script>
    <script>
         $(document).ready(function(){  
//   var iOS = false,
    p = navigator.platform;
    if(p == 'iPhone' || p == 'iPod' || p == 'iPad'){
            $('#refreshbtn').css('display','block');
            }
            else{
            $('#refreshbtn').css('display','none')
    }
    });
    
        var clicked = 0;
$(".toggle-password").click(function (e) {
   e.preventDefault();
  $(this).toggleClass("toggle-password");
    if (clicked == 0) {
      $(this).html('<span class="material-icons">visibility_off</span >');
       clicked = 1;
    } else {
       $(this).html('<span class="material-icons">visibility</span >');
        clicked = 0;
     }
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
     input.attr("type", "text");
  } else {
     input.attr("type", "password");
  }
});
    </script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="{{asset('./assets/script/script.js')}}"></script>

</body>
</html>