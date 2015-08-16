<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hapia_auth
{

	public $CI;

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		$this->CI =& get_instance();

		$this->CI->load->config('hapia_auth');
	}


}