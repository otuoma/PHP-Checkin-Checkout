<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tracker extends CI_Controller {

	public function index(){
            
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
                
                $this->load->view('tracker/checkincheckout');    
            }
            
	}
        public function process_report(){
            
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                    </div>
                <?php return;
            }
            
            
            $dateone       = trim($this->input->post('dateone'));
            $datetwo       = trim($this->input->post('datetwo'));
            $movement_type = $this->input->post('checkincheckout');
            
            $this->load->model('items_model');
            
            //get total num of items
            $this->db->where('time >= ', $dateone); 
            $this->db->where('time <= ', $datetwo);
            $this->db->where('movement_type',$movement_type );
            
            $total_items  = $this->db->get('checkincheckout');
            $perpage      = trim($this->input->post('perpage'));
            if($perpage < 1){ $perpage = 15;}
            $num_of_pages = ceil($total_items->num_rows() / $perpage);
            
            if($this->input->post('page_number')){
                $curr_page = $this->input->post('page_number')-1;
                $offset = ($curr_page * $perpage);
                $this->db->offset($offset);
            }  else {
                $offset = 0;
                $curr_page = 1;
            }
            
            $this->db->where('time >= ', $dateone); 
            $this->db->where('time <= ', $datetwo);
            $this->db->where('movement_type',$movement_type );
            $this->db->limit($perpage);
            
            $q = $this->db->get('checkincheckout');
            
            if($q->num_rows() > 0){ //echo "num rows"; return;
                ?><div align="right" style="margin: 6px;" id="printBtns">
                    <input type="button" id="printBtn" value=" print "> &nbsp;
                </div>
                <div style="background: #ff99cc ; border: #ff6666 solid 1px; padding: 5px;">
                    <?php if($movement_type == "check_in"){echo "Checked in Items";}  else { echo "Checked out Items";} ?>
                    as at <?php echo date('d-M-Y',strtotime($dateone)).' to '.date('d-M-Y',strtotime($datetwo)); ?>
                </div>

                <table>
                    <thead>
                        <th>N<sup>O.</sup></th>
                        <th>Item ID</th>
                        <th>
                            <?php if($movement_type == "check_in"){echo "Checkedin by";}  else { echo "Checkedout by";} ?>
                        </th>
                        <th> Date </th>
                        <th> Staff </th>
                    
                    </thead>
                    <tbody>
                <?php $num = $offset;
                foreach ($q->result() as $item){
                    ?>
                    <tr>
                        <td><?php $num++; echo $num ?>.</td>
                        <td><?php echo $item->item_unique_id; ?></td>
                        <td>
                            <?php if($movement_type == "check_in"){
                                    
                                    echo $item->checkin_person_id;}  else { echo $item->checkout_person_id;
                                
                                } ?>
                        </td>
                        <td><?php echo $item->time; ?></td>
                        <td>
                            <?php $staff_info = $this->items_model->get_staff_details($item->staff_id); 
                                echo $staff_info->first_name." ".$staff_info->second_name;
                            ?>
                        </td>
                    </tr>
                    <?php
                } ?>
                    <tr><td colspan="5" style="background: #ff99cc ; border: #ff6666 solid 1px; padding: 5px;">
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
                    </tr> 
                    </tbody></table>
                    <?php
                
            }else{//no items were found
                ?><div style="background: #ffcccc; border: #ff6666 solid 1px;">
                    <h3> No Items Found </h3>
                </div>
                
                    <?php
            }
            ?>
                <script>
                    $('input#printBtn').click(function(){
                        window.print();
                        return false;
                    });
                    $('#pagination_form').submit(function(){
                        var formVals = $('#fetch_form').serialize() + "&" + $('#pagination_form').serialize();

                        var URL = "<?php echo base_url(); ?>index.php/tracker/process_report";
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
            return;
            
        }
        public function reports(){
            
            //set a referer
            if(isset($_SERVER['HTTP_REFERER'])){

                $data['referer'] = $_SERVER['HTTP_REFERER'];

            }else{

                $data['referer'] = base_url()."index.php/tracker";
            }            
            //check if is loggedin
            if(!$this->session->userdata('logged_in')){
               
                $data['login_info'] = "<div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>";
            
                 $this->load->view('login_view', $data); 
               
            }else{
            
                $this->load->view('tracker/reports', $data);
            
            }
            
        }
        
        public function get_item_details(){
            if(!$this->session->userdata('logged_in')){
                ?>
                    <div style='background: #ffcccc; border: solid 1px #ff6666; padding: 5px;'>
                            You must be logged in to proceeed.
                        </div>
                <?php return;
            }
            
            if($this->input->post('item_unique_id')){
                
                $param = trim($this->input->post('item_unique_id'));
                
                if($param == ""){echo "<h3>Please enter item ID to search</h3>"; return;}
                
                $this->load->model('items_model')   ;
                $this->load->model('persons_model')   ;
                $this->load->model('checkincheckout_model')   ;
                
                //do checkin checkout functions
                //==========================ckeck in============================================
                if($this->input->post('checkin_person_id')){//we'r checking in a bloody bustard
                    
                    //compare item owner and item bearer
                    
                    if($this->items_model->checkin_item()){ ?>
                        
                        <div style="background: #ccffcc; border: solid 1px #00cc66; padding: 5px;">
                            
                            Success, item was checked in</div><?php
                        
                    } else {/*item was not checked in entirely or partially*/ ?>
                    
                        <div style="background: #ffcccc; border: solid 1px #ff6666; padding: 5px;">
                            Error, item check-in failed
                        </div><?php }
                }
                //==========================ckeck out============================================
                if($this->input->post('checkout_person_id')){//we'r checking out a bloody bustard
                    
                    //compare item owner and item bearer
                    if($this->items_model->checkout_item()){ ?>

                        <div style="background: #ccffcc; border: solid 1px #00cc66; padding: 5px;">
                           Success, item was checked out
                        </div><?php
                        
                    }else{ ?>
                        
                        <div style="background: #ffcccc; border: solid 1px #ff6666; padding: 5px;">
                            Error, item check-out failed
                        </div><?php
                        
                    } 
                }
                
                $items_info = $this->db->get_where('items', array('unique_id' => $param),1,0); 
                
                if($items_info->num_rows() > 0){
                    foreach ($items_info->result() as $item_info):
                        
                        $person_info = $this->items_model->get_item_owner($item_info->owner_id);
                    
                        $item_location = "";
                        
                        if($item_info->location == "checked_out"){
                            
                            $item_location .= "checked out" ;
                        }elseif ($item_info->location == "checked_in") {
                            
                            $item_location .= "checked in" ;
                        
                        }  else {
                            
                            $item_location .= "Indeterminate" ;
                            
                        }
                ?>
                
                <p>
                <fieldset><legend style="border: solid 1px #000; padding: 5px;">Item Info</legend>
                    
                    <?php 
                    
                    if($item_location == "checked out"){//item is checked out
                        
                        ?>
                        <p>
                            <script type="text/javascript">
                                
                               $('input#checkin_person_id').focus(); 
                                
                               $('form#checkin_form').submit(function(){
                                   var inURL  = "<?php echo base_url(); ?>index.php/tracker/get_item_details/";
                                   var inData = $('form#checkin_form').serialize();
                                   
                                   //check if bearer is the owner
                                   var bearer = $('input#checkin_person_id').val();
                                   
                                   var owner = "<?php echo $person_info['unique_id'];?>";
                                   
                                   if(bearer !== owner){//give an alert
                                       
                                       if(confirm('The bearer is not the registered owner\n \t OK to proceed else cancel')){
                                            $.ajax({
                                              url    : inURL,
                                              cache  : false,
                                              type   : "POST",
                                              data   : inData,
                                              success: function(response) {

                                                  $('#tbl-holder').html(response);
                                              }//end success 1
                                          }); 
                                       }
                                       
                                   }else{//safe to checkin item//order url, data
                                        
                                        $.ajax({
                                            url    : inURL,
                                            cache  : false,
                                            type   : "POST",
                                            data   : inData,
                                            success: function(response) {

                                                $('#tbl-holder').html(response);
                                            }//end success 1
                                        });
                                   }
                                   return false;
                               });
                           </script>
                           <form id="checkin_form" method="post" action="#">
                                Person ID 
                                <input type="text" id="checkin_person_id" name="checkin_person_id" value="<?php //echo $person_info['unique_id'];?>">
                                <input type="hidden" name="item_unique_id" value="<?php echo $item_info->unique_id; ?>">
                                <input type="submit" value="check in">
                            </form>
                        </p>
                        
                        
                        <?php
                        
                    }  else { //item is checked in
                        
                        ?>
                        <p>
                        <script type="text/javascript">
						$('input#checkout_person_id').focus();
                        $('form#checkout_form').submit(function(){
                            var outURL  = "<?php echo base_url(); ?>index.php/tracker/get_item_details/";
                            var outData = $('form#checkout_form').serialize();
                            
                            //check if bearer is the owner
                            var bearer = $('input#checkout_person_id').val();

                            var owner = "<?php echo $person_info['unique_id'];?>";

                            if(bearer !== owner){//give an alert
                                
                                if(confirm('The bearer is not the registered owner\n \t OK to proceed else cancel')){
                                    $.ajax({
                                        url    : outURL,
                                        cache  : false,
                                        type   : "POST",
                                        data   : outData,
                                        success: function(response) {

                                            $('#tbl-holder').html(response);

                                        }//end success 1
                                    });
                                }
                                
                            }else{//safe to checkin item

                                $.ajax({
                                    url    : outURL,
                                    cache  : false,
                                    type   : "POST",
                                    data   : outData,
                                    success: function(response) {

                                        $('#tbl-holder').html(response);

                                    }//end success 1
                                });
                            }
                        
                            return false;
                        });
                    </script>
                            <form id="checkout_form" method="post" action="#">
                                Patron ID 
                                <input id="checkout_person_id" type="text" name="checkout_person_id" value="<?php //echo $person_info['unique_id'];?>">
                                <input type="hidden" name="item_unique_id" value="<?php echo $item_info->unique_id;?>">
                                <input type="submit" value="check out">
                            </form>
                        </p>
                        
                       <?php } ?>
                    
                    <table id='results'>
                        <thead>
                            <th>Item ID</th><th>Description</th><th>Location</th><th>Registered on</th><th>Delete</th>
                        </thead>
                        <tbody>
                            <td><a href="<?php echo base_url()."index.php/items/edit_item/".$item_info->id;?>"><?php echo $item_info->unique_id;?></a></td>
                            <td><?php echo $item_info->description;?></td>
                            <td><?php echo $item_location;?></td>
                            <td><?php echo date('Y-m-d', strtotime($item_info->time));?></td>
                            <td>
                                <a href="<?php echo base_url()."index.php/items/delete_item/".$item_info->id;?>"> # </a>
                            </td>
                        </tbody>
                    </table>
                </fieldset>
               </p>
               
                               <p>
                <fieldset><legend style="border: solid 1px #000; padding: 5px;">Owners Info</legend>
					<div id="avatar-area" align="center">
						<?php $avatar_img = $this->persons_model->get_avatar($person_info['id']);
						
							echo "Click to Edit<br>";
						?><a href="<?php echo base_url()."index.php/persons/upload_screen/".$person_info['id']; ?>">
						<img src="<?php echo base_url()."images/avatars/". $avatar_img; ?>" width="235px" height="235px" border="0px"></a>
						<br />
						<?php echo $person_info['second_name'].", ".$person_info['first_name']; ?>
					</div>
                    <table id='results'>
                        <thead>
                            <th>Name</th><th>Patron ID</th><th>Cellphone</th><th>Registered on</th><th>Delete</th>
                        </thead>
                        <tbody>
                            <td><a href="<?php echo base_url()."index.php/persons/edit_person/".$person_info['id'];?>">
                                    <?php echo $person_info['first_name']." ".$person_info['second_name'];?>
                                </a>
                            </td>
                            <td><?php echo $person_info['unique_id'];?></td>
                            <td><?php echo $person_info['cellphone'];?></td>
							<td><?php echo date('d-m-Y', strtotime($person_info['time']));?></td>
                            <td>
                                <a href="<?php echo base_url()."index.php/persons/delete_person/".$person_info['id'];?>"> # </a>
                            </td>
                        </tbody>
                    </table>
                </fieldset>
               </p>
               

                <?php  endforeach;?>
                <?php
                     
                }  else {//the item was not found
                    
                    echo "<h3 style='color:red;'>The item ID ".$param." was not found</h3>";  
                }
                
                return;
                
            }  else {//the field was empty
                
                echo "<h3>Please enter Item ID to search</3>";
                
                return;
            }
            
        }
}
