<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH.'libraries/User_Controller.php');

class Salary extends  User_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('attendance_model');
        $this->load->library('form_validation');
		$this->load->library('Calendar');
        $this->load->model('database_model');

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
        $title = 'Salary Information';
        
       // $config['base_url'] = site_url('attendance/index/');
        $data['department']= $this->attendance_model->department_all()->result();
		$offset=6*60*60; //converting 5 hours to seconds.
	    $dateFormat="F, Y";
	    $timeNdate=gmdate($dateFormat, time()+$offset);
		$temptime=strtotime($timeNdate.' -1 months');
		
	    $newdate=date($dateFormat,$temptime); 
		$datetime=explode(',', $newdate );
		$data['month']=$datetime[0];
	    $data['year']=$datetime[1];
        $this->template->write_view('content','salaryview',array('data'=>$data,'error'=>$error,'title'=>$title));
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
        $offset=6*60*60; //converting 5 hours to seconds.
	    
	    $timeNdate=gmdate('y-m-d', time()+$offset);
		
		$firstdate = strtotime($timeNdate.'first day of last month');
		$firstdate=date('y-m-d',$firstdate); 
		$lastdate = strtotime($timeNdate.'last day of last month');
		$lastdate=date('y-m-d',$lastdate); 
		
		
    $data=$this->attendance_model->emp_get_by_id($empid)->row();
	$timecard=$this->attendance_model->emp_get_by_id_time($empid,$firstdate,$lastdate)->row();
    if($data!=null)
	 {
	echo '<table><tr> <td> personal Id:</td><td>';
	echo  $data->PersonalId;
	echo '</td></tr><tr ><td>Designation:</td><td>';
	echo  $data->Designation;
	//echo '<tr><td></td><td><img src="'.$data->Image .'" width="250px" height="150"/> </td></tr>';
	if($timecard->overtime!=null)
	 $overtime=$timecard->overtime*13.5;
	 else
	 $overtime=0;
	 if($timecard->CHr!=null)
	 $chour=$timecard->CHr*13.5;
	 else
	 $chour=0;

	if($data->Leave >=0)
	{
	echo '<tr><td>Salary: </td><td id="salary">'. $data->Salary.'</td><td>Food: </td><td id="food">'. $timecard->Food.'</td><td>OverTime: </td><td id="overtime">'. $overtime.'</td><td>C-Hour:</td><td id="chour">'. $chour.'</td></tr></table>';
	
    }
	
	else
	{
	  $leave=$this->attendance_model->emp_get_by_id_leave($empid,$firstdate,$lastdate)->row();
	  $salary=($data->Salary/30)*($leave->day);
	  $salary_with_leave= round($data->Salary-$salary, 2);
	  echo   '<tr><td>Salary: </td><td>'. $salary_with_leave.'</td><td>Food: </td><td>'. $timecard->Food.'</td><td>Overtime: </td><td>'.$overtime .'</td><td>C-Hour:</td><td id="chour">'. $chour.'</td></tr></table>';
	   
	}
	//echo '<tr><td>Bonus:</td><td><input type="checkbox" id="check" onchange="bonus()"/><input type="text" readonly="readonly" id="bonus" /></td></tr></table>';
	$offset=6*60*60; //converting 5 hours to seconds.
	    $dateFormat="F, Y";
	    $timeNdate=gmdate($dateFormat, time()+$offset);
		$temptime=strtotime($timeNdate.' -1 months');
		
	    $newdate=date($dateFormat,$temptime); 
		$datetime=explode(',', $newdate );
		$data1['month']=$datetime[0];
	    $data1['year']=$datetime[1];
        
   $check=$this->attendance_model->checksalary($empid,$data1['month'],$data1['year'])->result();
   //print_r($check);
   if(count($check)>0)
   echo ' <tr><td></td><td>Paid</td></tr></table>';
   else
    echo '<tr><td></td><td><input type="button" value="save" id="save" onclick="save()" class="btn btn-primary"/></td></tr></table>';
   }}
   public function save()
   {
   $salary= $this->input->post('salary');
    $offset=6*60*60; //converting 5 hours to seconds.
	    
	$timeNdate=gmdate('y-m-d', time()+$offset);
   $salary['date']=$timeNdate;
    $account = $this->database_model->accountbalance()->row();
	$amount=$account->amount-($salary['salary']+$salary['overtime']);
     $account = array(
		        'date' =>$salary['date'],
		        'amount' =>$amount
		        );	
     if($amount>=0)
    {
	
    $this->database_model->accountupdte($account);
    $this->attendance_model->savesalary($salary);
    echo "Save Successfully";
	}
	 else echo "Balance not sufficient";
	
   }
      
}
	?>
