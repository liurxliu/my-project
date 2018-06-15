<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
	protected $fields = ['PHP', 'Golang', 'Javascript', 'Comic', 'TV show', 'Life', 'Web', 'Technology', 'Math', 'Taiwan', 'One Piece', 'Sport'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->fields as $field) {
        	\DB::table('topics')->insert([
        		'topic' => $field,
        		'created_at' => Carbon::now(),
        		'updated_at' => Carbon::now()
        	]);
        }

        
    }
}
