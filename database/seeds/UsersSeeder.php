<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $longitude = (float) 21.892018;
        $latitude = (float) 43.318496;
        $radius = 4; // in miles
        $date = date("Y-m-d H:i:s");

        $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
        $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
        $lat_min = $latitude - ($radius / 69);
        $lat_max = $latitude + ($radius / 69);

        $string = "INSERT INTO `users` (username, email, password, avatar, first_name, last_name, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?)";
        //(1, 'test.jpg', POINT($lng,$lat)), 'demo photo', '#nature', $date, $date)
        //DB::insert($string, ["dejan", "dejan@example.com", bcrypt("123123"), "avatar.jpg", "Dejan", "Stosic", $date, $date]);

        for ($i=0; $i<5;$i++) {
            $lng = $this->float_rand($lng_min, $lng_max);
            $lat = $this->float_rand($lat_min, $lat_max);

            $string = "INSERT INTO `users` (username, email, password, avatar, first_name, last_name, location, created_at, updated_at) values (?, ?, ?, ?, ?, ?, POINT($lng,$lat), ?, ?)";
            //(1, 'test.jpg', POINT($lng,$lat)), 'demo photo', '#nature', $date, $date)
            $id = DB::insert($string, ["demouser" . ($i+1) , "demouser" . ($i+1) . "@example.com", "1", "avatar.jpg", "Demo", "User", $date, $date]);
            DB::table("friends")->insert(['user1_id' => 1, 'user2_id' => $id]);
        }


    }

    public function float_rand($Min, $Max, $round=0){
        //validate input
        $randomfloat = $Min + mt_rand() / mt_getrandmax() * ($Max - $Min);
        if($round > 0)
            $randomfloat = round($randomfloat,$round);

        return (float) substr($randomfloat, 0, 9);
    }
}
