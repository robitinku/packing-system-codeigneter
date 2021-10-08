<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Attendance extends User_Controller {
   public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('attendance_model');
		$this->load->model('maintenance_model');
        $this->load->library('form_validation');
		$this->load->library('Calendar');
       

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
			case 'intime':
                $this->intime();
                break;
            case 'outtime':
                $this->outtime();
                break;
            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Attendance';
        
       // $config['base_url'] = site_url('attendance/index/');
        $data['department']= $this->attendance_model->department_all()->result();
	    $this->template->write_view('content','attendanceview',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
	  

    }

	public function employee()
   {
     $dep= $this->input->post('post_data');
	 $data['empinfo']=$this->attendance_model->empinfo($dep)->result();
	 
	    echo '<td>Employee:</td> <td> <select onchange="empinfo()"  id="Emp">';  
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
	echo '<tr><td> personal Id:</td><td>';
	echo  $data->PersonalId;
	echo '</td></tr>';
	echo '<tr><td>Designation:</td><td>';
	echo  $data->Designation;
	//echo '</td></tr><tr><td></td><td><img src="'.$data->Image .'" width="150px" height="100"/> </td></tr>';
	
	  $offset=6*60*60; //converting 5 hours to seconds.
	  $dateFormat="y-m-d";
	  $timeNdate=gmdate($dateFormat, time()+$offset);
	  /* $temptime=strtotime($timeNdate);
	  $newdate=date("y-m-d",$temptime); */
	  $count_out = $this->attendance_model->count_all_outcheck($empid)->row();
	  $count = $this->attendance_model->count_all($empid,$timeNdate)->row();
      if($count_out!=null){
	  if($count_out->intime!=null && $count_out->outime==null)
       {
           // echo '<script> $("#area").attr("disabled", "disabled");</script>';
           echo '<tr><td></td><td><input type="button" id="in" value="In"  disabled="disabled" onclick="intime()" class="btn btn-primary"/> &nbsp;&nbsp;&nbsp; <input type="button" value="Out" id="out" onclick="outtime()" class="btn btn-primary"/> </td></tr>';
       }
     }
      

     else if($count!=null){
      if($count->outime!=null && $count->intime!=null )
     {
         // echo '<script> $("#area").attr("disabled", "disabled");</script>';
         echo '<tr><td></td><td><input type="button" id="in" value="In"  disabled="disabled" onclick="intime()" class="btn btn-primary"/> &nbsp;&nbsp;&nbsp; <input type="button" value="Out" id="out" disabled="disabled" onclick="outtime()" class="btn btn-primary"/> </td></tr>';
     }
      else if($count->intime!=null &&$count->outime==null)
       {
           // echo '<script> $("#area").attr("disabled", "disabled");</script>';
           echo '<tr><td></td><td><input type="button" id="in" value="In"  disabled="disabled" onclick="intime()" class="btn btn-primary"/> &nbsp;&nbsp;&nbsp; <input type="button" value="Out" id="out" onclick="outtime()" class="btn btn-primary"/> </td></tr>';
       }
	  }
	  else  
	  {
        // echo '<script> $("#area").removeattr("disabled");</script>';
		 echo '<tr><td>Shift:</td><td><select id="shift" style="width:60px;"> <option value="A">A</option><option value="B">B</option><option value="C">C</option></select></td></tr>';
	     echo '<tr><td></td><td><input type="button" id="in" value="in" onclick="intime()" class="btn btn-primary"/> &nbsp;&nbsp;&nbsp; <input type="button" value="out" disabled="disabled" id="out" onclick="outtime()" class="btn btn-primary"/> </td></tr>';
	  }

	  }
   }
   
      	public function intime()
   {
	  $offset=6*60*60; //converting 5 hours to seconds.
	  $dateFormat="d-m-y H:i";
	  $timeNdate=gmdate($dateFormat, time()+$offset);
	  $datetime=explode(' ', $timeNdate );
	  $temptime=strtotime($timeNdate);
	  $newdate=date("d-m-y",$temptime);
	
	  
	  $attendancetime = array('employeeid' => $this->input->post('empid'), 
            'date' => $newdate,
            'intime' => $datetime[1],
			'shift'=>$this->input->post('shift')
           
        );
		$id = $this->attendance_model->save($attendancetime);

   }

    public function outtime()
    {

        $offset=6*60*60; //converting 5 hours to seconds.
        $dateFormat="d-m-y H:i";
       // date_default_timezone_set('Asia/Dhaka');
        $timeNdate=gmdate($dateFormat, time()+$offset);
        $outtime=explode(' ', $timeNdate );
        $temptime=strtotime($timeNdate);
        $newdate=date("d-m-y",$temptime);
		$emp=$this->input->post('empid');
        $count = $this->attendance_model->count_all_outtime($emp)->row();
        $attendancetime = array('employeeid' =>$emp ,
            //'date' => $newdate,
			'intime' =>$count->intime,
            'outime' => $outtime[1]

        );
         $casulastaftimecard=$this->timecard($count->intime,$outtime[1],$count->shift);
         $casulastaftimecard['Date']=$count->date;
		 $casulastaftimecard['EmployeeId']=$emp;
		  $casulastaftimecard['attendance_id']=  $count->id;
		// print_r($casulastaftimecard);
		 $this->attendance_model->savetimecard($casulastaftimecard);

        $this->attendance_model->updateouttime($attendancetime);

    }
	
	function timecard($intime,$outtime,$shift)
	{
		 	/* $shiftA = $this->maintenance_model->get_by_Catgoryname("shift A")->row();
			$shiftB = $this->maintenance_model->get_by_Catgoryname("shift B")->row();
			$shiftC = $this->maintenance_model->get_by_Catgoryname("shift C")->row();
			
			if(strtotime($shiftA->inrange)<strtotime($intime) && strtotime($shiftA->outrange)>=strtotime($intime) )
			$shift= "A";
			if(strtotime($shiftB->inrange)<strtotime($intime) && strtotime($shiftB->outrange)>=strtotime($intime) )
			$shift= "B";
			if(strtotime($shiftC->inrange)<strtotime($intime) && strtotime($shiftC->outrange)>=strtotime($intime)  && strtotime($intime)>strtotime($outtime) )
			$shift= "C"; */
			
			
			if($shift=="C")
			$cr=2;
			else
			$cr=0;
			
			if($shift=="C")
			{
			$inhour=explode(":",$intime);
			$outhour=explode(":",$outtime);
            
			$workinghour= 24-$inhour[0]+$outhour[0]+$cr;
			

			}
			else
			{
			$inhour=explode(":",$intime);
			$outhour=explode(":",$outtime);

			$workinghour=$outhour[0]-$inhour[0]+$cr;

			}
			if($workinghour>9)
			$overtime=$workinghour-9;
			else
			$overtime=null;
			$food=0;
			$snackvalue = $this->maintenance_model->get_by_Catgoryname("snack")->row();
			if($intime>0)
			{
			$snack=1;
			$food=$food+$snackvalue->value;
			}			
			else
			$snack=0;
			
			$lunch = $this->maintenance_model->get_by_Catgoryname("Lunch")->row();
			if(strtotime($lunch->inrange)>strtotime($intime) && strtotime($lunch->outrange<strtotime($outtime) ))
			{
			$lunch=1;
			$food=$food+$lunch->value;
			}
			else
			$lunch=0;
			
			$Dinner = $this->maintenance_model->get_by_Catgoryname("Dinner")->row();
			if(strtotime($Dinner->inrange)>strtotime($intime) && strtotime($Dinner->outrange<strtotime($outtime) ))
			{$dinner=1;
			$food=$food+$Dinner->value;
			}
			
			else
			$dinner=0;
			
			$lDinner = $this->maintenance_model->get_by_Catgoryname("L.dinner")->row();
			//if(strtotime($lDinner->inrange)>strtotime($intime) && strtotime($lDinner->outrange<strtotime($outtime) ))
			if($shift=="C")
			{
			$food=$food+$lDinner->value;
			$ldinner=1;
			}
			else
			$ldinner=0;
			
            $cshiftpay=0;
			if($shift=="C")
			$cshiftpay=13.5*2;
			
          $total=$cshiftpay+$food;
          $casulastaftimecard=array('Date'=>null,
		  'EmployeeId'=>null,
		  'Shift'=>$shift,
		  'InTime'=>$intime,
		  'OutTime'=>$outtime,
		  'WorkingHour'=>$workinghour,
		  'CHr'=>$cr,
		  'Snaks'=>$snack,
		  'Lunch'=>$lunch,
		  'Dinner'=>$dinner,
		  'LDinner'=>$ldinner,
		  'Food'=>$food,
		  'CShiftPay'=>$cshiftpay,
		  'Total'=>$total,
		  'overtime'=>$overtime
		  );
		  
		  return $casulastaftimecard;
			
			
			
	}
}
	?>
