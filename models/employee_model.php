<?php
class Employee_Model extends CI_Model {
    // table name 
    private $tbl_Employeeinfo = 'employee';
  
 function department_all(){
	    
        return $this->db->get('department');
      }
    // get number of persons in database
    function count_all(){
	   $this->db->count_all($this->tbl_Employeeinfo);
	   
        return $this->db->count_all($this->tbl_Employeeinfo);
    }
    // get persons with paging
    function get_paged_list($limit = 10, $offset = 0){
	    $this->db->join('department', 'department.id = employee.Department');
        $this->db->order_by('EmployeeId','asc');
        return $this->db->get($this->tbl_Employeeinfo, $limit, $offset);
    }
    // get person by id
    function get_by_id($id){
        $this->db->join('department', 'department.id = employee.Department');
        $this->db->where('EmployeeId', $id);
        return $this->db->get($this->tbl_Employeeinfo);
    }
    // add new person
    function save($Employee){
	

       $this->db->insert($this->tbl_Employeeinfo, $Employee);
        return $this->db->insert_id();
    }
    // update person by id
    function update($id,  $Employee){
        $this->db->where('EmployeeId', $id);
        $this->db->update($this->tbl_Employeeinfo,  $Employee);
    }
    // delete person by id
    function delete($id){
        $this->db->where('id', $id);
        $this->db->delete($this->$tbl_Employeeinfo);
    }
}

?>