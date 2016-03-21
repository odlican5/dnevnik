@extends('master')

@section('content')

    <div style="color:#3c577a;" class="col-sm-5">
        <h1>IS Dnevnik</h1>
        <p>Informacioni sistem za vođenje ocena đaka srednjih i osnovnih škola.</p>
        <p>
            IS Dnevnik omogućava funkcionalnosti:
            <ul class="col-sm-offset-2 ulul">
                <li>Unošenje ocena i izostanaka</li>
                <li>Pregled ocena đaka.</li>
                <li>Obaveštavanje o ocenama izostancima i najvažnijim događajima</li>
                <li>...</li>
                <li>pregled statistike uspeha djaka.</li>
                <li>Pretrage po različitim kriterijumima</li>
                <li>Grafički prikaz podataka...</li>
            </ul><style>.ulul li{font-size:20px}</style>
        </p>
    </div>
    <div class="col-sm-7">
        <div class="thumbnail">
            <img src="img/skola.jpg" style="width:100%">
            <div style="padding:10px">
                <h2>Online dnevnik - za uspešno ....</h2>
            </div>
        </div>
    </div>
@endsection