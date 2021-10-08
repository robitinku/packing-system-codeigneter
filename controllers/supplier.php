<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class supplier  extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('database_model');
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


            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Supplier  Information';


        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $this->limit=10;
        // load data
        $Suppliers = $this->database_model->get_paged_list($this->limit, $offset,'supplier')->result();
      
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('supplier/index/');
        $config['total_rows'] = $this->database_model->count_all('supplier');
		 
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
        $this->table->set_heading('No', 'Supplier','Address','Phone','Status',"");
        $i = 0 + $offset;
      
        foreach ($Suppliers as $Supplier ){
            $this->table->add_row(++$i,$Supplier ->supplier_name,$Supplier ->supplier_address,$Supplier ->phone,$Supplier ->status,
             '<input type="hidden" value="'.$Supplier ->id.'" name="id"/> <a href="#" class="btn btn-small btn-warning"> update</a>'
                

            );
        }
        $data['table'] = $this->table->generate();
         $this->template->write_view('content','supplierview',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
		//$this->load->view('Supplierview', $data);

    }



 

    public function adddata()
    {
	
    	    $Supplier =  $this->input->post('Supplier');

           $id = $this->database_model->save($Supplier,'supplier');
           echo "Add Successfully"; 

      

    }

    public function update()
    {
        $id=$this->input->post('id');
        $supplier = $this->database_model->get_by_id($id,'supplier')->row();
           $supplier = array('id' =>$supplier->id,
		   'supplier_name' =>$supplier->supplier_name,
		   'supplier_address' =>$supplier->supplier_address,
		   'phone' =>$supplier->phone,
		   'status' =>$supplier->status
		   );
  	    print(json_encode($supplier)) ;
       

    }



    public function updatedata()
    {
	          $Supplier =  $this->input->post('Supplier');
			
		
            $this->database_model->updatedata($Supplier,'supplier');
			 echo "Update Successfully"; 
    }



	


}