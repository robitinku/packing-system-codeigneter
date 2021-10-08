<?php
class report_model extends CI_Model {

  function attendance_list_timecard($firstdate,$lastdate){

        $this->db->select('*');
		$this->db->from('casulastaftimecard');
        $this->db->join('attendance_time', 'attendance_time.id = casulastaftimecard.attendance_id');
        $this->db->join('employee', 'employee.EmployeeId = attendance_time.employeeid');
		$this->db->join('department', 'department.id = employee.Department');
        
		$this->db->where('casulastaftimecard.Date >=', $firstdate); 
		$this->db->where('casulastaftimecard.Date <=', $lastdate);
       // $this->db->limit(2);
	  // $this->db->group_by("casulastaftimecard.Date");
          $this->db->order_by("casulastaftimecard.Date", "asc");
        $query = $this->db->get();

        return $query;


    }
	 function get_paged_list_coustomer($firstdate,$lastdate,$coustomer){
	   
		$this->db->join('coustomerinfo', 'coustomerinfo.CoustomerId = revenue.coustomer_id');
        if($coustomer!="")
		$this->db->where('revenue.coustomer_id', $coustomer);
		if($firstdate!="")
        $this->db->where('date >=', $firstdate); 
		if($lastdate!="")
		$this->db->where('date <=', $lastdate);		
        $this->db->order_by('id','asc');
		
        return $this->db->get('revenue');
    }

	function Supllier($firstdate,$lastdate){
	   
		$this->db->join('supplier', 'supplier.id = supplier_payment.supplier_id');
        
        $this->db->where('date >=', $firstdate); 
		$this->db->where('date <=', $lastdate);		
        $this->db->order_by('supplier_payment.id','asc');
		
        return $this->db->get('supplier_payment');
    }
	  function expense($firstdate,$lastdate){
	    $this->db->where('date >=', $firstdate); 
		$this->db->where('date <=', $lastdate);	
        $this->db->order_by('id','asc');
        return $this->db->get('expense');
    }
	function salary($firstdate,$lastdate){
	   $this->db->select_sum('salary');
	    $this->db->where('date >=', $firstdate); 
		$this->db->where('date <=', $lastdate);
	
        //$this->db->order_by('id','asc');
        return $this->db->get('salary');
    }
	  function totalstock(){
	  
	   
        return $this->db->get('total_stock');
    }
	
	function bankwithdate($date){
	    $this->db->select( 'bank_name.id,bank_name.bank_name, bank_name.branchname , bank_name.account_name , sum(CASE WHEN bank_detail.type= "deposit" THEN bank_detail.amount 
							WHEN (bank_detail.type= "Withdraw" && bank_detail.status="Release"  ) THEN -(bank_detail.amount) ELSE 0 END ) as amount');
        $this->db->from('bank_name');
		$this->db->join('bank_detail', 'bank_detail.bank_id = bank_name.id','left');
		$this->db->group_by('bank_name.id,bank_name.bank_name, bank_name.branchname , bank_name.account_name ');
        $this->db->order_by('bank_name.id','desc');
		$this->db->where('date <',$date);
        return $this->db->get();
    }
    
    
	function accountbalance($date)
	{
       $this->db->select('amount');
	   $this->db->from('account');
	   $this->db->order_by('id','DESC');
	   $this->db->limit(1);
	   $this->db->where('date <',$date);
       return $this->db->get();
	
	}
	function accountbalancelast($date)
	{
       $this->db->select('amount');
	   $this->db->from('account');
	   $this->db->order_by('id','DESC');
	   $this->db->limit(1);
        
		$this->db->where('date <=', $date); 
		
       return $this->db->get();
	
	}
	function bankwithdatelast($date){
	    $this->db->select( 'bank_name.id,bank_name.bank_name, bank_name.branchname , bank_name.account_name , sum(CASE WHEN bank_detail.type= "deposit" THEN bank_detail.amount 
							WHEN (bank_detail.type= "Withdraw" && bank_detail.status="Release"  ) THEN -(bank_detail.amount) ELSE 0 END ) as amount');
        $this->db->from('bank_name');
		$this->db->join('bank_detail', 'bank_detail.bank_id = bank_name.id','left');
		$this->db->group_by('bank_name.id,bank_name.bank_name, bank_name.branchname , bank_name.account_name ');
        $this->db->order_by('bank_name.id','desc');
		$this->db->where('date <=',$date);
        return $this->db->get();
    }

}

?>
