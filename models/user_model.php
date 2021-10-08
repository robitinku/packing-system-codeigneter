<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User_model extends CI_Model{

	protected $errors;

	function __construct(){
		parent::__construct();
		$this->load->database();
	}
function get_paged_list($limit = 10, $offset = 0){
	    $this->db->join('employee', 'employee.EmployeeId = user_informations.emp_id');
        
        return $this->db->get('user_informations', $limit, $offset);
    }
function count_all(){
	   $this->db->count_all('user_informations');
	   
        return $this->db->count_all('user_informations');
    }

    function check_user($user){
	   $this->db->where('email', $user['email']);
	   
        return $this->db->count_all_results('user_informations');
    }
	function get_by_id($id){
        
        $this->db->where('user_id', $id);
        return $this->db->get('user_informations');
    }
    public function checkActivateID($activation_id)
    {
        $status = false;
        $query = $this->db->get_where('user_informations', array('activating_code' => $activation_id));
        if($query->num_rows() > 0)
            $status = true;
        return $status;
    }

    public function activate($activation_id)
    {
        $result = $this->db->simple_query("UPDATE `user_informations` SET `balance` = 10 WHERE `user_informations`.`activating_code` = '".$activation_id."';");

        $status = false;
        $data = array(
            'is_active' => 1,
            'activating_code' => ''
        );

        $this->db->where('activating_code', $activation_id);
        $this->db->update('user_informations', $data);


        //echo $this->db->last_query();
        //die();
        if($this->db->update('user_informations', $data))
            $status = true;
        return $status;
    }
    function save($user){
	

       $this->db->insert('user_informations', $user);
        return $this->db->insert_id();
    }


    

    public function checkParentIsExists($parent_email)
    {
        $status = false;
        $query = $this->db->get_where('user_informations', array('email' => $parent_email));
        //echo $this->db->last_query();
        if($query->num_rows() > 0)
            $status = true;
        return $status;
    }

    public function login_check($data)
    {
        $status = false;
        $conditional_array = array(
            'email' => $data['email'],
            'passwd' => md5($data['passwd']),
			'status'=>'Active'
            
        );
        $query = $this->db->get_where('user_informations', $conditional_array);
        if($query->num_rows() > 0)
        {
            $result = $query->result_array();
            $this->session->set_userdata('user_info', $result[0]);
            $status = true;
        }

        return $status;
    }

    public function getUserInfo($user_id)
    {
        $this->db->join('employee', 'employee.EmployeeId = user_informations.emp_id');
        $this->db->where('user_id',$user_id);
        
        return $this->db->get('user_informations');
        
    }

    function update($user){
        $this->db->where('user_id', $user['user_id']);
		$this->db->set('status',$user['status']);
		$this->db->set('passwd',$user['passwd']);
        $this->db->update('user_informations');
    }



    
    public function check_password($user)
    {
        $status = false;
        
        
        
        $this->db->where('user_id',$user['user_id']);

        $this->db->where('passwd',$user['curPassword']);
	   
        $query = $this->db->count_all_results('user_informations');
        if($query > 0)
        {
            $status = true;
        }

        return $status;
    }

    public function change_password($password, $user_id)
    {
        $status = false;
        $params = array(
            'passwd' => md5($password)
        );
        $this->db->where('user_id', $user_id);
        if($this->db->update('user_informations', $params))
            $status = true;
        return $status;
    }

}



