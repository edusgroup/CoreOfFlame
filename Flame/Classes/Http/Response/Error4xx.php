<?php

namespace Flame\Classes\Http\Response;

class Error4xx extends \Flame\Abstracts\Http\Response
{
	protected $code;

	public function __construct($code)
	{
		$this->code = (int) $code;
	}
	
	public function get()
	{
		return $this->code;
	}
}
