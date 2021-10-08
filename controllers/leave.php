<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Leave extends User_Controller {
   public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('attendance_model');
		$this->load->model('Employee_model');
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
			case 'leaveadd':
                $this->leaveadd();
                break;
            
            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Leave';
        
       // $config['base_url'] = site_url('attendance/index/');
        $data['department']= $this->attendance_model->department_all()->result();
	    $this->template->write_view('content','leaveview',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
	  

    }

	public function employee()
   {
     $dep= $this->input->post('post_data');
	 $data['empinfo']=$this->attendance_model->empinfo($dep)->result();
	 
	    echo '<td >Employee:</td> <td style="padding-left:20px;"> <select onchange="empinfo()"  id="Emp">';  
        foreach($data['empinfo'] as $emp)
        echo "<option value='". $emp->EmployeeId ."'>". $emp->Name ."</option>";
        echo '</select> </td>';
				

   }	
   
   	public function empinfo()
   {
    $empid= $this->input->post('post_data');

    $data=$this->attendance_model->emp_get_by_id($empid)->row();
	if($data!=null)
	{
	echo '<tr><td> Personal Id:</td><td>';
	echo  $data->PersonalId;
	echo '</td></tr>';
	echo '<tr><td>Designation:</td><td>';
	echo  $data->Designation;
	//echo '</td></tr><tr><td></td><td><img src="'.$data->Image .'" width="150px" height="100"/> </td></tr>';
	echo '<tr><td>Leave Available:</td><td><input  type="text"  value="'.$data->Leave.'" readonly="readonly"/></td></tr>';
	echo '<tr><td>From Date:</td><td><input type="text" id="fromdate"  readonly="readonly" /> </td> <td>&nbsp&nbspTo Date: &nbsp</td><td><input type="text" onclick="time()" id="todate" readonly="readonly"/> </td></tr>';
	echo '<tr><td>Days</td><td><input  type="text" name="Days" id="days"/></td></tr>';
    echo '<tr><td>Note</td><td><textarea  name="Notes" id="note" rows="6" cols="30"></textarea></td></tr>';
	echo '<tr><td></td><td><input type="button" id="in" value="Leave" onclick="intime()" class="btn btn-primary"/> </td></tr>';
	  }

   }
   
      	public function leaveadd()
   {
	  
	  $temptime=strtotime($this->input->post('fromdate'));
	  
	  
	  $fromdate=date("y-m-d",$temptime);
	  
	  $temptime=strtotime($this->input->post('todate'));
	  $todate=date("y-m-d",$temptime);
	  $day=$this->input->post('day');
	  $id=$this->input->post('empid');
	  $leave = array('employeeid' =>$id, 
            'fromdate' => $fromdate,
            'todate' => $todate,
			'day' =>$day,
			'note' =>$this->input->post('note')
           
        );
		$Employee = $this->Employee_model->get_by_id($id)->row();
		$emp_leave_pos=$Employee->Leave- $day;
		$id = $this->attendance_model->saveleave($leave,$emp_leave_pos);
        echo "Add Leave Information Successfully";
   }


}
	?>
