<?php

use Illuminate\Database\Seeder;
use App\Channel;

class ChannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Channel::truncate();

        $channels = [
            'Channel 1',
            'Channel 2',
            'Channel 3',
        ];

        foreach ($channels as $name) {
            Channel::forceCreate(['name' => $name]);
        }
    }
}
