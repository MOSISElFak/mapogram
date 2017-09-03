<?php

use Illuminate\Database\Seeder;

class PhotosSeeder extends Seeder
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
        $radius = 7; // in miles

        $lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
        $lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
        $lat_min = $latitude - ($radius / 69);
        $lat_max = $latitude + ($radius / 69);

//        echo 'lng (min/max): ' . $lng_min . '/' . $lng_max . PHP_EOL;
//        echo 'lat (min/max): ' . $lat_min . '/' . $lat_max;

        for ($i =0 ; $i<60;$i++) {
            $lng = $this->float_rand($lng_min, $lng_max);
            $lat = $this->float_rand($lat_min, $lat_max);
            $date = date("Y-m-d H:i:s");

            $string = "INSERT INTO `photos` (user_id, filename, location, description, categories, created_at, updated_at) values (?, ?, POINT($lng,$lat), ?, ?, ?, ?)";
            //(1, 'test.jpg', POINT($lng,$lat)), 'demo photo', '#nature', $date, $date)
            DB::insert($string, [rand(1, 5), "test".rand(1, 5).".jpg" , "demo photo lorem ipsum", $this->getCat(), $date, $date]);
            DB::table('comments')->insert([
                'photo_id' => $i+1,
                'user_id' => rand(1, 5),
                'text' => 'Lorem ipsum this is a comment.'
            ]);
        }

    }

    public function float_rand($Min, $Max, $round=0){
        //validate input
        $randomfloat = $Min + mt_rand() / mt_getrandmax() * ($Max - $Min);
        if($round > 0)
            $randomfloat = round($randomfloat,$round);

        return (float) substr($randomfloat, 0, 9);
    }

    private function getCat() {
        $cats = [
            ['name' => '#nature'],
            ['name' => '#sport'],
            ['name' => '#fitness'],
            ['name' => '#history'],
            ['name' => '#people'],
            ['name' => '#love'],
            ['name' => '#macro'],
            ['name' => '#blackandwhite'],
            ['name' => '#cars'],
            ['name' => '#monuments'],
            ['name' => '#history'],
            ['name' => '#art'],
            ['name' => '#music'],
            ['name' => '#party'],
            ['name' => '#birthday'],
            ['name' => '#restaurant']
        ];

        return $cats[rand(0, (count($cats) - 1))]['name'];
    }
}
