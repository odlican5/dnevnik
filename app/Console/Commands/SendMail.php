<?php

namespace App\Console\Commands;
use Mail;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Ocene;
use Roditelji;
class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Slanje maila testni';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        

       $ocene=Ocene::join('roditelji','roditelji.id','=','ocene.roditelji_id')
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
        }
    }
}
