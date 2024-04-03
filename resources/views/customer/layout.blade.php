<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <link rel="stylesheet" href="{{ asset('assets/style/style.css') }}">
    <title>NK DOOR</title>
    <meta name="theme-color" content="#808080" />
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <link rel="icon" href="{{ asset('icons/favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('icons/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
    <link rel="mask-icon" href="{{ asset('icons/safari-pinned-tab.svg') }}" color="#111111">
    <link rel="icon" href="{{ asset('assets/logo/logo.png') }}">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <nav class="white">
            <div class="nav-wrapper">
                <a href="#!" class="brand-logo hide-on-med-and-down"><img src="../assets/logo/logo.png"
                        height="60" style="margin-left: 20px;" alt="NK"></a>
                <a href="#!" class="brand-logo hide-on-large-only"><img src="../assets/logo/logo.png"
                        height="55" alt="NK"></a>
                <a href="#" data-target="slide-out" class="sidenav-trigger left"><i
                        class="material-icons black-text">menu</i></a>
                <a class="black-text right hide-on-large-only" style="margin-right: 15px;"
                    href="{{ url('/logout') }}"><i class="material-icons">exit_to_app</i></a>
                <ul class="right hide-on-med-and-down">
                    {{-- <li><a class="black-text" href=""><i class="material-icons">notifications</i></a></li> --}}
                    <li><a class="black-text" href="{{ url('/logout') }}"><i class="material-icons">exit_to_app</i></a>
                    </li>
                    <li></li>
                </ul>
            </div>
        </nav>
    </header>
    <ul id="slide-out" class="theme sidenav sidenav-fixed">
        <li><a href="#!" class="white-text">{{ $user->name }}</a></li>
        <li><a href="{{ url('/customer/home') }}" class="white-text">Home<i
                    class="white-text material-icons">home</i></a></li>
    </ul>
    <main>
        @yield('main')
        <div id="flash" class="popup section"
            style="margin-bottom: -2em; display: block; height: 214px; transform: translateY(0px);">
            <div class="container pWrapper">
                <div class="row">
                    <div class="col s12 m8 offset-m2">
                        <div class="card hoverable">
                            <div class="card-content flow-text">
                                {{-- <i class="close material-icons right" onclick="closeThis()" style="cursor: pointer;">close</i> --}}
                                <p id="install-message">
                                    You can install this app for easy access.
                                    <button id="install" class="btn grey darken-2 white-text"
                                        style="margin: .5em auto auto auto; display: block;">Install</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--JavaScript at end of body for optimized loading-->
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="{{ asset('assets/script/script.js') }}"></script>

    <script>
        // document.addEventListener('contextmenu', event => event.preventDefault());

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
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function(reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
</body>

</html>
