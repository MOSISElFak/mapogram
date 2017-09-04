<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class moveusers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moveusers';

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
        $locations = [
            ["lng" => 21.935862, "lat" => 43.306151],
            ["lng" => 21.971101, "lat" => 43.28383],
            ["lng" => 21.889848, "lat" => 43.370818],
            ["lng" => 21.940007, "lat" => 43.306312],
            ["lng" => 21.815928, "lat" => 43.261],
        ];

        while(1) {
            for ($i=0; $i<5;$i++) {
                if ($i%2 ==0) {
                    $locations[$i]["lng"] = $locations[$i]["lng"] + 0.001;
                    $locations[$i]["lat"] = $locations[$i]["lat"] + 0.001;
                } else {
                    $locations[$i]["lng"] = $locations[$i]["lng"] - 0.001;
                    $locations[$i]["lat"] = $locations[$i]["lat"] - 0.001;
                }

                DB::statement("UPDATE users SET location = POINT(".$locations[$i]["lng"].",".$locations[$i]["lat"].") WHERE id=".($i+1));
            }
            $this->info("Updated locations!");
            sleep(1);
        }
    }
}
