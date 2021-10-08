<?php
class Attendance_Model extends CI_Model {
    // table name 
  
  
 
    // get number of persons in database
    function department_all(){
	    $this->db->where('status', 'active');
        return $this->db->get('department');
      }
	   
	function empinfo($dep){
        $this->db->where('Department', $dep);
		$this->db->where('active', 'Active');
        return $this->db->get('employee');
    }

	function emp_get_by_id($id){
        $this->db->where('EmployeeId', $id);

        return $this->db->get('employee');
    }
	
	function save($attendancetime){
	
	  
	  $this->db->insert('attendance_time', $attendancetime);
      return $this->db->insert_id();
	  
    }
	
	function savetimecard($casulastaftimecard){
	
	  
	  $this->db->insert('casulastaftimecard', $casulastaftimecard);
      return $this->db->insert_id();
	  
    }
	function saveleave($leave,$emp_leave_pos){
	
	  
	  
	  /////update employee leave/////
	  
	    $this->db->set("Leave",$emp_leave_pos);
        

        $this->db->where('EmployeeId', $leave['employeeid']);

        $this->db->update('employee');
		$this->db->insert('leave', $leave);
       return $this->db->insert_id();
	  
	  
    }
	
	 function count_all_outcheck($empid){

	    $this->db->where('outime',null);

         $this->db->where('employeeid', $empid);
        // $this->db->from('attendance_time');
         //return $this->db->count_all_results();
         return $this->db->get('attendance_time');

    }
	 function count_all($empid,$temptime){

	    $this->db->where('date',$temptime);

         $this->db->where('employeeid', $empid);
        // $this->db->from('attendance_time');
         //return $this->db->count_all_results();
         return $this->db->get('attendance_time');

    }

	function count_all_outtime($empid){

	    $this->db->where('outime',null);

         $this->db->where('employeeid', $empid);
        // $this->db->from('attendance_time');
         //return $this->db->count_all_results();
         return $this->db->get('attendance_time');

    }

    function attendanceview($attendancetime){


        $this->db->insert('attendance_time', $attendancetime);
        return $this->db->insert_id();

    }

    function get_by_id($id){
        $this->db->select('*');
        $this->db->from('attendance_time');
        $this->db->join('employee', 'employee.EmployeeId = attendance_time.employeeid');
        $this->db->where('id', $id);

        $query = $this->db->get();

        return $query;
        //return $this->db->get($this->tbl_coustomerinfo);
    }

    function attendance_list($date){

        $this->db->select('employee.Name,department.department,employee.Designation,employee.PersonalId,attendance_time.intime,attendance_time.outime,
                           attendance_time.shift,attendance_time.id');
        $this->db->from('attendance_time');
        $this->db->join('employee', 'employee.EmployeeId = attendance_time.employeeid');
		$this->db->join('department', 'department.id = employee.Department');
        $this->db->where('date', $date);
       // $this->db->limit(2);
        $query = $this->db->get();

        return $query;


    }
	function attendance_list_timecard($date){

        $this->db->select('*');
		$this->db->from('casulastaftimecard');
        $this->db->join('attendance_time', 'attendance_time.id = casulastaftimecard.attendance_id');
        $this->db->join('employee', 'employee.EmployeeId = attendance_time.employeeid');
		$this->db->join('department', 'department.id = employee.Department');
        $this->db->where('casulastaftimecard.Date', $date);
       // $this->db->limit(2);
        $query = $this->db->get();

        return $query;


    }
	
	    function updatetimecard( $casulastaftimecard){

        
        $this->db->where('attendance_id', $casulastaftimecard['attendance_id']);

        return $this->db->update('casulastaftimecard',$casulastaftimecard);
    }

    function update( $attendancetime){

        $this->db->set("outime", $attendancetime['outtime']);
		 
       $this->db->set("intime", $attendancetime['intime']);
        $this->db->set("shift", $attendancetime['shift']);
        $this->db->where('id', $attendancetime['id']);

        return $this->db->update('attendance_time');
    }
    function updateouttime( $attendancetime){

        $this->db->set("outime", $attendancetime['outime']);
		 
       $this->db->set("intime", $attendancetime['intime']);

        $this->db->where('employeeid', $attendancetime['employeeid']);
		 $this->db->where('outime',null);

        return $this->db->update('attendance_time');
    }
	function emp_get_by_id_time($id,$firstdate,$lastdate){
		$this->db->select_sum('Food');
		$this->db->select_sum('CHr');
		$this->db->select_sum('overtime');
        $this->db->where('employeeid', $id);
		$this->db->where('Date >=', $firstdate); 
		$this->db->where('Date <=', $lastdate);
        return $this->db->get('casulastaftimecard');
    }
	
	function savesalary($salary){
	
	  
	  $this->db->insert('salary', $salary);
      return $this->db->insert_id();
	  
    }
	function checksalary($empid,$month,$year){
	
	  $this->db->where('employee_id', $empid);
		$this->db->where('month', $month); 
		$this->db->where('year', $year);
       
     return $this->db->get('salary');
	  
    }
	function emp_get_by_id_leave($id,$firstdate,$lastdate){
	    $this->db->select_sum('day');
        $this->db->where('employeeid', $id);
		$this->db->where('fromdate >=', $firstdate); 
		$this->db->where('fromdate <=', $lastdate);
        return $this->db->get('leave');
	}
function leaveinfo($empid)
	{   $this->db->select('*');
		$this->db->from('leave');
	    $this->db->join('employee', 'employee.EmployeeId = leave.employeeid');
		
        $this->db->where('leave.employeeid', $empid);
     
         $query = $this->db->get(); 
	     
		 return  $query;
	}

}
?>
