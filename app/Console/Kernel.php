<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Mail;
use Ocene;
use Roditelji;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\HappyBirthday'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        /*$ocene=Ocene::join('roditelji','roditelji.id','=','ocene.roditelji_id')
            ->where('ocene.poslato',0)
            ->get(['roditelji.email','ocene.ocene','ocene.id','ocene.zapazanje','ocene.created_at'])->toArray();
           foreach ($ocene as $ocena) {
            if($ocena['email']!=NULL){//провера да ли родитељ има маил ако да шаље га
                $data=[
                'predmet'=>'biologija',
                'napomena'=>$ocena['zapazanje'],
                'ocena'=>$ocena['ocene'],
                'datum'=>$ocena['created_at']
                ];
                $rod_email=$ocena['email'];
                Mail::send(['html'=>'emails.obavestenje'], $data, function ($m) use ($rod_email){
                    $m->to($rod_email, 'Saša Jović')->subject('Obaveštenje - Odličan5');
                });
                if( count(Mail::failures()) == 0 ) {
                    Ocene::where('ocene.id','=',$ocena['id'])->update(['poslato'=>1]);
                }
            }
        }*/

       // $schedule->call('App\Http\Controllers\SendMail@sendmail')->dailyAt('19:05');
        // $schedule->command('mail:send --force')->everyMinute();
        // $schedule->command('mail:send --force')->cron();queue
       /* $schedule->command('inspire')
                 ->hourly();*/
    }
}
