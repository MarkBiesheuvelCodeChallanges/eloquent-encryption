<?php

use Illuminate\Database\Seeder;

use App\Models\Message;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->truncate();

        $message = new Message();

        $message->from = str_random(10);
        $message->to = str_random(10);
        $message->content = str_random(100);

        $message->save();
    }
}
