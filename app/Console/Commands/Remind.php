<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\SendRemindEmailJob;
use App\Book;
use Carbon\Carbon;

class Remind extends Command
{

    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search duty and add to queue task to send remind email';

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
        $books = Book::where('left_date', '<=', Carbon::now())->get();

        if(!$books->isEmpty()) {

            foreach($books as $book) {

                $user = Book::find($book->id)->user;

                $this->dispatch(new SendRemindEmailJob($book, $user));
            }

            \Log::info('REMINDERS JOBS ADDED TO QUEUE!');
        }
    }
}
