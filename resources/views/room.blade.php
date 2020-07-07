<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Video Chat Application</title>

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
        <script src="https://code.iconify.design/1/1.0.7/iconify.min.js"></script>
        
        <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
        <script>
            Twilio.Video.createLocalTracks({
               audio: true,
               video: { width: 348 }
            }).then(function(localTracks) {
               return Twilio.Video.connect('{{ $accessToken }}', {
                   name: '{{ $roomName }}',
                   tracks: localTracks,
                   video: { width: 348 }
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
               
               
                $('#muteable').click(function() {
                    if ($(this).attr('data-status') == "true") {
                        room.localParticipant.audioTracks.forEach(audioTrack => {
                               audioTrack.disable();
                            });
                      $(this).attr("data-status", "false");
                      $("#muteable").html("<i class='fa fa-microphone-slash' aria-hidden='true'></i> Unmute Audio");
                    } 
                    else {
                        room.localParticipant.audioTracks.forEach(audioTrack => {
                               audioTrack.enable();
                            });
                      $(this).attr("data-status", "true");
                      $("#muteable").html("<i class='fa fa-microphone' aria-hidden='true'></i> Mute Audio");
                    }
                });
                
                
                videoDisable(room);

               room.on('participantDisconnected', function(participant) {
                   console.log("Disconnected: '" +  participant.identity  + "'");
                   participantDisconnected(participant);
               });
            });
            // additional functions will be added after this point //edited
            
            function videoDisable(room) {
                $('#mutevideo').click(function() {
                    if ($(this).attr('data-video') == "true") {
                        room.localParticipant.videoTracks.forEach(videoTrack => {
                               videoTrack.disable();
                               
                               //trackRemoved(videoTrack);
                            });
                      $(this).attr("data-video", "false");
                      $("#mutevideo").html("<span class='iconify' data-icon='fa-solid:video-slash' data-inline='false'></span> Enable Video");
                    } 
                    else {
                        room.localParticipant.videoTracks.forEach(videoTrack => {
                                videoTrack.enable();
                                
                            });
                      $(this).attr("data-video", "true");
                      $("#mutevideo").html("<i class='fa fa-video-camera' aria-hidden='true'></i> Disable Video");
                    }
                });
            }
            
            
            function participantConnected(participant) {
               console.log('Participant "%s" connected', participant.identity);

               const div = document.createElement('div');
               div.id = participant.sid;
               div.setAttribute("style", "float: left; margin: 10px;");
               div.innerHTML = "<div style='clear:both; text-align:center;'>" + participant.identity + "</div>";

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
                   video.setAttribute("style", "max-width:340px; max-height:220px!important");
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

        @include('includes.header')
        

        <main role="main">

            <div class="album py-5 bg-light" style="background-color: #fff!important">
                <div class="container">
                    <p class="lead text-muted text-center">Welcome to the room - <b>{{ $roomName }}</b></p>
                    <div class="row">
                        <div id="media-div"></div>
                        
                    </div>
                    <div class="row">
                    <!--<button id="muteable" data-status="true" class="btn btn-xs btn-success" style="position: relative;top: -35px;margin-left: 5px;"><i class="fa fa-microphone" aria-hidden="true"></i></button>-->
                    
                    <button id="muteable" data-status="true" class="btn btn-xs btn-success" style="position: relative;top: 49px;width: 570px;"><i class="fa fa-microphone" aria-hidden="true"></i> Mute Audio</button>
                    
                    <button id="mutevideo" data-video="true" class="btn btn-xs btn-info" style="position: relative;top: 49px;width: 570px;"><i class="fa fa-video-camera" aria-hidden="true"></i> Disable Video</button>
                    </div>
                    
                </div>
            </div>
            
            <section class="jumbotron text-center" style="background-color: #f8f9fa!important">
                <div class="container">
                      <p class="lead text-muted">
                        Hello, <b>{{ Auth::user()->name }} </b>. You can copy the invitation link from below and send it to your friends to connect with you in this room.
                      </p>
                      
                      <p>
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" value="{{ 'https://video-conference.roaringbangladesh.com/room/join/'.$roomName }}" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" id="button-addon2">Copy</button>
                            </div>
                          </div>
                      </p>

                 </div>                
            </section>

        </main>

        @include('includes.footer')

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
