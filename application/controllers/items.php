
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items extends CI_Controller {

	public function index(){
            //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>";
            
            //set a referer
            if(isset($_SERVER['HTTP_REFERER'])){
                
                $data['referer'] = $_SERVER['HTTP_REFERER'];
                
            }  else {
                
                $data['referer'] = base_url()."index.php/tracker";
            }
               
               $this->load->view('login_view', $data); 
               
            }  else {
            
                $this->load->model('items_model');

                $this->load->library('pagination');

                $config['base_url']   = base_url().'index.php/items/index/';

                $config['total_rows'] = $this->db->get('items')->num_rows();

                $config['per_page']   = 15;

                $config['num_links']  = 8;

                $this->pagination->initialize($config);

                $data['items']        = $this->db->get('items', $config['per_page'], $this->uri->segment(3));

                $data['pg_links']     = $this->pagination->create_links();

                $this->load->view('items/all_items', $data);
            }

        }
        public function process_report(){

            if($this->input->post('dateone') && $this->input->post('datetwo')){
                
				$limit 	 = trim($this->input->post('perpage'));
				$dateone = trim($this->input->post('dateone'));
				$datetwo = trim($this->input->post('datetwo'));
				
				$this->load->model('persons_model');
				$this->load->model('items_model');
				
				$this->db->where('time >= ', $dateone);
				$this->db->where('time <= ', $datetwo);
				
				$total_items  = $this->db->get('items');
				
				$this->db->limit($limit);
				$perpage = $limit;
				if($this->input->post('page_number')){
					$curr_page = $this->input->post('page_number')-1;
					$offset = ($curr_page * $perpage);
					$this->db->offset($offset);
				}  else {
					$offset = 0;
					$curr_page = 1;
				}
				
				if($perpage < 1){ $perpage = 15;}
				$num_of_pages = ceil($total_items->num_rows() / $perpage);
				
				$this->db->where('time >= ', $dateone);
				$this->db->where('time <= ', $datetwo);
				
				$q = $this->db->get('items');
				
				if($q->num_rows() > 0){
					?><div align="right" style="margin: 6px;" id="printBtns">
						<input type="button" id="printBtn" value=" print "> &nbsp;
					</div>
					<div style="background: #ff99cc ; border: #ff6666 solid 1px; padding: 5px;">
						Registered items as at <?php echo date('d-M-Y',strtotime($dateone)).' to '.date('d-M-Y',strtotime($datetwo)); ?>
					</div>
					<table id="results">
							<thead>
							<th>N<sup>o.</sup></th><th>ITEM ID</th><th>Owners ID</th><th>Date</th>
							</thead>
							<tbody>	
					<?php
					$num = $offset;
					foreach($q->result() as $item){ 
						
						$item_detail = $this->persons_model->get_item_with_unique_id($item->unique_id);
						
						$person_detail = $this->items_model->get_item_owner($item_detail->owner_id);
						?>
						<tr><td><?php $num++; echo $num ?>.</td>
							<td><?php echo $item->unique_id; ?></td>
							<td><?php echo $person_detail['unique_id']; ?></td>
							<td><?php echo date('d-M-Y', strtotime($item->time)); ?></td>
						</tr>
					
				<?php	}//endforeach
					?><tr><td colspan="5" style="background: #ff99cc ; border: #ff6666 solid 1px; padding: 5px;">
                           <form method="post" action="#" id="pagination_form">
                            Total <?php echo $total_items->num_rows()." items on ".$num_of_pages." pages "; ?> .
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

                        var URL = "<?php echo base_url(); ?>index.php/items/process_report";
                            //alert(formVals); return false;
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
                </script>
				
					<?php 
					
				}else{
				
					?><div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            <h3> No items found. </h3>
                        </div>
				<?php
				}
            }else{
				
					?><div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            <h3> Please submit a valid date range </h3>
                        </div>
				<?php
			}
        }
        public function reports(){
            
            //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>";
            
                //set a referer
                if(isset($_SERVER['HTTP_REFERER'])){

                    $data['referer'] = $_SERVER['HTTP_REFERER'];
                }else{
                    $data['referer'] = base_url()."index.php/tracker";
                }
                $this->load->view('login_view', $data);
            }else{
                 $this->load->view('items/reports');
            }
            
        }
        public function json_data(){

            $query = "523456";
            
            $this->db->select('description,unique_id');
            $this->db->like('unique_id', $query);
            $this->db->or_like('description', $query); 
            $q = $this->db->get('items');
            if($q->num_rows() > 0){//

                foreach ($q->result_array() as $row){
                   
                    $data[] = array(
						'label' => $row['unique_id'] .', '. $row['description'] ,
						'value' => $row['unique_id']
                    );
                }
            }  else {
                $data[] =array('label'=>"missing value", 'value'=>'value');
            } 
              echo json_encode($data);           
        }
        public function checkedout_livesearch(){
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>
                <?php return;
            }
            
            if(!$this->input->post('item_unique_id') || trim($this->input->post('item_unique_id')) == ""){
                echo "<h2> Please enter Item ID to search</h2>"; return;
            }
            
            $this->load->model('items_model');
            
            $this->load->model('persons_model');
            
            $item_unique_id = trim($this->input->post('item_unique_id'));
            
            $dateone        = date('Y-m-d', strtotime($this->input->post('dateone')));
            
            $datetwo        = date('Y-m-d', strtotime($this->input->post('datetwo')));
            
            $this->db->order_by('id','desc');
            
            //$this->db->limit(15);
            
            $this->db->like('item_unique_id',$item_unique_id);
            
            $this->db->where('movement_type','check_out');
            
            if($this->input->post('dateone') AND $this->input->post('datetwo')){
            
                $this->db->where('time >= ', $dateone); 

                $this->db->where('time <= ', $datetwo);
           }
            
            $q  = $this->db->get('checkincheckout');
            
            if($q->num_rows() >0){ ?>
        
        <table id="results">
            <thead>
            <th>ITEM ID</th><th>Owners ID</th><th>Checked out by</th><th>DateTime</th>
            </thead>
            <tbody>
            <?php
            
            foreach ($q->result_array() as $item) {
                
                $item_detail = $this->persons_model->get_item_with_unique_id($item['item_unique_id']);
                $person_detail = $this->items_model->get_item_owner($item_detail->owner_id);
                
                    ?><tr>
                            <td><?php echo "<a href='".base_url()."index.php/items/edit_item/".$item_detail->id."'>".$item['item_unique_id']."</a>"; ?></td>
                            <td><?php echo "<a href='".base_url()."index.php/persons/edit_person/".$person_detail['id']."'>".$person_detail['unique_id']."</a>"; ?></td>
                            <td>
                                
                                <?php if($item['checkout_person_id'] !== $person_detail['unique_id']){
                                    echo "<span style='color:red;' title='item checked in by person who is not the registered owner'>";
                                }?>
								<?php echo $item['checkout_person_id']; ?>
								<?php if($item['checkout_person_id'] !== $person_detail['unique_id']){echo "</span>";}?>
                            
                            </td>
                            <td><?php echo $item['time']; ?></td>
                         </tr>
                    <?php
                
            }
        ?></tbody></table><?php  }else{
            echo "<h3>No items were found on the database</h3>";
        } 

        }
        public function checkedin_livesearch(){
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>
                <?php return;
            }
            
            if(!$this->input->post('item_unique_id') || trim($this->input->post('item_unique_id')) == ""){
                echo "<h2> Please enter Item ID to search</h2>"; return;
            }
            
            $this->load->model('items_model');
            
            $this->load->model('persons_model');
            
            $item_unique_id = trim($this->input->post('item_unique_id'));
            
            $dateone = $this->input->post('dateone');
            
            $datetwo = $this->input->post('datetwo');
            
            
            $this->db->like('item_unique_id',$item_unique_id);
            $this->db->order_by('time','desc');
            
            //$this->db->limit(15);
            
            //only use the date range if the 2 dates are set
            if($this->input->post('dateone') && $this->input->post('datetwo')){
            
                $this->db->where('time >= ', $dateone); 

                $this->db->where('time <= ', $datetwo);
           }
            
            $this->db->where('movement_type','check_in');
//               echo $dateone;               return;         
            $q  = $this->db->get('checkincheckout');
            if($q->num_rows() >0){  ?>
        
        <table id="results">
            <thead>
            <th>ITEM ID</th><th>Owners ID</th><th>Checked in by</th><th>DateTime</th>
            </thead>
            <tbody>
            <?php
            
            foreach ($q->result_array() as $item) {
                
                $item_detail = $this->persons_model->get_item_with_unique_id($item['item_unique_id']);
                $person_detail = $this->items_model->get_item_owner($item_detail->owner_id);
                
                    ?><tr>
                            <td><?php echo "<a href='".base_url()."index.php/items/edit_item/".$item_detail->id."'>".$item['item_unique_id']."</a>"; ?></td>
                            <td><?php echo "<a href='".base_url()."index.php/persons/edit_person/".$person_detail['id']."'>".$person_detail['unique_id']."</a>"; ?></td>
                            <td>
                                
                                <?php if($item['checkin_person_id'] !== $person_detail['unique_id']){
                                    echo "<span style='color:red;' title='item checked in by person who is not the registered owner'>";
                                }?>
								<?php echo $item['checkin_person_id']; ?>
								<?php if($item['checkin_person_id'] !== $person_detail['unique_id']){echo "</span>";} ?>
                            
                            </td>
                            <td><?php echo date("d-m-Y",strtotime($item['time'])); ?></td>
                         </tr>
                    <?php
                
            }
        ?></tbody></table><?php  }else{
            echo "<h3>No items were found on the database</h3>";
        } 

        }
        public function checkedout_items(){
            
             //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>";
            
            //set a referer
            if(isset($_SERVER['HTTP_REFERER'])){
                
                $data['referer'] = $_SERVER['HTTP_REFERER'];
            }  else {
                $data['referer'] = base_url()."index.php/tracker";
            }
               
               $this->load->view('login_view', $data); 
            }  else {
            
                $this->load->model('items_model');

                $this->load->model('persons_model');

                $this->load->library('pagination');

                $config['base_url']   = base_url().'index.php/items/checkedout_items/';

                $this->db->where(array('movement_type'=>'check_out'));

                $config['total_rows'] = $this->db->get('checkincheckout')->num_rows();

                $config['per_page']   = 15;

                $config['num_links']  = 8;

                $this->pagination->initialize($config);

                $this->db->where(array('movement_type'=>'check_out'));

                $data['items']  = $this->db->get('checkincheckout', $config['per_page'], $this->uri->segment(3));

                $data['pg_links']     = $this->pagination->create_links();

                $this->load->view('items/checkedout_items', $data);
            }
        
        }
        public function checkedin_items(){
            
             //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>";
            
            //set a referer
            if(isset($_SERVER['HTTP_REFERER'])){
                
                $data['referer'] = $_SERVER['HTTP_REFERER'];
            }  else {
                $data['referer'] = base_url()."index.php/tracker";
            }
               
               $this->load->view('login_view', $data); 
            }  else {
            
                $this->load->model('items_model');

                $this->load->model('persons_model');

                $this->load->library('pagination');

                $config['base_url']   = base_url().'index.php/items/checkedin_items/';

                $this->db->where(array('movement_type'=>'check_in'));

                $config['total_rows'] = $this->db->get('checkincheckout')->num_rows();

                $config['per_page']   = 15;

                $config['num_links']  = 8;

                $this->pagination->initialize($config);

                $this->db->where(array('movement_type'=>'check_in'));

                $data['items']  = $this->db->get('checkincheckout', $config['per_page'], $this->uri->segment(3));

                $data['pg_links']     = $this->pagination->create_links();

                $this->load->view('items/checkedin_items', $data);
            }
        }
        public function livesearch(){
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>
                <?php return;
            }
            
            if($this->input->post("search_val")){
                
            $param = trim($this->input->post("search_val"));
            
            }else{

                echo "<h4>Please enter an Item ID to search</h4>";

                return;
            }

            $this->load->model('items_model');

            $q = "SELECT * FROM items WHERE unique_id LIKE '%$param%' ORDER BY time DESC LIMIT 15";

            $item = $this->db->query($q);

            if ($item->num_rows() > 0){

                echo    "<table id='results'>
                        <thead>
                        <th>Item ID</th><th>Description</th><th>Location</th><th>Owner ID</th><th>Registered on</th><th>Delete</th>
                        </thead>
                        <tbody>";
                
                    foreach($item->result() as $item_info){
                        
                        $person_info = $this->items_model->get_item_owner($item_info->owner_id);

                        echo "<tbody><tr><td>";
                        echo "<a href='".base_url("index.php/persons/edit_person")."/".$item_info->id."'>".$item_info->unique_id."</a>"; 
                        echo "</td><td>".$item_info->description."</td>";
                        echo "<td>".$item_info->location."</td>
                                <td>".$person_info['unique_id']."</td>
                                <td>".$item_info->time."</td>
                                <td><a href='".  base_url('index.php/items/delete_item')."/".$item_info->id."'>#</a></td></tr>";
                     }
                }else{
                   
                    echo "<tr><td>No item info was found on the database</td></tr>";
                                        return;
                }
        echo "</tbody></table><p> &nbsp; </p>";
    }
        public function confirm_delete(){//displays the delete view
            //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
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

                    echo "<h1>Illegal page accesss</h1>";                return;
                }else{

                    $id = $this->uri->segment(3);

                    $this->db->where('id', $id);

                    if($this->db->delete('items')){

                        echo "<div id='form-success'>Success, all details for selected record deleted</div>";

                    }  else {

                        echo "<div id='form-error'>Failed, could not delete this record</div>";
                    }

                }
            }

        }
         public function delete_item(){//loads the edit view
             
              //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>";
            
            //set a referer
            if(isset($_SERVER['HTTP_REFERER'])){
                
                $data['referer'] = $_SERVER['HTTP_REFERER'];
            }  else {
                $data['referer'] = base_url()."index.php/tracker";
            }
               
               $this->load->view('login_view', $data);
               
            }  else {
            
                $this->load->model('items_model');

                if(!$this->uri->segment(3)){

                    echo "<h1>Illegal page accesss</h1>";  return;

                }else{

                    $this->db->where('id', $this->uri->segment(3));

                    $q = $this->db->get('items');

                    if($q->num_rows() == 1){//the item was found

                        foreach ($q->result() as $value) {

                            //check if item has depndents
                            $this->db->where('item_unique_id', $value->unique_id);

                            $check_q = $this->db->get('checkincheckout');

                            if($check_q->num_rows() > 0){
                                $data['has_dependencies'] = "has dependencies";
                            }

                            $data['item']   = $value;
                            $data['person'] = $this->items_model->get_item_owner($value->owner_id);
                        }

                    }  else {//the person was not found

                        $data['error'] = "<h3>The item was not found on database</h3>";

                    }
                    $this->load->view('items/delete_item',$data);            
                }
            }

        }
        public function edit_item(){//loads the edit view
             //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>";
            
            //set a referer
            if(isset($_SERVER['HTTP_REFERER'])){
                
                $data['referer'] = $_SERVER['HTTP_REFERER'];
            }  else {
                $data['referer'] = base_url()."index.php/tracker";
            }
               
               $this->load->view('login_view', $data);
               
            }  else {
            
                $this->load->model('items_model');

                if(!$this->uri->segment(3)){

                    echo "<h1>Illegal page accesss</h1>";  return;

                }else{

                    $id = $this->uri->segment(3);

                    $q = $this->db->get_where('items', array('id' => $id), 1, 0);

                    foreach ($q->result_array() as $value) {

                        $data['item']   = $value;

                        $data['person'] = $this->items_model->get_item_owner($value['owner_id']);
                    }               

                    $this->load->view('items/edit_item',$data);            
                }
            }
        
        }

        public function create_new(){
            
             //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>";
            
            //set a referer
            if(isset($_SERVER['HTTP_REFERER'])){
                
                $data['referer'] = $_SERVER['HTTP_REFERER'];
            }  else {
                $data['referer'] = base_url()."index.php/tracker";
            }
               
               $this->load->view('login_view', $data);
               
            }  else {
            
		$this->load->view('items/create_new');
            }
	}
        public function save_new_item(){
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>
                <?php return;
            }
            
            $this->load->model("items_model");
            
            $this->form_validation->set_rules('unique_id', 'Item ID', 'trim|required|is_unique[items.unique_id]');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('owner_id', 'Owners ID', 'trim|required');
            
           //check if owners id exists   
           $q = $this->db->get_where('persons', array('unique_id'=>$this->input->post('owner_id')));
           
           if($q->num_rows() > 0){ //person ID exists, proceed
               
               //execute the validations
               if(!$this->form_validation->run()){//validation failed
                   
                   echo "<div id='form-error'>".validation_errors()." <a href='#' id='fold-back'> ..hide.. </a></div>";
                   
               }else{//validation success, save to db
                   
                   $person = $this->items_model->get_owner_with_unique_id($this->input->post('owner_id'));
                   //echo print_r($person);                   return;
                   $data_arr = array(
                        'unique_id'   => $this->input->post('unique_id') ,
                        'description' => $this->input->post('description') ,
                        'staff_id'    => $this->session->userdata('staff_id'),
                        'time'        => date("Y-m-d", time()),
                        'owner_id'    => $person->id
                   );

                   if($this->db->insert('items', $data_arr)){ ?>

                       <div id='form-success'>
                           Success, new record saved . . . <a href='#' id='fold-back'> ..hide.. </a>
                       </div>
                       
                        
                      <?php  return;
                                          
                   }else{//could not save to db
                       
                      echo "<div id='form-error'>Could not access database<a href='#' id='fold-back'> ..hide.. </a></div>";
                      
                      return;
                   }                    
               }
               
           }else{//person ID does not exist
               
               echo "<div id='form-error'>Owners ID given does not exist <a href='#' id='fold-back'> ..hide.. </a></div>";               return;
               
               return;
           }
           
	}
        public function save_edited_item(){
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>
                <?php return;
            }
            
            $this->load->model("items_model");
           
            $old_vals = $this->db->get_where('items', array('id'=>$this->uri->segment(3)));
            
            $this->form_validation->set_rules('unique_id', 'Item ID', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');
            $this->form_validation->set_rules('owner_id', 'Owners ID', 'trim|required');
                        
           //check if owners id exists   
           $q = $this->db->get_where('persons', array('unique_id'=>$this->input->post('owner_id')));
           
           if($q->num_rows() > 0){ //person ID exists, proceed
                
               //execute the validations
               if(!$this->form_validation->run()){//validation failed
                  
                   //Reset old vals back to the db
                   foreach ($old_vals->result_array() as $val){
                        $arr = array(
                             'unique_id'   => $val['unique_id'] ,
                             'description' => $val['description'] ,
                             'owner_id'    => $val['owner_id']
                        );
                   }
                   
                   $this->db->where('id',$this->uri->segment(3));
                   $this->db->update('items', $arr);
                   
                   echo "<div id='form-error'>".validation_errors()." <a href='#' id='fold-back'> ..hide.. </a></div>";
                   
               }else{//validation success, save to db
                   
                   $person = $this->items_model->get_owner_with_unique_id($this->input->post('owner_id'));
                   
                   $data_arr = array(
                        'unique_id'   => $this->input->post('unique_id') ,
                        'description' => $this->input->post('description') ,
                        'owner_id'    => $person->id
                   );
                   
                   $this->db->where('id',$this->uri->segment(3));
                   
                   if($this->db->update('items', $data_arr)){
                       
                        echo "<div id='form-success'>Success, new record saved . . . <a href='#' id='fold-back'> ..hide.. </a></div>";
                                          
                   }else{//could not save to db
                                          //Reset old vals back to the db
                   foreach ($old_vals->result_array() as $val){
                       
                        $arr = array(
                             'unique_id'   => $val['unique_id'] ,
                             'description' => $val['description'] ,
                             'staff_id'    => $this->session->userdata('staff_id') ,
                             'owner_id'    => $val['owner_id']
                        );
                   }
                   
                   $this->db->where('id',$this->uri->segment(3));
                   
                   $this->db->update('items', $arr);

                      echo "<div id='form-error'>Could not access database
                            <a href='#' id='fold-back'> ..hide.. </a>
                          </div>";
                   }                    
               }
               
           }else{//person ID does not exist
           
               echo "<div id='form-error'>
                        Owners ID given does not exist 
                        <a href='#' id='fold-back'> ..hide.. </a>
                    </div>";              
               return;
           }
                       
            
        }
        
        
}
