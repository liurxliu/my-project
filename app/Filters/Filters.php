<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
	protected $filters = [];
	protected $request, $builder;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function apply($builder)
	{
		$this->builder = $builder;

		foreach ($this->getFilters() as $filter => $value) {
			if (method_exists($this, $filter)) {
				return $this->$filter();
		    }
		}
        return $this->builder->latest();
	}

	protected function getFilters()
	{
		return $this->request->only($this->filters);
	}
} 