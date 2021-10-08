<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Department extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('maintenance_model');
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

            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Department Information';


        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $this->limit=10;
        // load data
        $Departments = $this->maintenance_model->get_paged_list($this->limit, $offset)->result();
      
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('department/index/');
        $config['total_rows'] = $this->maintenance_model->count_all();
		 
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
        $this->table->set_heading('No', 'Department',"Status","");
        $i = 0 + $offset;
      
        foreach ($Departments as $department){
            $this->table->add_row(++$i,$department->department,$department->status,
             '<input type="hidden" value="'.$department->id.'" name="id"/> <a href="#" class="btn btn-small btn-warning"> update</a>'
                

            );
        }
        $data['table'] = $this->table->generate();
        $this->template->write_view('content','departmentview',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
		

    }



 

    public function adddata()
    {
	
    	    $department =  $this->input->post('department');


    
            $id = $this->maintenance_model->save($department);
         
           echo "Add Successfully";
      

    }

    public function update()
    {
        $id=$this->input->post('id');
        $department = $this->maintenance_model->get_by_id($id)->row();
           $department = array('id' =>$department->id,
		   'department' =>$department->department,
		   'status' =>$department->status
		   );
  	    print(json_encode($department)) ;
       

    }



    public function updatedata()
    {
	        //$id=$this->input->post('id');
			$department=$this->input->post('department');
			
            $this->maintenance_model->updatedepartment($department);
			echo "Update Successfully";
    }

   
	


}