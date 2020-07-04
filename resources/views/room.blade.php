<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
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


        <!-- Styles -->
        <!-- <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
        
            .full-height {
                height: 100vh;
            }
        
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
        
            .position-ref {
                position: relative;
            }
        
            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
        
            .content {
                text-align: center;
            }
        
            .title {
                font-size: 84px;
            }
        
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
        
            .m-b-md {
                margin-bottom: 30px;
            }
        </style> -->
        <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
        <script>
            Twilio.Video.createLocalTracks({
               audio: true,
               video: { width: 300 }
            }).then(function(localTracks) {
               return Twilio.Video.connect('{{ $accessToken }}', {
                   name: '{{ $roomName }}',
                   tracks: localTracks,
                   video: { width: 300 }
               });
            }).then(function(room) {
               console.log('Successfully joined a Room: ', room.name);

               room.participants.forEach(participantConnected);

               var previewContainer = document.getElementById(room.localParticipant.sid);
               if (!previewContainer || !previewContainer.querySelector('video')) {
                   participantConnected(room.localParticipant);
               }

               room.on('participantConnected', function(participant) {
                   console.log("Joining: '" +  participant.identity +  "'");
                   participantConnected(participant);
               });

               room.on('participantDisconnected', function(participant) {
                   console.log("Disconnected: '" +  participant.identity  + "'");
                   participantDisconnected(participant);
               });
            });
            // additional functions will be added after this point //edited
            function participantConnected(participant) {
               console.log('Participant "%s" connected', participant.identity);

                const div = document.createElement('div');
                div.id = participant.sid;
                div.setAttribute("style", "float: left; margin: 10px;");
                div.innerHTML = "<div style='clear:both'>" + participant.identity + "</div>";

               participant.tracks.forEach(function(track) {
                   trackAdded(div, track)
               });

               participant.on('trackAdded', function(track) {
                   trackAdded(div, track)
               });
               participant.on('trackRemoved', trackRemoved);

               document.getElementById('media-div').appendChild(div);
            }

            function participantDisconnected(participant) {
               console.log('Participant "%s" disconnected', participant.identity);

               participant.tracks.forEach(trackRemoved);
               document.getElementById(participant.sid).remove();
            }

            function trackAdded(div, track) {
               div.appendChild(track.attach());
               var video = div.getElementsByTagName("video")[0];
               if (video) {
                   video.setAttribute("style", "max-width:300px;");
               }
            }

            function trackRemoved(track) {
               track.detach().forEach( function(element) { element.remove() });
            }
        </script>
    </head>
    <body>
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
                   All Participants
               </div>
        
               <div id="media-div">
               </div>
            </div>
        </div> -->

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
                <div class="container">
                      <h1>Room Participants</h1>
                      <p class="lead text-muted">
                        Hello, <b>{{ Auth::user()->name }} </b>. Welcome to the room - <h5>{{ $roomName }}</h5>
                      </p>
                      <p>
                        You can copy the invitation link from below and send it to your friends to connect with you in this room.
                      </p>
                      <p>

                          <div class="input-group mb-3">
                            <input type="text" class="form-control" value="{{ 'https://video-conference.test/room/join/'.$roomName }}" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" id="button-addon2">Copy</button>
                            </div>
                          </div>
                      </p>

                  </div>                
            </section>

            <div class="album py-5 bg-light">
                <div class="container">
                    <div class="row">
                        <!-- <div class="col-md-4">
                          <div class="card mb-4 box-shadow"> -->

                            <div id="media-div"></div>

                            <!-- <img class="card-img-top" src="https://phillipbrande.files.wordpress.com/2013/10/random-pic-14.jpg" alt="Card image cap"> --> <!-- 348(w), 218(h) div.setAttribute("style", "float: left; margin: 10px;"); -->
                            <!-- <div class="card-body">
                              <p class="card-text text-center">Snigdho Majumder</p>
                              <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                  <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                                
                              </div>
                            </div> -->
                          <!-- </div>
                                                  </div> -->
                    </div>
                </div>
            </div>

        </main>

        <footer class="text-muted" style="background: #F1F1F1;">
            <div class="container">
            <p class="float-right">
              <a href="#">Back to top</a>
            </p>
            <p>&copy; Copyrights 2020. Developed by <a href="https://www.facebook.com/snigdho.majumder">Snigdho</a></p>
            </div>
        </footer>

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
