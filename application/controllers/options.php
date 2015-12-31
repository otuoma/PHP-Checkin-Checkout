<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Options extends CI_Controller {

	public function index(){//load options form
	
		$this->load->model("options_model");
		
		$data['company_name'] = $this->options_model->get_option('company_name');
		$data['location'] = $this->options_model->get_option('location');
		$data['address'] = $this->options_model->get_option('address');
		$data['email'] = $this->options_model->get_option('email');
		$data['cellphone'] = $this->options_model->get_option('cellphone');
        
		
		$this->load->view('options/main.php', $data);
	}
	public function update_options(){
	
		//validate the form
		$this->load->model("options_model");
         
		$company_name = $this->input->post('company_name');
		$location     = $this->input->post('location');
		$address	  = $this->input->post('address');
		$email		  = $this->input->post('email');
		$cellphone	  = $this->input->post('cellphone');
		 
        $this->form_validation->set_rules('company_name', 'Company name', 'trim|required');
		$this->form_validation->set_rules('location', 'Location', 'trim');
		$this->form_validation->set_rules('address', 'Address', 'trim');
		$this->form_validation->set_rules('email', 'Email', 'trim');
		$this->form_validation->set_rules('cellphone', 'Cellphone', 'trim');
		
		if(!$this->form_validation->run()){//validation failed
                   
			   echo "<div id='form-error'>".validation_errors()." <div align='right' style='margin:5px'><a href='#' id='fold-back'> ..hide.. </a></div></div>";
			   
		}else{//validation success, save to db
		
			$this->options_model->update_option('company_name', $this->input->post('company_name'));
			$this->options_model->update_option('location', $this->input->post('location'));
			$this->options_model->update_option('address', $this->input->post('address'));
			$this->options_model->update_option('email', $this->input->post('email'));
			$this->options_model->update_option('cellphone', $this->input->post('cellphone'));
			
			?><div id='form-success'>
                  Success, new options  updated . . . <a href='#' id='fold-back'> ..hide.. </a>
              </div><?php
		}
		
	}
}
