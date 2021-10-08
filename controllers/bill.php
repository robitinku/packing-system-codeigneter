<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Bill  extends User_Controller {
   public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
     
		$this->load->model('delivery_model');
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


				case 'invoiceselect':
                $this->invoiceselect();
                break;
				
				
            case 'order':
                $this->order();
                break;
				
			case 'orderdetail':
                $this->orderdetail();
                break;
			case 'save':
                $this->save();
                break;
            case 'checkbill':
                $this->checkbill();
                break;
            default:
                $this->page_not_found();
                break;
        }
    }
     
	  public function checkbill()
    {$order= $this->input->post('data');
	$data=$this->delivery_model->checkbillnew($order)->result();
	if(count($data)>0)
	{
	echo "yes";
	}
	else 
	echo "no";
	}
    public function index()
    {

        $error = null;
        $title = 'Bill Information';
        
       // $config['base_url'] = site_url('attendance/index/');
        $data['coustomer']= $this->delivery_model->coustomer_all()->result();
	   $this->template->write_view('content','billview',array('data'=>$data,'error'=>$error,'title'=>$title));
       $this->template->render();
	  
	  

    }

	public function order()
   {
      $order= $this->input->post('post_data');
	 
	  $data=$this->delivery_model->order($order)->result();
	  print_r($data);
	 
	 
	    echo '<td width="40%">Order:</td> <td> <select onchange="orderinfo()"  id="ord">';  
        foreach($data as $ord)
        echo "<option value='". $ord->id ."'>". $ord->order_name ."</option>";
        echo '</select> </td>'; 
		
	

   }
   
   public function save()
   {
      $order= $this->input->post('data');
	  if($order['bill']=="bill")
	  {
	  $invoice='0';
	  $order['bill']="submit";
	  $this->delivery_model->update($order,$invoice);
	  }
	  else if($order['bill']=="submit")
	  {
	  $invoice=$order['invoiceselect'];
	  $order['bill']="paid";
	  $this->delivery_model->updatepaid($order,$invoice);
	  }
	 // foreach($order as $ord)
      
       //print_r($order);
	  echo "update successfuly";
	  
	  

   }
   public function invoiceselect()
   {
    $bill= $this->input->post('bill');
   $order= $this->input->post('order');
	 
	  $data=$this->delivery_model->invoiceselect($order,$bill)->result(); 
	
	 
	 
	     echo '<select id="invoicedata" onchange="tableview()"> ';
        foreach($data as $ord)
        echo "<option value='". $ord->invoice ."'>". $ord->invoice ."</option>";
        echo '</select> ';  
   
   }
public function orderdetail()
   {
       $ord= $this->input->post('post_data');
	   $sta= $this->input->post('status');
	   $invoiceCheck= $this->input->post('invoiceCheck');
	   //if($sta=='paid')
	   $orderdetails=$this->delivery_model->Billinfo($ord,$sta,$invoiceCheck)->result();
	   //else
	 // $orderdetails=$this->delivery_model->Billinfo($ord,'null')->result();
	 
	      $this->load->library('table');
        $tmpl = array ( 'table_open'  => '<table id="tableupdate" class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No', 'Material', 'Description', 'Unit Price','delivery','Amount');
        $i = 0 ; 
      
        foreach ($orderdetails as $orderdetail){
		  //$total=$orderdetail->delivery*$orderdetail->unit_price;
		   
            $this->table->add_row(++$i,$orderdetail->name,$orderdetail->description,$orderdetail->unit_price,$orderdetail->delivery,$orderdetail->unit_price*$orderdetail->delivery
                   
				 );
            
        }
        $data = $this->table->generate();
 
	  print(json_encode($data)) ; 
	//print_r($orderdetails);
		
	

   }	 
  
}
	?>
