<?php
class Coustomer_Model extends CI_Model {
    // table name 
    private $tbl_coustomerinfo = 'coustomerinfo';
  
 
    // get number of persons in database
    function count_all(){
	
        return $this->db->count_all($this->tbl_coustomerinfo);
    }
    // get persons with paging
    function get_paged_list($limit = 10, $offset = 0){
        $this->db->order_by('CoustomerId','asc');
        return $this->db->get($this->tbl_coustomerinfo, $limit, $offset);
    }
    // get person by id
    function get_by_id($id){

        $this->db->where('CoustomerId', $id);
        return $this->db->get($this->tbl_coustomerinfo);
    }
    // add new person
    function save($Coustomer){
	

       $this->db->insert($this->tbl_coustomerinfo, $Coustomer);
        return $this->db->insert_id();
    }
    // update person by id
    function update($id,  $Coustomer){
        $this->db->where('CoustomerId', $id);
        $this->db->update($this->tbl_coustomerinfo,  $Coustomer);
    }
    // delete person by id
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->$tbl_coustomerinfo);
    }
}

?>