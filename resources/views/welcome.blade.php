<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="css/app.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ideas app</title>
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
		<div class="col">
			<div id="app">
				<router-link :to="{ name: 'home' }">Home</router-link>
				<router-link :to="{ name: 'about' }">About</router-link>
				<router-link :to="{ name: 'video' }">Video</router-link>
				<router-link :to="{ name: 'source' }">Source code</router-link>
				<router-link :to="{ name: 'donate' }">Donate</router-link>
				<hr>		
				<router-view></router-view>
				<hr>
				<vue-chat :channels="{{ $channels }}"></vue-chat>
			</div>
		</div>			      
    </div>
</div>   
<script src="/js/app.js"></script>
</body>
</html>
