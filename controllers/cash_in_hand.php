<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class cash_in_hand  extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('database_model');
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


            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Cash In Hand Information';


        // offset
        $uri_segment = 3;
        $offset = $this->uri->segment($uri_segment);
        $this->limit=10;
        // load data
        $cihs = $this->database_model->get_paged_list($this->limit, $offset,'cash_in_hand')->result();
      
        // generate pagination
        $this->load->library('pagination');
        $config['base_url'] = site_url('cash_in_hand/index/');
        $config['total_rows'] = $this->database_model->count_all('cash_in_hand');
		 
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
        $account = $this->database_model->accountbalance()->row();
		if($account==null)
		$data['account']=0;
		else
		$data['account']=$account->amount;
        // generate table data
        $this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Date','Amount',"");
        $i = 0 + $offset;
      
        foreach ($cihs as $chi ){
            $this->table->add_row(++$i,$chi->date,$chi ->amount,
             '<input type="hidden" value="'.$chi->id.'" name="id"/> <a href="#" class="btn btn-small btn-warning"> update</a>'
                

            );
        }
        $data['table'] = $this->table->generate();
         $this->template->write_view('content','cash_in_hand_view',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
		//$this->load->view('cash_in_hand_view', $data);

    }



 

    public function adddata()
    {
	
    	   $cih =  $this->input->post('cih');
           $account = $this->database_model->accountbalance()->row();
		   $amount=$account->amount+$cih['amount']; 
		   $account = array(
		   'date' =>$cih['date'],
		   'amount' =>$amount,
			'head'=>'cash'
		   
		   );
		   $this->database_model->accountupdte($account);
           $id = $this->database_model->save($cih,'cash_in_hand');
           echo "Add Successfully"; 

      

    }

    public function update()
    {
        $id=$this->input->post('id');
        $cih = $this->database_model->get_by_id($id,'cash_in_hand')->row();
           $cih = array('id' =>$cih->id,
		   'date' =>$cih->date,
		   'amount' =>$cih->amount,
		   'remark' =>$cih->remark
		   );
  	    print(json_encode($cih)) ;
       

    }



    public function updatedata()
    {
	          $chi =  $this->input->post('cih');
			  $accup = $this->database_model->get_by_id($chi['id'],'cash_in_hand')->row();
			  $account = $this->database_model->accountbalance()->row();
		      $amount=$account->amount+$chi['amount']-$accup->amount;
			  $account = array(
		         'date' =>$chi['date'],
		         'amount' =>$amount,
				'head'=>'cash'
		   
		         );
			  $this->database_model->accountupdte($account);
              $this->database_model->updatedata($chi,'cash_in_hand');
			 echo "Update Successfully"; 
    }



	


}