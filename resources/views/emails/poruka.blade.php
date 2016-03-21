<!DOCTYPE html>
<html>
<head>
	<title>Email sa sajta odlican5.itservices.rs</title>
</head>
<body>
<div>
	<a href="http://www.odlican5.itservices.rs"><img  src="{{ $message->embed(public_path() . '/img/logo_za_mail.png') }}" ></a>
</div>

<h3>Nova poruka:</h3>
<p>Предмет: {!!$predmet!!}</p>
<p>Наставник: {!!$nastavnik!!}</p>
<p>Порука: {!!$poruka!!}</p>


<p>Da bi ste videli ocenu kliknite - <a href="http://odlican5.itservices.rs/administracija/login">ovde</a>.</p>
<div style="">
        <div class="container">
        	<div>Poruka sa sajta www.odlican5.itservices.rs</div>
        </div>
 </div>

</body>
</html>