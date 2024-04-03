<html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
       <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        
        <link rel="stylesheet" href="{{asset('assets/style/style.css')}}">
        <title>NK DOOR</title>
        <meta name="theme-color" content="#808080"/>
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        <link rel="icon" href="{{asset('icons/favicon-32x32.png')}}">
        <link rel="shortcut icon" href="{{ asset('icons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
        <link rel="mask-icon" href="{{asset('icons/safari-pinned-tab.svg')}}" color="#111111">
        <link rel="icon" href="{{asset('assets/logo/logo.png')}}">
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta name="csrf-token" content="{{ csrf_token() }}" />

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>

    <body>
      <div class="fixed-action-btn">
        <a class="btn-floating btn-large grey darken-2">
          <i class="large material-icons">add</i>
        </a>
        <ul>
          <li><a href="{{url('/addorder')}}" accesskey="O" class="modal-trigger btn-floating red darken-2"><i class="material-icons">add_circle</i></a></li>
          <li><a href="#addpayment" accesskey="P" class="modal-trigger btn-floating yellow darken-2"><i class="material-icons">attach_money</i></a></li>
          <li><a class="modal-trigger btn-floating green darken-2"><i class="material-icons">keyboard_return</i></a></li>
          <li><a href="#addexpense" accesskey="X" class="modal-trigger btn-floating blue darken-2"><i class="material-icons">request_quote</i></a></li>
        </ul>
      </div>
      <div id="addpayment" class="modal">
        <div class="modal-content">
          <h4>Add Payment</h4>
          <form id="addpayform" class="row">
              @csrf
              <div class="col s12 m6">
                <input type="date" name="date" placeholder="Date" required>
              </div>
              <div class="input-field col s12 m6">
                <input type="text" name="username" id="username" placeholder="User" class="autocomplete">
                {{-- <label for="autocomplete-input">User</label> --}}
              </div>
              <div class="input-filed col s12 m6">
                <select name="type" required>
                    <option value="" disabled selected>Type</option>
                    <option value="bank">Bank</option>
                    <option value="cheque">Cheque</option>
                    <option value="cash">Cash</option>
                  </select>
              </div>
              <div class="col s12 m6">
                <input type="text" name="amount" placeholder="amount" required>
              </div>
              <div class="center col s12" style="margin-top:5vh;">
                <button class="btn theme waves-effect modal-close" id="addbtn" type="submit">Submit<i class="material-icons right">send</i></button>
              </div>
          </form>
        </div>
        <div class="modal-footer">

        </div>
      </div>
      <div id="addexpense" class="modal">
        <div class="modal-content">
          <h4>Add Expense</h4>
          <form id="addexpform" class="row">
              @csrf
              <div class="col s12 m6">
                <input type="date" name="date" placeholder="Date" required>
              </div>
              <div class="input-field col s12 m6">
                <input type="text" name="username" id="username" placeholder="User" class="autocomplete">
                {{-- <label for="autocomplete-input">User</label> --}}
              </div>
              <div class="col s12 m6">
                <input type="text" name="particular" placeholder="particular" required>
              </div>
              <div class="col s12 m6">
                <input type="text" name="amount" placeholder="amount" required>
              </div>
              <div class="center col s12" style="margin-top:5vh;">
                <button class="btn theme waves-effect modal-close" id="addbtn" type="submit">Submit<i class="material-icons right">send</i></button>
              </div>
          </form>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    <header>
        <nav class="white">
            <div class="nav-wrapper">
              <a href="#!" class="brand-logo hide-on-med-and-down"><img src="../assets/logo/logo.png" height="60" style="margin-left: 20px;" alt="NK"></a>
              <a href="#!" class="brand-logo hide-on-large-only"><img src="../assets/logo/logo.png" height="55" alt="NK"></a>
              <a href="#" data-target="slide-out" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
              <a class="black-text right hide-on-large-only" style="margin-right: 15px;" href="{{url('/logout')}}"><i class="material-icons">exit_to_app</i></a>
              <ul class="right hide-on-med-and-down">
                {{-- <li><a class="black-text" href=""><i class="material-icons">notifications</i></a></li> --}}
                <li><a class="black-text" href="{{url('/logout')}}"><i class="material-icons">exit_to_app</i></a></li>
                <li></li>
              </ul>
            </div>
          </nav>
    </header>
    <ul id="slide-out" class="theme sidenav sidenav-fixed">
        <li><a href="#!" class="white-text">{{$user->name}}</a></li>
        <li><a href="{{url('/dashboard')}}" class="white-text">DashBoard<i class="white-text material-icons">dashboard</i></a></li>
        <li><a href="{{url('/customer')}}" class="white-text">Customer<i class="white-text material-icons">face</i></a></li>
        <li>
          <ul class="collapsible">
            <li>
              <div class="collapsible-header white-text"><i class="material-icons">receipt_long</i>Transactions</div>
              <div class="collapsible-body grey darken-2">
                <ul>
                  <li><a href="{{url('/order')}}" class="white-text">Orders<i class="white-text material-icons">shopping_basket</i></a></li>
                  <li><a href="{{url('/addorder')}}" accesskey="O" class="white-text">Create Order<i class="white-text material-icons">add_circle</i></a></li>
                  <li><a href="{{url('/payment')}}" class="white-text">Payment<i class="white-text material-icons">attach_money</i></a></li>
                  <li><a href="" class="white-text">Sales Return<i class="white-text material-icons">keyboard_return</i></a></li>
                  <li><a href="{{url('/expense')}}" class="white-text">Expense<i class="white-text material-icons">request_quote</i></a></li>          
                </ul>
              </div>
            </li>
          </ul>
        </li>
        <li>
          <ul class="collapsible">
            <li>
              <div class="collapsible-header white-text"><i class="material-icons">inventory_2</i>Inventory</div>
              <div class="collapsible-body grey darken-2">
                <ul>
                  <li><a href="{{url('/category')}}" class="white-text">Category<i class="white-text material-icons">category</i></a></li>
                  <li><a href="{{url('/subcategory')}}" class="white-text">Sub-Category<i class="white-text material-icons">interests</i></a></li>
                  <li><a href="{{url('/product')}}" class="white-text">Products<i class="white-text material-icons">inventory_2</i></a></li>          
                </ul>
              </div>
            </li>
          </ul>
        </li>
        
      </ul>
        <main>
            @yield('main') 
            <div id="flash" class="popup section" style="margin-bottom: -2em; display: block; height: 214px; transform: translateY(0px);">
              <div class="container pWrapper">
              <div class="row">
              <div class="col s12 m8 offset-m2">
              <div class="card hoverable">
              <div class="card-content flow-text">
              {{-- <i class="close material-icons right" onclick="closeThis()" style="cursor: pointer;">close</i> --}}
              <p id="install-message">
              You can install this app for easy access.
              <button id="install" class="btn grey darken-2 white-text" style="margin: .5em auto auto auto; display: block;">Install</button>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="{{asset('assets/script/script.js')}}"></script>
       
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
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    </body>
  </html>