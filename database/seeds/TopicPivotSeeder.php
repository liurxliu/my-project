<?php

use Illuminate\Database\Seeder;

class TopicPivotSeeder extends Seeder
{
	const QUESTION = 100;
	const TOPIC = 12;
	public $data = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 100; $i++) {
        	while (true) {
        		$topic_id = mt_rand(1, self::TOPIC);
        		$question_id = mt_rand(1, self::QUESTION);
        		if ($this->noRepeated($topic_id, $question_id)) {
	        		$this->createData($topic_id, $question_id);
	        		break;
	        	}

        	}
        }
    }

    public function createData($t_id, $q_id)
    {
    	\DB::table('topic_question')->insert([
    		'topic_id' => $t_id,
    		'question_id' => $q_id,
    	]);
    	$this->data[$t_id][] = $q_id;
    }

    public function noRepeated($a, $b) {
    	if (empty($this->data)) {
    		return true;
    	}

    	if (!array_key_exists($a, $this->data)) {
    		return true;
    	} else if (in_array($b, $this->data[$a])) {
    		return false;
    	}

    	return true;
    }
}
