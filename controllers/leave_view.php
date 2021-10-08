<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');

class leave_view extends  User_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('attendance_model');
        $this->load->library('form_validation');
	
       

    }

    function _remap( $method )
    {
  
        // $method contains the second segment of your URI
        switch( $method )
        {
            case 'index':
                $this->index();
                break;


            case 'employee':
                $this->employee();
                break;
				
			case 'empinfo':
                $this->empinfo();
                break;
			case 'save':
                $this->save();
                break;
				
            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Leave View Information';
        
       // $config['base_url'] = site_url('attendance/index/');
        $data['department']= $this->attendance_model->department_all()->result();
		
       $this->template->write_view('content','leave_status',array('data'=>$data,'error'=>$error,'title'=>$title));
       $this->template->render();
	  
	   

    }
	public function employee()
   {
     $dep= $this->input->post('post_data');
	 $data['empinfo']=$this->attendance_model->empinfo($dep)->result();
	 
	    echo '<td width="40%">Employee:</td> <td> <select onchange="empinfo()"  id="Emp">';  
        foreach($data['empinfo'] as $emp)
        echo "<option value='". $emp->EmployeeId ."'>". $emp->Name ."</option>";
        echo '</select> </td>';
				

   }	
   
    	public function empinfo()
   {
        $empid= $this->input->post('post_data');
       $leaves=$this->attendance_model->leaveinfo($empid)->result();
	  
	      $this->load->library('table');
        $tmpl = array ( 'table_open'  => '<table class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Employee Name', 'From Date', 'To Date', 'Day',"Note");
        $i = 0 ;
      
        foreach ($leaves as $leave){
            $this->table->add_row(++$i,$leave->Name,$leave->fromdate,$leave->todate,$leave->day,$leave->note
                
            );
        }
        $data = $this->table->generate();
		print(json_encode($data));
	 
   } 
      
}
	?>
