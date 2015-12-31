<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Persons extends CI_Controller {

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
               
            }  else {
                
                $this->load->library('pagination');

                $config['base_url'] = base_url().'index.php/persons/index/';

                $config['total_rows'] = $this->db->get('persons')->num_rows();

                $config['per_page'] = 15;

                $config['num_links'] = 8;

                $this->pagination->initialize($config);

                $data['persons'] = $this->db->get('persons', $config['per_page'], $this->uri->segment(3));

                $data['pg_links'] = $this->pagination->create_links();

                $this->load->view('persons/all_persons', $data);
            }
        
        }
	public function upload_screen(){
	
		$this->load->model('persons_model');
	
		$person_id = $this->uri->segment(3);
		$id = $this->uri->segment(3);
		$q = $this->db->get_where('persons', array('id' => $id), 1, 0);
		foreach ($q->result_array() as $value) {

			$data['person'] = $value;
		}
		$this->load->view('persons/upload_screen', $data);
	}
	public function get_avatar_src(){
		$this->load->model('persons_model');
		echo base_url()."images/avatars/".$this->persons_model->get_avatar($this->uri->segment(3)); 
		
	}
	public function upload_avatar(){ //echo $this->input->post(); return;

		$config['upload_path'] = './images/avatars/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
		$config['max_size']	= '5000';
		$config['max_width']  = '500';
		$config['max_height']  = '500';
		
		//echo print_r($_FILES); return;

		$this->load->library('upload', $config);
		$this->load->model('persons_model');

		if(! $this->upload->do_upload('file')){
		
			//$error = array('error' => $this->upload->display_errors());
			echo "<div id='form-error'>".$this->upload->display_errors()."</div>";
			
		}else{
			$new_image = $this->upload->data();
			
			$avatar_name = $new_image['raw_name'].$new_image['file_ext'];
			
			$person_id = $this->uri->segment(3);
			
			if($this->persons_model->update_avatar($person_id, $avatar_name)){
				echo "<div id='form-success'>Success, image was updated. Click image to see changes</div>";
			}
		}
	}		
	public function process_report(){
			
			if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceed.
                        </div>
                <?php return;
            }

            if($this->input->post('dateone') && $this->input->post('datetwo')){
                
				$limit 	 = trim($this->input->post('perpage'));
				$dateone = trim($this->input->post('dateone'));
				$datetwo = trim($this->input->post('datetwo'));
				
				$this->load->model('persons_model');
				$this->load->model('items_model');
				
				$this->db->where('time >= ', $dateone);
				$this->db->where('time <= ', $datetwo);
				
				$total_persons  = $this->db->get('persons');
				
				$this->db->limit($limit);
				$perpage = $limit;
				if($this->input->post('page_number')){
					$curr_page = ($this->input->post('page_number')) - 1;
					$offset = ($curr_page * $perpage);
					$this->db->offset($offset);
				}  else {
					$offset = 0;
					$curr_page = 1;
				}
				
				if($perpage < 1){ $perpage = 15;}
				
				$num_of_pages = ceil($total_persons->num_rows() / $perpage);
				
				$this->db->where('time >= ', $dateone);
				$this->db->where('time <= ', $datetwo);
				
				$q = $this->db->get('persons');
				
				if($q->num_rows() > 0){
					?><div align="right" style="margin: 6px;" id="printBtns">
						<input type="button" id="printBtn" value=" print "> &nbsp;
					</div>
					<div style="background: #ff99cc ; border: #ff6666 solid 1px; padding: 5px;">
						Registered Patrons as at <?php echo date('d-M-Y',strtotime($dateone)).' to '.date('d-M-Y',strtotime($datetwo)); ?>
					</div>
					<table id="results">
							<thead>
							<th>N<sup>o.</sup></th><th>PATRON ID</th><th> Email </th><th>Cellphone</th><th>Date</th>
							</thead>
							<tbody>	
					<?php
					$num = $offset;
					foreach($q->result() as $person){ 
						
						//$item_detail = $this->persons_model->get_item_with_unique_id($item->unique_id);
						
						//$person_detail = $this->items_model->get_item_owner($item_detail->owner_id);
					?>
					
						<tr><td><?php $num++; echo $num ?>.</td>
							<td><?php echo $person->unique_id; ?></td>
							<td><?php if($person->email){echo $person->email;}else{ echo " .. null .. "; } ?></td>
							<td><?php if($person->cellphone){echo $person->cellphone;}else{ echo " .. null .. "; } ?></td>
							<td><?php echo date('d-M-Y', strtotime($person->time)); ?></td>
						</tr>
					
				<?php 	} //endforeach ?>
                                                <tr><td colspan="5" style="background: #ff99cc ; border: #ff6666 solid 1px; padding: 5px;">
                           <form method="post" action="#" id="pagination_form">
                            Total <?php echo $total_persons->num_rows()." patrons on ".$num_of_pages." pages "; ?> .
                             <?php 
                             if($this->input->post('page_number')){
                                $curr_page = $this->input->post('page_number');
                             }  else {
                                 $curr_page = 1;
                             }
                             echo "current page ".$curr_page;?>
                                <select name="page_number">
                                    
                                  <?php $i = 1;
                                     echo "<option value='".$curr_page."'>{$curr_page}</option>";
                                     while($i <= $num_of_pages){
                                         echo "<option value=".$i.">{$i}</option>";
                                           $i++; 
                                     } 
                                  ?>  
                                </select> &nbsp; <input type="submit" value=" fetch " />
                           </form>
                        </td>
                    </tr> </tbody></table>
					<script>
                    $('input#printBtn').click(function(){
                        window.print();
                        return false;
                    });
                    $('#pagination_form').submit(function(){
					
                        var formVals = $('#fetch_form').serialize() + "&" + $('#pagination_form').serialize();
						var URL = "<?php echo base_url(); ?>index.php/persons/process_report";
                            
                        $.ajax({
                            url: URL,
                            cache: false,
                            type: "POST",
                            data: formVals,
                            success: function(response) {
                                $('#tbl-holder').html(response);
                            }
                        });

                     return false;
                    });
                </script><?php 
				}else{
				
					?><div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            <h3> No Patrons found. </h3>
                        </div>
				<?php
				}
           }else{
				
					?><div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            <h3> Please submit a valid date range. </h3>
                        </div>
				<?php
			}
        }
        public function reports(){
            
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
             }  else {
                 $this->load->view('persons/reports');
             }
            
        }
        
        public function livesearch(){
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceed.
                        </div>
                <?php return;
            }
            
            if($this->input->post("search_val")){

                $param = trim($this->input->post("search_val"));

            }else{

                echo "<h4>Please enter the persons ID to search</h4>";

                return;
            }

            $sql = "SELECT * FROM persons WHERE unique_id LIKE '%$param%' ORDER BY first_name DESC LIMIT 15";

            $person = $this->db->query($sql);

            if ($person->num_rows() > 0){

                echo    "<table id='results'>
                    <thead>
                        <th>Edit</th><th>Email</th><th>PF/Reg. Number</th><th>Cellphone</th><th>Date</th><th>Delete</th>
                        </thead>
                        <tbody>";
                
                    foreach($person->result() as $person_info){
					
						//if($person_info->id == $this->session->userdata('staff_id')){continue;}
                    
						echo "<tr><td>";
                        echo "<a href='".base_url("index.php/persons/edit_person")."/".$person_info->id."'>".$person_info->first_name." ".$person_info->second_name."</a>"; 
                        echo "</td><td>".$person_info->email."</td>";
                        echo "<td>".$person_info->unique_id."</td>
                              <td>".$person_info->cellphone."</td>
                              <td>".$person_info->time."</td>
                              <td><a href='".  base_url('index.php/persons/delete_person')."/".$person_info->id."'>#</a></td></tr>";
                     }
                }else{
                        echo "<tr><td>No person info was found on the database</td></tr>";
                }
        echo "</tbody></table><p> &nbsp; </p>";
    }

        public function delete_person(){//displays the delete view
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
               
            }  else {
                if(!$this->uri->segment(3)){

                    echo "<h1>Illegal page accesss</h1>"; return;
                }else{
                    $id = $this->uri->segment(3);

                    $q = $this->db->get_where('persons', array('id' => $id), 1, 0);

                    //check if we have a person for this id
                    if($q->num_rows() ==1 ){    
                        foreach ($q->result_array() as $value) {
							
                             //check if person has depndents
                            $this->db->where('owner_id', $id);

                            $check_q = $this->db->get('items');

                            if($check_q->num_rows() > 0){
                                $data['has_dependencies'] = "has dependencies";
                            }

                            $data['person'] = $value;
                        }

                        $data['num_rows'] = 1;  

                    }else{

                        $data['num_rows'] = 0;
                    }

                    $this->load->view('persons/delete_person',$data);
               }      
            }
        
        }
	
        public function confirm_delete(){//deletes via ajax
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceed.
                        </div>
                <?php return;
            }
            
            if(!$this->uri->segment(3)){
                
                echo "<h1>Illegal page accesss</h1>";                return;
            }else{
                
                $id = $this->uri->segment(3);
               
                $this->db->where('id', $id);
                
                if($this->db->delete('persons')){
                    
                    echo "<div id='form-success'>Success, all details for selected record deleted</div>";
                    
                }  else {
                
                    echo "<div id='form-error'>Failed, could not delete this record</div>";
                }
            
            }
	}
	
    public function create_new(){
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
				
				$this->load->view('persons/create_new');
                
            }
	}
        public function save_new_person(){//ajax func.
            
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceed.
                        </div>
                <?php return;
            }
            
            $this->load->model("persons_model");
            
            $clean_data = $this->persons_model->validate_new_person();

            if($clean_data === FALSE){ //validation failed
                 
                echo "<div id='form-error'>".validation_errors()."<a href='#' id='fold-back'> ..hide.. </a></div>"; 
                
                return;
            
            }else {  //validation success
                
               if($this->db->insert('persons', $clean_data)){
                    
                    echo "<div id='form-success'>success, data saved<a href='#' id='fold-back'> ..hide.. </a></div>"; 
                    
                    return;
                    
                }else{ //could not save to db
                    echo "<div id='form-error'>Failed, could not save to database<a href='#' id='fold-back'> ..hide.. </a></div>"; return;
                } 
            }
   	
	}
        public function edit_person(){
		
			$this->load->model('persons_model');
            
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
               
            }  else {
			
				$logged_in_person = ($this->session->userdata('user_type'));
				
				$edit_user_type = $this->persons_model->get_user_type($this->uri->segment(3));
				
			
				if($logged_in_person == "staff" AND $edit_user_type == "admin" ){
					
					$this->load->view('persons/no_permissions.php'); return;
				}
			
                if(!$this->uri->segment(3)){
                    echo "<h1>Illegal page accesss</h1>";
                }else{
                    $id = $this->uri->segment(3);
                    $limit = 1;
                    $offset = 0;
                    $q = $this->db->get_where('persons', array('id' => $id), $limit, $offset);
                    foreach ($q->result_array() as $value) {

                        $data['person'] = $value;
                    }

                    $this->load->view('persons/edit_person',$data);

                }
            
            }
	}
        public function save_edited_person(){
            
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceed.
                        </div>
                <?php return;
            }
            
            $this->load->model("persons_model");
            
            $clean_data = $this->persons_model->validate_edited_person();
                    
            if($clean_data === FALSE){ //validation errors occured
                
                echo "<div id='form-error'>".validation_errors()."<a href='#' id='fold-back'> ..hide.. </a></div>"; return;
            
            }else {  //validation success 
                
                $this->db->where('id', $this->uri->segment(3));
                
                if($save_data = $this->db->update('persons', $clean_data)){
                    
                    echo "<div id='form-success'>success, data saved<a href='#' id='fold-back'> ..hide.. </a></div>"; return;
                    
                }else{ //could not save to db
                    
                    echo "<div id='form-error'>Failed, could not save to database<a href='#' id='fold-back'> ..hide.. </a></div>"; return;
                } 
            }
	}
}
