<?php
 
//
// NOTE Migration Created: 2015-12-28 08:29:11
// --------------------------------------------------
 
class CreateDnevnikDatabase {
//
// NOTE - Make changes to the database.
// --------------------------------------------------
 
public function up()
{

//
// NOTE -- djaci
// --------------------------------------------------
 
Schema::create('djaci', function($table) {
 $table->increments('id');
 $table->string('ime', 45);
 $table->string('prezime', 45);
 $table->unsignedInteger('id_odeljenje');
 $table->unsignedInteger('id_roditelji');
 $table->timestamp('created_at')->nullable()->default("CURRENT_TIMESTAMP");
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('id_skole')->nullable();
 });


//
// NOTE -- dogadjaji
// --------------------------------------------------
 
Schema::create('dogadjaji', function($table) {
 $table->increments('id');
 $table->string('dogadjaj', 45)->nullable();
 $table->date('datum')->nullable();
 $table->string('status', 45)->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('updated_at')->nullable();
 });


//
// NOTE -- failed_jobs
// --------------------------------------------------
 
Schema::create('failed_jobs', function($table) {
 $table->increments('id')->unsigned();
 $table->text('connection');
 $table->text('queue');
 $table->('payload');
 $table->timestamp('failed_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- izostanci
// --------------------------------------------------
 
Schema::create('izostanci', function($table) {
 $table->increments('id');
 $table->unsignedInteger('broj_casova')->nullable();
 $table->date('datum')->nullable();
 $table->timestamp('created_at')->nullable()->default("CURRENT_TIMESTAMP");
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('djaci_id');
 $table->unsignedInteger('opravdano')->nullable()->default("2");
 $table->boolean('procitano')->nullable();
 });


//
// NOTE -- jobs
// --------------------------------------------------
 
Schema::create('jobs', function($table) {
 $table->increments('id')->unsigned();
 $table->string('queue', 255);
 $table->('payload');
 $table->boolean('attempts')->unsigned();
 $table->boolean('reserved')->unsigned();
 $table->unsignedInteger('reserved_at')->nullable()->unsigned();
 $table->unsignedInteger('available_at')->unsigned();
 $table->unsignedInteger('created_at')->unsigned();
 });


//
// NOTE -- korisnici
// --------------------------------------------------
 
Schema::create('korisnici', function($table) {
 $table->increments('id');
 $table->unsignedInteger('prava_pristupa_id');
 $table->string('username', 45)->nullable();
 $table->string('password', 150);
 $table->string('mesto', 45)->nullable();
 $table->string('adresa', 45)->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->string('grad', 45)->nullable();
 $table->string('token', 250)->nullable();
 $table->string('korisnicicol', 45)->nullable();
 $table->boolean('aktivan')->nullable();
 $table->string('ime', 45)->nullable();
 $table->string('prezime', 45)->nullable();
 $table->string('email', 45)->nullable();
 $table->string('telefon', 45)->nullable();
 $table->string('opis', 45)->nullable();
 $table->string('naziv', 45)->nullable();
 });


//
// NOTE -- log
// --------------------------------------------------
 
Schema::create('log', function($table) {
 $table->increments('id');
 $table->string('nap', 45)->nullable();
 $table->timestamp('created_at')->nullable();
 $table->unsignedInteger('korisnici_id');
 });


//
// NOTE -- nastavnici
// --------------------------------------------------
 
Schema::create('nastavnici', function($table) {
 $table->increments('id');
 $table->string('ime', 45)->nullable();
 $table->string('prezime', 45)->nullable();
 $table->string('username', 45)->unique();
 $table->string('password', 150);
 $table->timestamp('created_at')->nullable()->default("CURRENT_TIMESTAMP");
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('skole_id');
 $table->string('token', 250)->nullable();
 $table->unsignedInteger('prava_pristupa_id')->nullable();
 $table->boolean('aktivan')->nullable();
 $table->unsignedInteger('predmeti_id')->nullable();
 });


//
// NOTE -- ocene
// --------------------------------------------------
 
Schema::create('ocene', function($table) {
 $table->increments('id');
 $table->unsignedInteger('id_djaci');
 $table->unsignedInteger('id_predmeti_po_godinama')->nullable();
 $table->string('ocene', 45)->nullable();
 $table->unsignedInteger('id_odeljenja')->nullable();
 $table->unsignedInteger('roditelji_id')->nullable();
 $table->timestamp('created_at')->nullable()->default("CURRENT_TIMESTAMP");
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('id_predmeti')->nullable();
 $table->string('zapazanje', 225)->nullable();
 $table->unsignedInteger('procitano')->nullable();
 });


//
// NOTE -- odeljenja
// --------------------------------------------------
 
Schema::create('odeljenja', function($table) {
 $table->increments('id');
 $table->string('razred', 4)->nullable();
 $table->string('odeljenje', 4)->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('nastavnici_id');
 });


//
// NOTE -- odeljenje_djak
// --------------------------------------------------
 
Schema::create('odeljenje_djak', function($table) {
 $table->increments('id');
 $table->unsignedInteger('id_djak');
 $table->unsignedInteger('id_odeljenje');
 $table->timestamp('created_at')->nullable()->default("CURRENT_TIMESTAMP");
 $table->timestamp('updated_at')->nullable();
 });


//
// NOTE -- password_resets
// --------------------------------------------------
 
Schema::create('password_resets', function($table) {
 $table->string('email', 255);
 $table->string('token', 255);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- poruke
// --------------------------------------------------
 
Schema::create('poruke', function($table) {
 $table->increments('id');
 $table->string('poruka', 1024)->nullable();
 $table->timestamp('created_at')->nullable()->default("CURRENT_TIMESTAMP");
 $table->timestamp('updated_at')->nullable();
 $table->boolean('procitano')->nullable();
 $table->unsignedInteger('posiljalac_id')->nullable();
 $table->unsignedInteger('primalac_id')->nullable();
 });


//
// NOTE -- prava_pristupa
// --------------------------------------------------
 
Schema::create('prava_pristupa', function($table) {
 $table->increments('id');
 $table->string('naziv', 45);
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 });


//
// NOTE -- predmeti
// --------------------------------------------------
 
Schema::create('predmeti', function($table) {
 $table->increments('id');
 $table->string('naziv', 45)->nullable();
 $table->timestamp('created_at')->nullable()->default("CURRENT_TIMESTAMP");
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('skole_id')->nullable();
 $table->unsignedInteger('korisnik_id')->nullable();
 });


//
// NOTE -- predmeti_po_godinama
// --------------------------------------------------
 
Schema::create('predmeti_po_godinama', function($table) {
 $table->increments('id');
 $table->unsignedInteger('id_godina')->nullable();
 $table->unsignedInteger('id_predmeta');
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('nastavnici_id');
 });


//
// NOTE -- raspored
// --------------------------------------------------
 
Schema::create('raspored', function($table) {
 $table->increments('id');
 $table->unsignedInteger('skole_id')->nullable();
 $table->string('predmet', 45)->nullable();
 $table->unsignedInteger('broj_casa')->nullable();
 $table->string('dan', 45)->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('updated_at')->nullable();
 $table->string('boja', 45)->nullable();
 $table->string('boja_teksta', 45)->nullable();
 });


//
// NOTE -- razredni
// --------------------------------------------------
 
Schema::create('razredni', function($table) {
 $table->increments('id');
 $table->unsignedInteger('odeljenja_id')->nullable();
 $table->unsignedInteger('nastavnici_id')->nullable();
 });


//
// NOTE -- roditelji
// --------------------------------------------------
 
Schema::create('roditelji', function($table) {
 $table->increments('id');
 $table->string('email', 45);
 $table->string('username', 45);
 $table->string('password', 150);
 $table->string('prezime', 45);
 $table->string('ime', 45);
 $table->string('mobilni', 15)->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('skole_id');
 $table->boolean('aktivan')->nullable();
 $table->unsignedInteger('prava_pristupa_id')->nullable();
 $table->string('token', 250)->nullable();
 });


//
// NOTE -- semestar
// --------------------------------------------------
 
Schema::create('semestar', function($table) {
 $table->increments('id');
 $table->string('semestar', 45)->nullable();
 $table->date('od')->nullable();
 $table->date('do')->nullable();
 $table->unsignedInteger('id_skole')->nullable();
 });


//
// NOTE -- skole
// --------------------------------------------------
 
Schema::create('skole', function($table) {
 $table->increments('id');
 $table->string('naziv', 45)->nullable();
 $table->string('slug', 45)->nullable();
 $table->boolean('aktivan')->nullable();
 $table->timestamp('created_at')->nullable();
 $table->timestamp('updated_at')->nullable();
 $table->unsignedInteger('korisnici_id');
 });


//
// NOTE -- users
// --------------------------------------------------
 
Schema::create('users', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->string('email', 255)->unique();
 $table->string('password', 60);
 $table->string('remember_token', 100)->nullable();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- zakljucne_ocene
// --------------------------------------------------
 
Schema::create('zakljucne_ocene', function($table) {
 $table->increments('id');
 $table->unsignedInteger('zakljucna')->nullable();
 $table->unsignedInteger('predmeti_id')->nullable();
 $table->unsignedInteger('semestar_id')->nullable();
 $table->unsignedInteger('djaci_id')->nullable();
 });


//
// NOTE -- djaci_foreign
// --------------------------------------------------
 
Schema::table('djaci', function($table) {
 $table->foreign('id_roditelji')->references('id')->on('roditelji');
 $table->foreign('id_skole')->references('id')->on('skole');
 });


//
// NOTE -- izostanci_foreign
// --------------------------------------------------
 
Schema::table('izostanci', function($table) {
 $table->foreign('djaci_id')->references('id')->on('djaci');
 });


//
// NOTE -- korisnici_foreign
// --------------------------------------------------
 
Schema::table('korisnici', function($table) {
 $table->foreign('prava_pristupa_id')->references('id')->on('prava_pristupa');
 });


//
// NOTE -- log_foreign
// --------------------------------------------------
 
Schema::table('log', function($table) {
 $table->foreign('korisnici_id')->references('id')->on('korisnici');
 });


//
// NOTE -- nastavnici_foreign
// --------------------------------------------------
 
Schema::table('nastavnici', function($table) {
 $table->foreign('skole_id')->references('id')->on('skole');
 $table->foreign('predmeti_id')->references('id')->on('predmeti');
 });


//
// NOTE -- ocene_foreign
// --------------------------------------------------
 
Schema::table('ocene', function($table) {
 $table->foreign('id_djaci')->references('id')->on('djaci');
 $table->foreign('id_odeljenja')->references('id')->on('odeljenje_djak');
 $table->foreign('roditelji_id')->references('id')->on('roditelji');
 $table->foreign('id_predmeti')->references('id')->on('predmeti');
 });


//
// NOTE -- odeljenja_foreign
// --------------------------------------------------
 
Schema::table('odeljenja', function($table) {
 $table->foreign('nastavnici_id')->references('id')->on('nastavnici');
 });


//
// NOTE -- odeljenje_djak_foreign
// --------------------------------------------------
 
Schema::table('odeljenje_djak', function($table) {
 $table->foreign('id_djak')->references('id')->on('djaci');
 $table->foreign('id_odeljenje')->references('id')->on('odeljenja');
 });


//
// NOTE -- predmeti_foreign
// --------------------------------------------------
 
Schema::table('predmeti', function($table) {
 $table->foreign('skole_id')->references('id')->on('skole');
 });


//
// NOTE -- predmeti_po_godinama_foreign
// --------------------------------------------------
 
Schema::table('predmeti_po_godinama', function($table) {
 $table->foreign('id_predmeta')->references('id')->on('predmeti');
 $table->foreign('nastavnici_id')->references('id')->on('nastavnici');
 });


//
// NOTE -- razredni_foreign
// --------------------------------------------------
 
Schema::table('razredni', function($table) {
 $table->foreign('nastavnici_id')->references('id')->on('nastavnici');
 $table->foreign('odeljenja_id')->references('id')->on('odeljenja');
 });


//
// NOTE -- roditelji_foreign
// --------------------------------------------------
 
Schema::table('roditelji', function($table) {
 $table->foreign('skole_id')->references('id')->on('skole');
 });


//
// NOTE -- skole_foreign
// --------------------------------------------------
 
Schema::table('skole', function($table) {
 $table->foreign('korisnici_id')->references('id')->on('korisnici');
 });


//
// NOTE -- zakljucne_ocene_foreign
// --------------------------------------------------
 
Schema::table('zakljucne_ocene', function($table) {
 $table->foreign('predmeti_id')->references('id')->on('predmeti');
 $table->foreign('djaci_id')->references('id')->on('djaci');
 $table->foreign('semestar_id')->references('id')->on('semestar');
 });



}
 
//
// NOTE - Revert the changes to the database.
// --------------------------------------------------
 
public function down()
{

Schema::drop('djaci');
Schema::drop('dogadjaji');
Schema::drop('failed_jobs');
Schema::drop('izostanci');
Schema::drop('jobs');
Schema::drop('korisnici');
Schema::drop('log');
Schema::drop('nastavnici');
Schema::drop('ocene');
Schema::drop('odeljenja');
Schema::drop('odeljenje_djak');
Schema::drop('password_resets');
Schema::drop('poruke');
Schema::drop('prava_pristupa');
Schema::drop('predmeti');
Schema::drop('predmeti_po_godinama');
Schema::drop('raspored');
Schema::drop('razredni');
Schema::drop('roditelji');
Schema::drop('semestar');
Schema::drop('skole');
Schema::drop('users');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');
Schema::drop('zakljucne_ocene');

}
}