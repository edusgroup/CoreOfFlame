<?php

namespace Flame\Classes\Http\Response;

class Json extends \Flame\Abstracts\Http\Response
{
	protected $data;
	protected $status;
	protected $errorMsg;

    const STATUS_ERROR = false;
    const STATUS_SUCCESS = true;

	public function __construct($data, $status = self::STATUS_SUCCESS, $errorMsg = '')
	{
		$this->data = $data;
		$this->status = $status;
		$this->errorMsg = $errorMsg;
	}
	
	public function get()
	{
		$data = $this->data;
		if (!is_array($data)) {
			$data = ['data' => $data];
		}
		
		$data['$ret'] = $this->status ? 1 : 0;
		$data['$msg'] = $this->errorMsg;
		return json_encode($data);
	}
}
