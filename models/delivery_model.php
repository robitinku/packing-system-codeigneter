<?php
class Delivery_Model extends CI_Model {
    // table name 
  
  
 
    // get number of persons in database
    function coustomer_all(){
	    $this->db->where('active', 'Active');
        return $this->db->get('coustomerinfo');
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
		function Billinfo($order,$status,$invoiceCheck){
        $this->db->select('delivery.order_id,name,order_detail_id,sum(delivery) as delivery,unit_price,description,quantity,total_price,delivery.id');
        $this->db->from('delivery');
        $this->db->join('order_manage', 'order_manage.detail_id = delivery.order_detail_id');
		$this->db->join('product', 'product.id = order_manage.material');
        $this->db->where('delivery.order_id', $order);
		$this->db->where('delivery.invoice', $invoiceCheck);
        $this->db->where('bill', $status);
		$this->db->group_by('material'); 
		//$this->db->having('sum(delivery)=quantity');
        $query = $this->db->get();
        
        return $query;
    }
	function Bill_report($order,$status,$invoiceCheck){
        $this->db->select('delivery.order_id,name,order_detail_id,sum(delivery) as delivery,unit_price,description,quantity,total_price,delivery.id');
        $this->db->from('delivery');
        $this->db->join('order_manage', 'order_manage.detail_id = delivery.order_detail_id');
		$this->db->join('product', 'product.id = order_manage.material');
        $this->db->where('delivery.order_id', $order);
		$this->db->where('delivery.invoice', $invoiceCheck);
        
		$this->db->group_by('material'); 
		//$this->db->having('sum(delivery)=quantity');
        $query = $this->db->get();
        
        return $query;
    }
	function Bill_report_print($order,$invoiceCheck){
        $this->db->select('submit_date,invoice,CoustomerName,BillingAddresss, challan_no,vat_no,name,order_detail_id,sum(delivery) as delivery,unit_price,description,quantity,total_price,delivery.id');
        $this->db->from('delivery');
        $this->db->join('order_manage', 'order_manage.detail_id = delivery.order_detail_id');
		$this->db->join('coustomerinfo', 'coustomerinfo.CoustomerId = delivery.coustomer_id');
		$this->db->join('product', 'product.id = order_manage.material');
        $this->db->where('delivery.order_id', $order);
		$this->db->where('delivery.invoice', $invoiceCheck);
        $this->db->group_by('material'); 
		//$this->db->group_by('challan_no'); 
		//$this->db->having('sum(delivery)=quantity');
        $query = $this->db->get();
        
        return $query;
    }
	function order_print($order,$invoiceCheck){
        $this->db->select('order_name,challan_no,vat_no');
        $this->db->from('delivery');
        $this->db->join('order', 'order.id = delivery.order_id');
        $this->db->where('delivery.order_id', $order);
		$this->db->where('delivery.invoice', $invoiceCheck);
     
        $query = $this->db->get();
        
        return $query;
    }
	
	function order($ord){
        
        $this->db->where('coustomerid', $ord);
     
        return $this->db->get('order');
         
         
    }

	function remain($ord){
	
	    $this->db->where('order_detail_id', $ord);
		 return $this->db->get('delivery');
		 
      }
	  
	  function product($orderdetail)
	  {
	    

	    $this->db->where('coustomer_id',$orderdetail->coustomerid);
	    $this->db->where('order_id',$orderdetail->order_id);
		$this->db->where('product_id',$orderdetail->detail_id);
		return $this->db->get('product_stock');
	  }
	  function update_product($ord,$status)
	  {
	    

	    $this->db->where('coustomer_id',$ord['coustomer_id']);
	    $this->db->where('order_id',$ord['order_id']);
		$this->db->where('product_id',$ord['order_detail_id']);
		$this->db->set('carton',$status);
		return $this->db->update('product_stock');
	  }
	  function checkbill($ord)
	  {
	    

	    $this->db->where('coustomer_id',$ord['coustomer_id']);
	    $this->db->where('order_id',$ord['order_id']);
		$this->db->where('order_detail_id',$ord['order_detail_id']);
		$this->db->where('bill','bill');
		return $this->db->get('delivery');
	  }
	  function checkbillnew($ord)
	  {
	    
	    $this->db->where('order_id',$ord['order']);
	    $this->db->where('delivery.invoice', $ord['invoiceselect']);   
		$this->db->where('bill','submit');
		return $this->db->get('delivery');
	  }
	function save($ord){
	
	  
	  $this->db->insert('delivery', $ord);
      return $this->db->insert_id();
	  
    }
	 function update($ord,$invoice){
        $this->db->where('order_id', $ord['order']);
		$this->db->where('invoice',$invoice );
		$this->db->set('bill', $ord['bill']);
		$this->db->set('invoice', $ord['invoicetext']);
		$this->db->set('submit_date', $ord['date']);
        $this->db->update('delivery');
    }
    function updatepaid($ord,$invoice){
        $this->db->where('order_id', $ord['order']);
		$this->db->where('invoice',$invoice );
		$this->db->set('bill', $ord['bill']);
		$this->db->set('invoice', $ord['invoiceselect']);
		$this->db->set('paiddate', $ord['date']);
        $this->db->update('delivery');
    }
	function invoiceselect($order,$bill){
	 $this->db->where('order_id', $order);
	 $this->db->where('bill', $bill);
	 $this->db->group_by('invoice');
     return $this->db->get('delivery');
	}
	function invoiceselect_report($order,$bill){
	 $this->db->where('order_id', $order);
	 $this->db->where('bill !=', "bill");
	 $this->db->group_by('invoice');
     return $this->db->get('delivery');
	}
}
	
	
	