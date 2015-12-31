<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Labels extends CI_Controller {

	public function index(){
            
            //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceed.
                        </div>";
            
				//set a referer
				if(isset($_SERVER['HTTP_REFERER'])){
					
					$data['referer'] = $_SERVER['HTTP_REFERER'];
				}  else {
					$data['referer'] = base_url()."index.php/tracker";
				}
				   
				   $this->load->view('login_view', $data); 
				 
			}else{
			
				$this->load->view('labels/create_labels'); 
			}
        
	}
	public function create_label(){
		
		if(!$this->session->userdata('logged_in')){ ?>
		
			<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
				You must be logged in to proceed.
			</div>
			<?php return;
		}
		$this->load->library('zend');
	  
		$this->zend->load('Zend/Barcode');
		 
		 if(!$this ->input->get('bc_value')){//bc_value's empty ?>
		
			 <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
				 Missing value for the barcode.
			 </div>
		 <?php return;
		
		 }else{//we have efrything
                    
                    $symbology = $this->input->get('symbology');

                    $bc_val = $this->input->get('bc_value');

                    $bc_height = $this->input->get('bc_height');
                    
                    $bc_width = $this->input->get('bc_width');
                    
                    $options_arr = array('text' => $bc_val, 'barHeight' => $bc_height,'barWidth' =>$bc_width);
                  
                    echo Zend_Barcode::render($symbology, 'image', $options_arr, array()); return; 
                   
		}	
	}
        
   public function owners_name(){
       $this->load->model('persons_model');
                
       $this->load->model('items_model');
       
       $bc_val = $this->input->post('bc_value');
       
       $this->db->select('owner_id');
       $this->db->limit(1);

       $q = $this->db->get_where('items', array('unique_id'=>$bc_val));
       
       if($q->num_rows() > 0){    
            
           foreach($q->result() as $result){
                
                $this->db->select('first_name');
                $this->db->select('second_name');
                $this->db->limit(1);

                $p = $this->db->get_where('persons', array('id'=>$result->owner_id));
                
                if($p->num_rows() > 0){ 
                    foreach($p->result() as $r){
                        $owner = $r->first_name." ".$r->second_name;
                    }
                }else{
                    $owner = "";
                }
           }
           
       }else{//this item does not exist
           
           $owner = "";
       }
       echo $owner;return;
   }     
        
}