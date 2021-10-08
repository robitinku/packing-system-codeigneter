<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Usermanagement extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('User_model');
        $this->load->model('attendance_model');
	
       
    }

    function _remap( $method )
    {
	
	if($this->session->userdata('sess_category'))
   {
     $session_data = $this->session->userdata('sess_category');
     if($session_data['user_category']!='super')
      $method="";
   }
          
        // $method contains the second segment of your URI
        switch( $method )
        {
            case 'index':
                $this->index();
                break;


            case 'add':
                $this->add();
                break;
            case 'adddata':
                $this->adddata();
                break;

            case 'update':
                $this->update();
                break;

            case 'updatedata':
                $this->updatedata();
                break;

            case 'view':
                $this->view();
                break;
			case 'empinfo':
                $this->empinfo();
                break;


            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {
        $error = null;
        $title = 'User Information';


        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $this->limit=10;
        // load data
        $Employees = $this->User_model->get_paged_list($this->limit, $offset)->result();
      
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('Usermanagement/index/');
        $config['total_rows'] = $this->User_model->count_all();
		 
        $config['per_page'] = $this->limit;
        $config['uri_segment'] = $uri_segment;

        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // generate table data
        $this->load->library('table');
        $tmpl = array ( 'table_open'  => '<table class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'username', 'Name', 'Designation','status',"Action");
        $i = 0 + $offset;
      
        foreach ($Employees as $Employee){
            $this->table->add_row(++$i,$Employee->email,$Employee->Name,$Employee->Designation,$Employee->status,
                anchor('usermanagement/update/'.$Employee->user_id,'Update',array('class'=>'btn btn-small btn-warning'))
            );
        }
        $data['table'] = $this->table->generate();
        $this->template->write_view('content','userlist',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

        
    }

    public function add()
    {
         $error = null;
        $title = 'Add User';
                $data['link_back'] = anchor('usermanagement/index/','Back to User',array('class'=>'back'));

       // $config['base_url'] = site_url('attendance/index/');
        $data['department']= $this->attendance_model->department_all()->result();
	    $this->template->write_view('content','adduser',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
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
	
		}
	}

    public function adddata()
    {
	
        $user=$this->input->post('params');
		$result=$this->User_model->check_user($user);
		if($result>0)
		echo "User Name already exist";
		else
		{
		$user['passwd'] = md5($user['passwd']);
		$this->User_model->save($user);
		echo "Add User Successfully";
		}
       //print_r($result);


    }

    public function update()
    {

        $id = $this->uri->segment(3);
        $data['message'] ='';
        $error = null;
        $title = 'Edit User Information';
        $data['name'] = '';
		 $User = $this->User_model->get_by_id($id)->row();
		 
		 $data['user']=$User->status;
		 $data['user_id']=$User->user_id;
		 
        $data['action'] = site_url('usermanagement/updatedata');
        $data['link_back'] = anchor('usermanagement/index/','Back to User',array('class'=>'back'));


       
        $this->template->write_view('content','edituser',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();

    }

public function updatedata()
    {
	
        $user=$this->input->post('params');
		$user['curPassword'] = md5($user['curPassword']);
		$status=$this->User_model->check_password($user);
		if($status==false)
		echo "Current Password Not Correct";
		else
		{
		$user['passwd'] = md5($user['passwd']);
		$this->User_model->update($user);
		echo "Edit User Successfully";
		}
		//echo "hh";
       //print_r($result);


    }


}