<?php class Checkincheckout_model extends CI_Model {

	public function index(){
            

	}
        
        public function checkin_item(){
            
            $insert_arr = array(
                'checkin_person_id' =>$this->input->post('checkin_person_id'),
                'movement_type'     =>'check_in',
                'time'              =>intval(time()),
                'staff_id'          =>$this->session->userdata('staff_id'),
                'item_unique_id'    =>$this->input->post('item_unique_id')
            );
            
            $insert_q = $this->db->insert('checkincheckout', $insert_arr);
            
            if( $this->db->affected_rows() > 0 ){//success, update items tbl
                
                $this->db->where('unique_id',$this->input->post('item_unique_id'));
                
                $update_q = $this->db->update('items', array( 'location'=>'checked_in'));
                if($this->db->affected_rows() > 0){
                    return TRUE;
                }else{
                    return FALSE;
                }
                
            }  else {
                
                return FALSE;
            } 
	}
        public function checkout_item(){
            
            $insert_arr = array(
                'checkout_person_id' =>$this->input->post('checkout_person_id'),
                'movement_type'      =>'check_out',
                'time'               =>date("Y-m-d", $time()),
                'staff_id'           =>$this->session->userdata('staff_id'),
                'item_unique_id'     =>$this->input->post('item_unique_id')
            );
            
            $insert_q = $this->db->insert('checkincheckout', $insert_arr);
            
            if( $this->db->affected_rows() > 0 ){//success, update items tbl
                
                $this->db->where('unique_id',$this->input->post('item_unique_id'));
                
                $update_q = $this->db->update('items', array( 'location'=>'checked_out'));
                
                if($this->db->affected_rows() > 0){
                    
                    return TRUE;
                    
                }else{
                    
                    return FALSE;
                }
                
            }else{
                
                return FALSE; 
            }
           
	}
}