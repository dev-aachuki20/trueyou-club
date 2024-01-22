<?php

namespace App\Console\Commands;

use App\Models\Quote;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkSkippedTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote-task-skipped';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Skipped Task Data Added ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
			\Log::info("Start expired plan command!");
    
            $today = Carbon::today();
            $todayQuote = Quote::whereDate('created_at', $today)->first();

            if ($todayQuote) {
			    $users = User::where('is_active', 1)
                ->whereDoesntHave('quotes', function ($query) use ($todayQuote) {
                    $query->where('quote_id', $todayQuote->id);
                })
                ->whereHas('roles', function($q){
                    $q->where('title', 'User');
                })
                ->get();

                foreach($users as $user){
                    $user->quotes()->attach($todayQuote, ['created_at' => now(), 'status' => 'skipped']);
                }
            }
			

			
			\Log::info("End expired plan command!");
			
			return true;
		}catch (Exception $e) {
       		 return $e;
		}
    }
}
