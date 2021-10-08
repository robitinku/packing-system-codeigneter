<?php
class maintenance_model extends CI_Model {




    function get_by_Catgory($id){

        $this->db->where('catagoryid', $id);
        return $this->db->get('maintenance_table');
    }
    function update($id, $meal){
        $this->db->where('id', $id);
        $this->db->update('maintenance_table',$meal);
    }
	 function get_by_Catgoryname($name){

        $this->db->where('catagory', $name);
        return $this->db->get('maintenance_table');
    }
	  function get_paged_list($limit = 10, $offset = 0){
	
        $this->db->order_by('id','asc');
        return $this->db->get('department', $limit, $offset);
    }
	  function count_all(){
	 
        return $this->db->count_all('department');
    }
	  function save($department){
	
       $this->db->insert('department', $department);
        return $this->db->insert_id();
    }
	
	function get_by_id($id){

        $this->db->where('id', $id);
        return $this->db->get('department');
    }
	function updatedepartment($department){
	
	   //$this->db->set('department', $department);
       $this->db->where('id', $department['id']);
       $this->db->update('department',$department);
    }
}

?>
