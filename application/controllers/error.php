<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		if(!$this->user){
			setcookie("lasturl", uri_string());
			redirect('login');
		}

	}

	function index()
	{
		$this->content_view = 'error/404';
	}

	function error_404(){
 		$this->content_view = 'error/404';
	}


}
