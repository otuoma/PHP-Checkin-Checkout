<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
            
            //set referer
            if(isset($_SERVER['HTTP_REFERER'])){
                
                $data['referer'] = $_SERVER['HTTP_REFERER'];
            }  else {
                $data['referer'] = base_url()."index.php/tracker";
            }
            
		$this->load->view('login_view',$data);
	}
        public function patron_login(){
            
            if(!$this->input->post('emailf') || !$this->input->post('passwordf')){

                ?>
                    <p style="padding: 5px; margin: 5px; background: #ffcccc; border: solid 1px tomato;">
                        Both email and password are required</p>
                <?php
              }else{
                    $email     = trim($this->input->post('emailf'));

                    $password  = sha1(trim($this->input->post('passwordf')));
                    
                    $this->db->limit(1);
					
					$where = "email = '{$email}' AND password = '{$password}' AND (person_type = 'staff' OR person_type = 'admin')";
                    
                    $this->db->where($where);
					
                    $q = $this->db->get('persons');
                    
                    if($q->num_rows() > 0){//match found, login
					
			$this->load->model('persons_model');
					
                        //set sessions
                        foreach ($q->result() as $person_info){
                            
							$user_type = $this->persons_model->get_user_type($person_info->id);
                                    
                            $logindata = array(
                                'emailf'      => $person_info->email,
                                'first_name'  => $person_info->first_name,
                                'second_name' => $person_info->second_name,
                                'staff_id'    => $person_info->id,
								'user_type'   => $user_type,
                                'logged_in'   => TRUE
                            );
                        
                        }

                        $this->session->set_userdata($logindata);
                        
                        ?>
                            <p style="padding: 5px; margin: 5px; background: #ccffcc; border: solid 1px yellowgreen;">
                                Login success, redirect in a sec.
                            </p>
                        <?php                        
                        
                    }  else {//no match found, back to login page
                        ?>
                            <p style="padding: 5px; margin: 5px; background: #ffcccc; border: solid 1px tomato;">
                                Login Error, please try again
                            </p>
                        <?php
                    }
              
              }
              
              
                  
	}
        public function patron_logout(){
            
            $array_items = array(
                'first_name' => '', 
                'emailf'     => '',
                'second_name'=> '',
                'staff_id'   => '',
                'logged_in'  => FALSE
            );
            
            $data['logged_out'] = "<p style='padding: 5px; margin: 5px; background: #ccffcc; border: solid 1px yellowgreen;'>
                                You are now logged out.
                            </p>";

            $this->session->unset_userdata($array_items);
            
            //set a referer
            if(isset($_SERVER['HTTP_REFERER'])){
                
                $data['referer'] = $_SERVER['HTTP_REFERER'];
            }  else {
                $data['referer'] = base_url()."index.php/tracker";
            }
            
            $this->load->view('login_view',$data);
	}
        
        
}