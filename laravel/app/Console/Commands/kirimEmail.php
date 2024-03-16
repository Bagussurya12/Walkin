<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\Emailabsen;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Absenharian;
use App\Karyawandata;
use App\Karyawanpersonal;
use App\Kategoriabsen;
use App\Absenlog;

class kirimEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kirimemail:absen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email per hari';

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
        /*
        \Mail::raw('Absen Anda Hari Ini', function($message){
            $message->to('novan.abdilah@ocbd.co.id', 'Novan Abdilah');
            $message->subject('NOTIFIKASI ABSEN HARIAN');
        });
        */
        $details = [
            'title' => 'Karyawan OBP',
            'body' => 'Hari ini anda belum absen ya, yuk absen dulu'
            ];

        $email_penerima = ['nabdilah@gmail.com', 'novanokkey@gmail.com'];

        Mail::to($email_penerima)->send(new Emailabsen($details));
 
		//return "Email telah dikirim";

        echo 'Email terkirim';
    }
}
