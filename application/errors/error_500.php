<html>
<head>
<title>Error</title>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<style type="text/css">

body {
background-color:	#1085C9;
margin:				40px;
font-family:		'Open Sans', sans-serif;
font-size:			12px;
color:				#fff;
}

#content  {
border:				#999 1px solid;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		300;
font-size:			48px;
color:				rgb(11, 104, 158);
margin:				0 0 4px 0;
transition: 		color 1.2s linear;
line-height: 		48px;
letter-spacing: 	-1px;
margin-bottom: 		5px;
}
h2{
	transition: color .2s linear;
    font-size: 26px;
    line-height: 46px;
    font-weight:		400;
    margin-top: 5px;
}
hr{
	background-color: rgba(11, 104, 158, 0.18);
	border-color:  rgba(11, 104, 158, 0.18);
	margin-bottom: 25px;
}
.error-page{
	width: 600px;
	margin: 150px 0 0 300px;
}
.error-container{
 	height:  100px;
 	text-overflow: ellipsis;
 	overflow: hidden;
 	display: none;
}
p{
	font-weight: 300;
    font-size: 14px;
    letter-spacing: 0.6px;
}
</style>
</head>
<body>
	<div class="error-page">
		<h1><?php echo $heading; ?></h1>
		<h2>Erro interno do servidor</h2>
		<hr>
		<p>
			Tente novamente mais tarde
		</p>
		<div class="error-container">
			<pre><?php echo $message; ?></pre>
		</div>
	</div>
</body>
</html>
