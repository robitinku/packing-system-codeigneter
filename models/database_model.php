<?php
class database_model extends CI_Model {

  
	  function get_paged_list($limit = 10, $offset = 0,$table){
	
        $this->db->order_by('id','asc');
        return $this->db->get($table, $limit, $offset);
    }
	
	  function expense($date){
	    $this->db->where('date',$date);	
        $this->db->order_by('id','asc');
        return $this->db->get('expense');
    }
	  function count_all($table){
	 
        return $this->db->count_all($table);
    }
	 function save($data,$table){
	     
	  
	   $this->db->insert($table, $data);
       return $this->db->insert_id();
    } 
	function accountupdte($amount)
	{
	   /* $this->db->set('amount', $amount);
	   $this->db->where('head', 'cash');
       $this->db->update('account');*/
	    $this->db->insert('account', $amount);
	}
	
	function accountbalance()
	{
       $this->db->select('amount');
	   $this->db->from('account');
	   $this->db->order_by('id','DESC');
	   $this->db->limit(1);
       return $this->db->get();
	
	}
	function get_by_id($id,$table){

        $this->db->where('id', $id);
        return $this->db->get($table);
    }
	function updatedata($data,$table){
	
       $this->db->where('id', $data['id']);
       $this->db->update($table,$data);
    }
	 function coustomer(){
	 
        $this->db->order_by('CoustomerId','asc');
	    $this->db->where('active', 'Active');
        return $this->db->get('coustomerinfo');
    }
	  function get_paged_list_coustomer($date){
	   
		$this->db->join('coustomerinfo', 'coustomerinfo.CoustomerId = revenue.coustomer_id');
        $this->db->where('date',$date);		
        $this->db->order_by('id','asc');
		
        return $this->db->get('revenue');
    }
	 function supplier(){
        $this->db->order_by('id','asc');
        return $this->db->get('supplier');
    }
  function get_paged_list_supplier($date){
	   $this->db->select( 'supplier_payment.id,supplier_payment.supplier_id, supplier_payment.amount , supplier_payment.date , supplier.supplier_name');
        $this->db->from('supplier_payment');
		$this->db->join('supplier', 'supplier.id = supplier_payment.supplier_id');
        $this->db->where('date',$date);		
        $this->db->order_by('supplier_payment.id','asc');
		
        return $this->db->get();
    }
	 function bank(){
	    $this->db->select( 'bank_name.id,bank_name.bank_name, bank_name.branchname , bank_name.account_name , sum(CASE WHEN bank_detail.type= "deposit" THEN bank_detail.amount 
							WHEN (bank_detail.type= "Withdraw" && bank_detail.status="Release"  ) THEN -(bank_detail.amount) ELSE 0 END ) as amount');
        $this->db->from('bank_name');
		$this->db->join('bank_detail', 'bank_detail.bank_id = bank_name.id','left');
		$this->db->group_by('bank_name.id,bank_name.bank_name, bank_name.branchname , bank_name.account_name ');
        $this->db->order_by('bank_name.id','asc');
        return $this->db->get();
    }
		function bank_detail(){
        $this->db->order_by('id','asc');
        return $this->db->get('bank_name');
    }
	
	function get_by_bank_id($id,$table){

        $this->db->where('bank_id', $id);
		$this->db->order_by('date','desc');
        return $this->db->get($table);
    }
}

?>
