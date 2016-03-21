
<!DOCTYPE html>
<html>
<head>
	<title>Email sa sajta odlican5.itservices.rs</title>
</head>
<body>
<div>
	<a href="http://www.odlican5.itservices.rs"><img  src="{{ $message->embed(public_path() . '/img/logo_za_mail.png') }}" ></a>
</div>

<h3>Nova ocena iz predmeta:</h3>
<p>Predmet: {!!$predmet!!}</p>
<p>Ocena: {!!$ocena!!}</p>
<p>Napomena: {!!$napomena!!}</p>
<p>Datum: {!!$datum!!}</p>


<p>Da bi ste videli ocenu kliknite - <a href="http://odlican5.itservices.rs/administracija/login">ovde</a>.</p>
<div style="">
        <div class="container">
        	<div>Poruka sa sajta www.odlican5.itservices.rs</div>
        </div>
 </div>

</body>
</html>
