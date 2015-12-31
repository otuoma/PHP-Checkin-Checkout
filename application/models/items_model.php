<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Items_model extends CI_Model {

	public function index(){
            
//		$this->load->view('items/');
	}
        
        public function checkin_item(){
            
            $insert_arr = array(
                'checkin_person_id' =>$this->input->post('checkin_person_id'),
                'movement_type'     =>'check_in',
                'staff_id'          =>$this->session->userdata('staff_id'),
                'time'              =>date("Y-m-d", time()),
                'item_unique_id'    =>$this->input->post('item_unique_id')
            );
            
            $insert_q = $this->db->insert('checkincheckout', $insert_arr);

            if($this->db->affected_rows() > 0 ){//success, update items tbl

                $update_arr = array( 'location' =>'checked_in' );
                
                $this->db->where('unique_id', $this->input->post('item_unique_id'));
                
                $this->db->update('items', $update_arr);
                
                if($this->db->affected_rows() > 0){

                    return TRUE;

                }  else {

                    return FALSE;
                }

            }  else {//could not complete checkin proceess

                return FALSE;
            }
	}
        public function checkout_item(){
            
            $insert_arr = array(
                'checkout_person_id' =>$this->input->post('checkout_person_id'),
                'movement_type'      =>'check_out',
                'time'               =>  date("Y-m-d", time()),
                'staff_id'           =>$this->session->userdata('staff_id'),
                'item_unique_id'     =>$this->input->post('item_unique_id')
            );

            if( $insert_q = $this->db->insert('checkincheckout', $insert_arr) ){//success, update items tbl

                $update_arr = array( 'location' =>'checked_out' );
                $this->db->where('unique_id', $this->input->post('item_unique_id'));
                $this->db->update('items', $update_arr);
                if($this->db->affected_rows() > 0){
                    
                    return TRUE;
                        
                }  else {//item was not checkedout

                   return FALSE;
                }

            }else{

                return FALSE; 
            }            
	}
        public function get_item_owner($id){//returns an array of * in persons tbl
            
            $q = $this->db->get_where('persons', array('id' => $id), 1, 0);
            
            if ($q->num_rows() == 1) {

                foreach ($q->result_array() as $value) {
                    
                    $data = $value;                    
                } 
                return $data;
                
             }else{

               return FALSE;
            }
        } 
        public function get_owner_with_unique_id($unique_id){//returns an array of * in persons tbl
            
            $q = $this->db->get_where('persons', array('unique_id' => $unique_id), 1, 0);
            
            if ($q->num_rows() == 1) {

                foreach ($q->result() as $value) {
                    
                    $data = $value;                    
                } 
                return $data;
                
             }else{

               return FALSE;
            }
        } 
        
        public function get_staff_details($staff_id){//returns an object of * in persons tbl
            
            $q = $this->db->get_where('persons', array('id' => $staff_id), 1, 0);
            
            if ($q->num_rows() == 1) {

                foreach ($q->result() as $value) {
                    
                    $data = $value;                    
                } 
                return $data;
                
             }else{

               return FALSE;
            }
        } 
        public function get_checkedin_items($unique_id){//returns an array of * in persons tbl
            
            $q = $this->db->get_where('items', array('location' => 'checked_in'));
            
            if ($q->num_rows() > 0) {

                return $q->result() ;
                
             }else{

               return 0;
            }
        } 
        
        public function get_checkedout_items($unique_id){//returns an array of * in persons tbl
            
            $q = $this->db->get_where('items', array('location' => 'checked_out'));
            
            if ($q->num_rows() > 0) {

                return $q->result() ;
                
             }else{

               return 0;
            }
        }
        
}