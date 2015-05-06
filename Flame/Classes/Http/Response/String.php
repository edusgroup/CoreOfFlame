<?php

namespace Flame\Classes\Http\Response;

class String extends \Flame\Abstracts\Http\Response
{
	public function __construct($data)
	{
		$this->data = $data;
	}
	
	public function get()
	{
        return $this->data;
	}
}
