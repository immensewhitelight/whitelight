<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <!--  <link rel="stylesheet" href="css/app.css"> -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jobs app</title>
    
    
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        
            
            <!--    <div class="card-header">Chat</div> -->
        
                <div class="card-body">

                     <div class="container">
                     
						  <div class="row">
							
							<div class="col">
								<div id="app">
										   
										<router-link :to="{ name: 'home' }">Home</router-link>
<router-link :to="{ name: 'about' }">About</router-link>

										<router-view></router-view>
								  <br>
										<vue-chat :channels="{{ $channels }}"></vue-chat>
									
								</div>
							</div>
						  </div>
								<br>
					</div>   
              </div>
       
    </div>
</div>   
         <script src="/js/app.js"></script>
    </body>

</html>
