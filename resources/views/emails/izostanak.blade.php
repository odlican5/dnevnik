
<!DOCTYPE html>
<html>
<head>
	<title>Email sa sajta odlican5.itservices.rs</title>
</head>
<body>
<div>
	<a href="http://www.odlican5.itservices.rs"><img  src="{{ $message->embed(public_path() . '/img/logo_za_mail.png') }}" ></a>
</div>

<h3>Обавештење о изостанку са наставе:</h3>
<p>Предмет: {!!$predmet!!}</p>
<p>Број часова: {!!$broj_casova!!}</p>
<p>Датум: {!!$datum!!}</p>


<p>Да би  сте видели изотанак кликните - <a href="http://odlican5.itservices.rs/administracija/login">ovde</a>.</p>
        <div class="container">
        	<div>Poruka sa sajta www.odlican5.itservices.rs</div>
        </div>


</body>
</html>