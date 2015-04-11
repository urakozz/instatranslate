<html>
	<head>
		<title>InstaTranslate</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <link href="/css/app.css" rel="stylesheet">
		<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
		<script async src="/js/app.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	</head>


    <body>
		<div class="container">
			<div class="content">
				<div class="title">Your wall here, {{ $user->getFullName() }}</div>
				<img src="{{ $user->getProfilePicture() }}">
			</div>

		</div>
	</body>
</html>
