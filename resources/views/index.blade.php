<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Video Chat Application</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link
          rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous"
        />

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <style type="text/css">
            :root {
                --jumbotron-padding-y: 3rem;
            }

            .jumbotron {
              padding-top: var(--jumbotron-padding-y);
              padding-bottom: var(--jumbotron-padding-y);
              margin-bottom: 0;
              background-color: #fff;
            }

            @media (min-width: 768px) {
              .jumbotron {
                padding-top: calc(var(--jumbotron-padding-y) * 2);
                padding-bottom: calc(var(--jumbotron-padding-y) * 2);
              }
            }

            .jumbotron p:last-child {
              margin-bottom: 0;
            }

            .jumbotron-heading {
              font-weight: 300;
            }

            .jumbotron .container {
              max-width: 40rem;
            }

            footer {
              padding-top: 3rem;
              padding-bottom: 3rem;
            }

            footer p {
              margin-bottom: .25rem;
            }

            .box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
        </style>
        
    </head>
    
    <body>
        <header>
            <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
              <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                  <h4 class="text-white">About</h4>
                  <p class="text-muted" style="color: #ccc!important;">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
                  @if(Auth::check())
                    <a href="{{ url('/logout') }}" class="btn btn-outline-secondary"><i class="fa fa-sign-out"></i> Logout</a>
                  @endif
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                  <h4 class="text-white">Contact</h4>
                  <ul class="list-unstyled">
                    <li><a href="https://github.com/snigdho991" class="text-white">Github</a></li>
                    <li><a href="https://www.facebook.com/snigdho.majumder" class="text-white">Facebook</a></li>
                    <li><a href="mailto:Snigdho2011@gmail.com" class="text-white">Email me</a></li>
                  </ul>

                </div>
              </div>
            </div>
            </div>
            
            <div class="navbar navbar-dark bg-dark box-shadow">
            <div class="container d-flex justify-content-between">
              <a href="#" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                <strong>Video Conference</strong>
              </a>

              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            
            </div>
            </div>

        </header>
    

        <main role="main">
            <section class="jumbotron text-center">
                @if(Auth::check())
                    <div class="container">
                      <h1>Video Conference</h1>
                      <p class="lead text-muted">
                        Hello, <b>{{ Auth::user()->name }} </b>. Create a virtual chat room to start a new conference. You can also join the available rooms to stay connected. 
                      </p>
                      <p>

                           {!! Form::open(['url' => 'room/create']) !!}
                               {!! Form::label('roomName', 'Enter Room Name') !!}
                            <div class="input-group mb-3">
                               {!! Form::text('roomName', null, ['class' => 'form-control']) !!}
                            
                            <div class="input-group-append">
                               {!! Form::submit('Add Room', ['class' => 'btn btn-outline-secondary']) !!}
                            </div>
                            </div>
                           {!! Form::close() !!}
                        
                      </p>
                    </div>
                @else
                    <div class="container">
                      <h1>Video Conference</h1>
                      <p class="lead text-muted">
                        You have to register first to get started with our application. If you already registered then just login and explore it along with your friends or family. Enjoy !
                      </p>
                      <p>
                        <a
                          href="{{ route('register') }}"
                          class="btn btn-primary my-2"
                          ><i class="fa fa-sign-in"></i> Complete registration</a
                        >
                        <a
                          href="{{ route('login') }}"
                          class="btn btn-secondary my-2"
                          ><i class="fa fa-user"></i> Login here</a
                        >
                      </p>
                    </div>
                @endif
            </section>

            <div class="album py-5 bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Currently Available Rooms -</h4>
                            <ul class="list-group list-group-horizontal-md">

                            
                                @if(count($rooms) > 0)
                                    @foreach ($rooms as $room)
                                        <li class="list-group-item"><a href="{{ url('/room/join/'.$room) }}" class="list-group-item-action">{{ $room }}</a></li>
                                    @endforeach
                                @else
                                    <li class="list-group-item">No room available.</li>
                                @endif
                            
                              
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="album py-5 bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                          <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="https://phillipbrande.files.wordpress.com/2013/10/random-pic-14.jpg" alt="Card image cap">
                            <div class="card-body">
                              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                              <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                  <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                                <small class="text-muted">9 mins</small>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div> -->

        </main>

        <footer class="text-muted" style="background: #F1F1F1;">
            <div class="container">
            <p class="float-right">
              <a href="#">Back to top</a>
            </p>
            <p>&copy; Copyrights 2020. Developed by <a href="https://www.facebook.com/snigdho.majumder">Snigdho</a></p>
            </div>
        </footer>


        <!-- <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
        
            <div class="content">
               <div class="title m-b-md">
                   Video Chat Rooms
               </div>
        
               {!! Form::open(['url' => 'room/create']) !!}
                   {!! Form::label('roomName', 'Create or Join a Video Chat Room') !!}
                   {!! Form::text('roomName') !!}
                   {!! Form::submit('Go') !!}
               {!! Form::close() !!}
        
               @if($rooms)
               @foreach ($rooms as $room)
                   <a href="{{ url('/room/join/'.$room) }}">{{ $room }}</a>
               @endforeach
               @endif
            </div>
        </div> -->
        <script
          src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
          integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
          crossorigin="anonymous"
        ></script>
        <script
          src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
          integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
          crossorigin="anonymous"
        ></script>
        <script
          src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
          integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
          crossorigin="anonymous"
        ></script>
    </body>
</html>
