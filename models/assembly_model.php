<?php
class Assembly_model extends CI_Model {
    // table name 
  
  
 
    // get number of persons in database
    function get_all(){
	    $this->db->where('active', 'Active');
        return $this->db->get('coustomerinfo');
      }
	   
	  
	
		function Billinfo($order,$status){
        $this->db->select('*');
        $this->db->from('delivery');
        $this->db->join('order_manage', 'order_manage.detail_id = delivery.order_detail_id');
        $this->db->where('delivery.order_id', $order);
        $this->db->where('bill', $status);
        $query = $this->db->get();

        return $query;
    }
	
	function order($ord){
        
        $this->db->where('coustomerid', $ord);
     
        return $this->db->get('order');
         
         
    }

	function remain($ord){
	//$this->db->order_by("remain", "asc");
	
	     //$this->db->limit(1);
	    $this->db->where('order_detail_id', $ord);
		 return $this->db->get('delivery');
		 //print_r ("DDD");
       //return echo "GGG";
      }
	  
	function save($assembly_order){
	
	  
	  $this->db->insert('assembly_order', $assembly_order);
      return $this->db->insert_id();
	  
    }
		  function product_update($assembly_order)
	  {
	    

	    $this->db->where('coustomer_id',$assembly_order['coustomer_id']);
	    $this->db->where('order_id',$assembly_order['order_id']);
		$this->db->where('product_id',$assembly_order['product_id']);
		return $this->db->get('product_stock');
	  }
	  function product_update_insert($product_stock)
	  {
	      $this->db->insert('product_stock', $product_stock);
          return $this->db->insert_id();
	  
	  }
	  function product_update_stock($product_stock)
	  {
	  
	    $this->db->where('coustomer_id',$product_stock['coustomer_id']);
	    $this->db->where('order_id',$product_stock['order_id']);
		$this->db->where('product_id',$product_stock['product_id']);
		$this->db->set('carton',$product_stock['carton']);
		return $this->db->update('product_stock');
	  }
		function stockupdate($catagory,$amount,$type)
		{
		$this->db->set('amount',$amount);
		 $this->db->where('type', $type);
		$this->db->where('catagory',$catagory);
		return $this->db->update('total_stock');
		}	
	function orderinfo($order){
        $this->db->select('*');
        $this->db->from('order_manage');
        $this->db->join('order', 'order.id = order_manage.order_id');
		$this->db->join('product', 'product.id = order_manage.material');
        $this->db->where('order_id', $order);
       
        $query = $this->db->get();

        return $query;
    }
	 function update($ord){
        $this->db->where('id', $ord['id']);
        $this->db->update('delivery',  $ord);
    }
   
	function catagory_by_stock($type,$catagory){
	  $this->db->select('amount');
	  $this->db->from('total_stock');
	  $this->db->where('type', $type);
	  $this->db->where('catagory',$catagory);
	return $this->db->get();
	}
	function count_all(){
	  
	   
        return $this->db->count_all('total_stock');
    }
    // get persons with paging
    function get_paged_list($limit = 10, $offset = 0){
	    
        //$this->db->order_by('EmployeeId','asc');
        return $this->db->get('total_stock');
    }
}
	
	
	