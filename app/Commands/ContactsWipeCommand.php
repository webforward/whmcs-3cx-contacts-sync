<?php

namespace App\Commands;

use App\Phonebook;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ContactsWipeCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'contacts:wipe';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Wipe all contacts from 3CX';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->task('Wiping 3CX Phonebook', function() {
            Phonebook::query()->delete();
            return true;
        });

    }
}
