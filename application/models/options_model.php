<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Options_model extends CI_Model {

	public function set_option($name, $value){
	
		$insert_arr = array(
			'name'  =>$name,
			'value' =>$value
		);
		
		$q = $this->db->insert($insert_arr);
		
		if($this->db->affected_rows() > 0 ){

			return TRUE;
			
		}  else {

			return FALSE;
		}
	
	}
	
	public function get_option($option_name){
		
		//$this->db->from('options');
		
		$q = $this->db->get_where('options', array('name'=>$option_name));
		
		if($q->num_rows() > 0){
			
			foreach($q->result() as $option){
				
				$value = $option->value;
			}
			
			return $value;
			
		}else{
		
			return NULL;
		}
	
	}
	public function update_option($name, $new_value){
	
		$update_arr = array( 'value' =>$new_value );
			
		$this->db->where('name', $name);
		
		$this->db->update('options', $update_arr);
		
		if($this->db->affected_rows() > 0){

			return TRUE;

		}  else {

			return FALSE;
		}
	
	}
	public function option_exists($option_name){
		
		$this->db->from('options');
		
		$q = $this->db->get_where('name', $option_name);
		
		if($q->num_rows() > 0){ return FALSE; }else{ return TRUE; }
	}
     

}