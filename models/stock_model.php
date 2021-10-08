<?php
class stock_Model extends CI_Model {
    // table name 
    private $tbl_stock = 'stock';
  function supplier_all(){
	     $this->db->where('status', 'active');
        return $this->db->get('supplier');
      }
 
 
    // get number of persons in database
    function count_all(){
	
        return $this->db->count_all($this->tbl_stock);
    }
    // get persons with paging
    function get_paged_list($limit = 10, $offset = 0){
	$this->db->select('stock.id,stock.catagory,stock.paper_size,stock.paper_type,stock.amount,stock.date,supplier_name,stock.unit_price');
        $this->db->order_by('stock.date','desc');
		 $this->db->join('supplier', 'supplier.id = stock.supplier');
        return $this->db->get($this->tbl_stock, $limit, $offset);
    }
    // get person by id
    function get_by_id($id){

        $this->db->where('id', $id);
        return $this->db->get($this->tbl_stock);
    }
    // add new person
    function save($stock){
	

       $this->db->insert($this->tbl_stock, $stock);
        return $this->db->insert_id();
    }
    // update person by id
    function update($id,  $stock){
        $this->db->where('id', $id);
        $this->db->update($this->tbl_stock,  $stock);
    }
    // delete person by id
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->$tbl_stock);
    }
	 function total_update($total){
        $this->db->where('id', $total->id);
        $this->db->update('total_stock',  $total);
    }
	function catagory_by_stock($stock){
	 
	 if($stock['paper_type']!="" || $stock['paper_type']!=null )
	  { $this->db->where('catagory', $stock['paper_type']);
	    $this->db->where('type', $stock['paper_size']);
	  }
	 else
	 
	 $this->db->where('catagory', $stock['catagory']);
     return $this->db->get('total_stock');
	}
}

?>