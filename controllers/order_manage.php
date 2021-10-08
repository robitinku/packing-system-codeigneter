<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');
class Order_manage extends  User_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
       
        $this->load->library('form_validation');
        $this->load->model('order_model');
       

    }

    function _remap( $method )
    {
  
        // $method contains the second segment of your URI
        switch( $method )
        {
            case 'index':
                $this->index();
                break;


            case 'update':
                $this->update();
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
        $title = 'Order Manage';
        $data="";
      $data['coustomer'] = $this->order_model->get_all()->result();
	 
	   		$data['product']= $this->order_model->product_all()->result();
	   $this->template->write_view('content','order_add',array('data'=>$data,'error'=>$error,'title'=>$title));
       $this->template->render();

    }
	public function update()
   {
   
   $orders=$this->input->post('post_data');
   
    $date=$this->input->post('date');

    $time = strtotime( $date);
    $date= date('y-m-d',$time);
	
	$ordertable = array('coustomerid' => $this->input->post('CoustomerId'),
            'date' =>  $date,
			'order_name' =>$this->input->post('order_name')
			);
  
    $id = $this->order_model->save($ordertable);
    foreach($orders as  $order)
   {
    
    $order['order_id'] = $id;
    $this->order_model->save_detail($order);
   } 
	echo "save successfully";		 
		
   }	
   
   
}
	?>
