<?php

function make($class, $attribute = [], $number = null)
{
	return factory($class, $number)->make($attribute);
}

function create($class, $attribute = [], $number = null)
{
	return factory($class, $number)->create($attribute);
}