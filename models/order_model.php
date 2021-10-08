<?php
class order_Model extends CI_Model {
  
    // get persons with paging
    function get_all(){
        $this->db->order_by('CoustomerId','asc');
		$this->db->where('active', 'Active');
        return $this->db->get('coustomerinfo');
    }
	
	
	function save($ordertable){
	
	  $this->db->insert('order', $ordertable);
      return $this->db->insert_id();
	  
    }
function product_all(){
	    $this->db->where('status', 'active');
        return $this->db->get('product');
      }
	function save_detail($order){
	
	  $this->db->insert('order_manage', $order);
      return $this->db->insert_id();
	  
    }
    
}

?>