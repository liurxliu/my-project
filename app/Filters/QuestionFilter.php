<?php

namespace App\Filters;

class QuestionFilter extends Filters
{
	protected $filters = ['popularity', 'all', 'recommand'];
	
	public function popularity()
	{
		return $this->builder->orderBy('answers_count', 'desc');
	}

	public function all()
	{
		return $this->builder;
	}

	public function recommand()
	{
		$ids = [];
		$topics = auth()->user()->topics()->get(['id']);
		foreach ($topics as $topic) {
			$ids[] = $topic->id;
		}
		$this->builder->whereHas('topics', function($query) use ($ids) {
			$query->whereIn('id', $ids);
		});
		return $this->builder;
	}

	

}