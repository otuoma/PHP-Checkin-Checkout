<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Persons_model extends CI_Model {

	public function index(){
            
		//$this->load->view('items/');
	}

	public function get_avatar($person_id){
        
		$this->db->limit(1);
		$this->db->offset(0);
		$this->db->where('id', $person_id);
		$this->db->select('avatar');
		$q = $this->db->get('persons');
		
		if($q->result() > 0){
		
			foreach($q->result() as $person){
			
				$avatar = $person->avatar;
			}
			
			return $avatar;
		}else{
			
			return NULL;	
		}
		
	}
	public function update_avatar($person_id, $new_avatar = "default_avatar.png"){
	
		$data = array('avatar' => $new_avatar );

		$this->db->where('id', $person_id);
		$q = $this->db->update('persons', $data); 
		
		if($this->db->affected_rows() > 0){
			
			return TRUE;
		}else{
		
			return FALSE;
		}
		
	}
        public function get_persons_item($owner_id){//returns an array of * in persons tbl
            
            $q = $this->db->get_where('items', array('owner_id'=>$owner_id));
            
            foreach($q->result() as $result){
                $item_info = $result;
            }
            return $item_info;
        } 
        public function get_item_with_unique_id($unique_id){//returns an array of * in items tbl
            
            $q = $this->db->get_where('items', array('unique_id'=>$unique_id));
            
            foreach($q->result() as $result){
                $item_info = $result;
            }
            return $item_info;
        }
		public function get_user_type($person_id){//returns srting
            
			$this->db->limit(1);
			$this->db->offset(0);
			$this->db->select('person_type');
            $q = $this->db->get_where('persons', array('id'=>$person_id));            
            			
			foreach($q->result() as $person){
				$user_type = $person->person_type;
			}
			
			return $user_type;
		}	
        public function validate_new_person(){
		
            $user_type = $this->input->post('usertype');
			
			$this->form_validation->set_rules('usertype', 'User type', 'trim|required');
			$this->form_validation->set_rules('first_name', 'First name', 'trim|required');
            $this->form_validation->set_rules('second_name', 'second name', 'trim|required');
            $this->form_validation->set_rules('unique_id', 'card number', 'trim|required|is_unique[persons.unique_id]');
            if($user_type == "admin" || $user_type == "staff" ){  
               $this->form_validation->set_rules('password', 'Password', 'trim|required');
               $this->form_validation->set_rules('password_r', 'Password repeat', 'trim|required|matches[password]');
            }
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[persons.email]');
            $this->form_validation->set_rules('cellphone', 'Cellphone', 'trim|is_unique[persons.cellphone]');
            $this->form_validation->set_rules('address', 'Address', 'trim');
            
			if($user_type == "patron" || $user_type == "guest" ){
                
                $password = " "; 
                
            }else{
               
                $password = sha1($this->input->post('password_r'));                
            }
            if (!$this->form_validation->run()){    //validation failed
		
                return FALSE;
                
            }else{ //validation success
                $data = array(
                    "first_name" =>  $this->global_functions->mysql_sanitize($this->input->post('first_name')),
                    "second_name"=>  $this->global_functions->mysql_sanitize($this->input->post('second_name')),
                    "unique_id"  =>  $this->global_functions->mysql_sanitize($this->input->post('unique_id')),
                    "person_type"=>  $this->global_functions->mysql_sanitize($this->input->post('usertype')),
                    "email"      =>  $this->global_functions->mysql_sanitize($this->input->post('email')),
                    "password"   =>  $password,
                    'time'       => date("Y-m-d", time()),
                    "staff_id"   =>  $this->session->userdata('staff_id'),
                    "cellphone"  =>  $this->global_functions->mysql_sanitize($this->input->post('cellphone')),
                    "address"    =>  $this->global_functions->mysql_sanitize($this->input->post('address'))                    
                );
		return $data;
            }
	}
        
        public function validate_edited_person(){
            
			$user_type = $this->input->post('usertype');
			
            $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
            $this->form_validation->set_rules('second_name', 'second name', 'trim|required');
            $this->form_validation->set_rules('unique_id', 'Card number', 'trim|required');
            if($user_type == "admin" || $user_type == "staff"){
               $this->form_validation->set_rules('password', 'Password', 'trim|required');
               $this->form_validation->set_rules('password_r', 'Password repeat', 'trim|required|matches[password]');
            }
            $this->form_validation->set_rules('usertype', 'User type', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('cellphone', 'Cellphone', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');

            if($user_type == "patron" || $user_type == "guest"){

                $password = " "; 

            }else{

                $password = sha1($this->input->post('password_r') );                
            }
            if (!$this->form_validation->run()){    //validation passed

                return FALSE;

            }else{ //validation success
                $data = array(
                    "first_name" =>  $this->input->post('first_name'),
                    "second_name"=>  $this->input->post('second_name'),
                    "unique_id"  =>  $this->input->post('unique_id'),
                    //"time"       =>  date("Y-m-d", time()),
                    "person_type"=>  $this->input->post('usertype'),
                    "email"      =>  $this->input->post('email'),
                    "staff_id"   =>  $this->session->userdata('staff_id'),
                    "password"   =>  $password,
                    "cellphone"  =>  $this->input->post('cellphone'),
                    "address"    =>  $this->input->post('address'),

                );
                return $data;
            }
        }
      
}
