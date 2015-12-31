<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * The defaulter controller, loads the welcome view
	 */
	public function index(){
            
		$this->load->view('welcome_message');
	}
}
