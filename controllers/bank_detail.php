<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class bank_detail  extends User_Controller {

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
             case 'table':
                $this->table();
                break;

            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {
         
        $error = null;
        $title = 'Account Information';
		$uri_segment = 3;
        $bank_id = $this->uri->segment($uri_segment);
         
         $data=$this->tableganarate($bank_id);
         
      
         $this->template->write_view('content','bank_detail_view',array('data'=>$data,'error'=>$error,'title'=>$title));
         $this->template->render(); 
	   
	  
	  

    }

 function tableganarate($bank_id)
 {       
        $bank = $this->database_model->get_by_id($bank_id,"bank_name")->row();
		$bankinfo['info']=' <input type="hidden"  name="bank_id" id="bank_id" size="40" value="'. $bank->id   . '" /><p>Bank Name:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.$bank->bank_name.'</p><p>Branch Name:&nbsp&nbsp&nbsp'.$bank->branchname.'</p><p>Account Name:&nbsp&nbsp'.$bank->account_name.'</p>';
        $bankdetails = $this->database_model->get_by_bank_id($bank_id,"bank_detail")->result();
		$this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");
        $this->table->set_heading('No','Type','Date','Process','Check No','Status','Amount',"");
        $i = 0;
      
        foreach ( $bankdetails as $bankdetail ){
            $this->table->add_row(++$i, $bankdetail ->type, $bankdetail ->date,$bankdetail ->process,$bankdetail ->checkno,$bankdetail ->status, number_format($bankdetail ->amount,2),
             '<input type="hidden" value="'. $bankdetail->id.'" name="id"/> <a href="#" class="btn btn-small btn-warning"> update</a>'
                

            );
        } 
		$bankinfo['table']=$this->table->generate();
        return $bankinfo;
 
 }

 

    public function adddata()
    {
	
    	    $bank =  $this->input->post('bank');
			
           if($bank['process']=="Cash" && $bank['type']=="Deposit")
		   {
		     $account = $this->database_model->accountbalance()->row();
		     $amount=$account->amount-$bank['amount'];    
		    
		  
		   }
		    if($bank['type']=="Withdraw")
		   {
		     $account = $this->database_model->accountbalance()->row();
			 if(($bank['status']!="Cancel" ||$bank['status']!="Pending"))
		       $amount=$account->amount+$bank['amount']; 
              else	
                 $amount=$account->amount;			  
		    }
		   
		   
		   if($bank['process']=="Check" && $bank['type']=="Deposit")
		   {
		      $id = $this->database_model->save($bank,'bank_detail');
              echo "Add Successfully";
		   }
			else if($amount>=0)
		   {
		    $account = array(
		   'date' =>$bank['date'],
		   'amount' =>$amount,
				'head'=>'bank'
		   
		   );
		    
			$this->database_model->accountupdte($account); 
            $id = $this->database_model->save($bank,'bank_detail');
			
             echo "Add Successfully";
           }
		   else echo "Balance not sufficient";		   

      

    }

    public function update()
    {
        $id=$this->input->post('id');
        $bank = $this->database_model->get_by_id($id,'bank_detail')->row();
            $bank = array('id' =>$bank->id,
		   'type' =>$bank->type,
		   'date' =>$bank->date,
		   'amount'=>$bank->amount,
		   'bank_id'=>$bank->bank_id,
		   'checkno'=>$bank->checkno,
		   'process'=>$bank->process,
		   'remark'=>$bank->remark,
		   'status'=>$bank->status,
                   'category'=>$bank->category
		   );
		   
  	    print(json_encode($bank)) ; 
		
       

    }



    public function updatedata()
    {
                   
	          $bank =  $this->input->post('bank');
			
		     if($bank['process']=="Cash" && $bank['type']=="Deposit")
		   {
		      $accup = $this->database_model->get_by_id($bank['id'],'bank_detail')->row();
			  $account = $this->database_model->accountbalance()->row();
		      $amount=$account->amount-($bank['amount']-$accup->amount);
			  
		   
		   }
		     if($bank['type']=="Withdraw")
		   {
		      $accup = $this->database_model->get_by_id($bank['id'],'bank_detail')->row();
			  $account = $this->database_model->accountbalance()->row();
			  if($bank['status']!="Cancel" ||$bank['status']!="Pending")
		      $amount=$account->amount+$bank['amount']-$accup->amount;
			  
		   
		   }
		    if($bank['process']=="Check" && $bank['type']=="Deposit")
		   {
                      
		      $id = $this->database_model->updatedata($bank,'bank_detail');
              echo "Update Successfully";
		   }
			else if($amount>=0)
		   {
		     $account = array(
		        'date' =>$bank['date'],
		        'amount' =>$amount,
				'head'=>'bank'
		        );
			$this->database_model->accountupdte($account);
            $this->database_model->updatedata($bank,'bank_detail');
			echo "Update Successfully"; 
		  }
		  else echo "Balance not sufficient";
    }

   

	


}