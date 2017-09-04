<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class resetlocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resetlocations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        DB::statement("UPDATE users SET location = POINT(21.935862,43.306151) WHERE id=1");
        DB::statement("UPDATE users SET location = POINT(21.971101,43.28383) WHERE id=2");
        DB::statement("UPDATE users SET location = POINT(21.889848,43.370818) WHERE id=3");
        DB::statement("UPDATE users SET location = POINT(21.940007,43.306312) WHERE id=4");
        DB::statement("UPDATE users SET location = POINT(21.815928,43.261) WHERE id=5");
    }
}
