<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Seminar;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class SendPassCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-passcode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Passcode should be send to all guest user after seminar ends for register';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            \Log::info("Start send passcode command!");

            $seminars = Seminar::whereRaw('CONCAT(start_date, " ", end_time) <= NOW()')->where('cron_status',0)->get();

            foreach($seminars as $seminar){
                
                //Update Seminar Status
                // Seminar::where('id',$seminar->id)->update(['cron_status'=>1]);

                //Retrieve all seminar bookings
                $bookings = Booking::where('bookingable_id',$seminar->id)->get();

                foreach($bookings as $booking){

                    $passcode =  explode(' ',$booking->name)[0].Str::random(12);

                    Booking::where('id',$booking->id)->update(['passcode'=> $passcode]);
                
                }
               
            }

            // dd($seminars->count());


            \Log::info("End send passcode command!");

            return true;
        }catch (Exception $e) {
            return $e;
        }
    }
}
