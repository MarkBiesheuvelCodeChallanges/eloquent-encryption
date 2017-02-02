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

        $persons = ['John', 'Jane', 'Alice', 'Bob', 'Eve'];
        $examples = ['Hi', 'Bye', 'This is a secrect', 'X', 'Cool!'];

        for ($i = 0; $i < 5; $i++) {
            $message = new Message();

            $message->from = $persons[array_rand($persons)];
            $message->to = $persons[array_rand($persons)];
            $message->content = $examples[array_rand($examples)];

            $message->save();
        }
    }
}
