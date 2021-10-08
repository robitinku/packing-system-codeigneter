<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class Costing extends User_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->model('maintenance_model');

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

          
            default:
                $this->page_not_found();
                break;
        }
    }

    public function index()
    {

        $error = null;
        $title = 'Costing Information';
        $data="";
        $this->template->write_view('content','costing_view',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
       

    }

   

 

  
    public function update()
    {

        $carton = $this->input->post('carton');
		$length = $this->input->post('length');
		$width = $this->input->post('width');
		$height = $this->input->post('height');
		$ply = $this->input->post('ply');
		$lin = $this->input->post('lin');
		$Size = $this->input->post('Size');
		$rollsize = $this->input->post('rollsize');
		$sales = $this->input->post('sales');
		$number = $this->input->post('number');
		$board = $this->input->post('board');
	 	$lineunit = $this->maintenance_model->get_by_Catgoryname("Line unit")->row();
		
		$crogated = $this->maintenance_model->get_by_Catgoryname("Crogated")->row();
		$straight = $this->maintenance_model->get_by_Catgoryname("Straight")->row();
		$wastagewid = $this->maintenance_model->get_by_Catgoryname("wastage wid")->row();
		$wastagelen = $this->maintenance_model->get_by_Catgoryname("wastage len")->row();
		$linerprice = $this->maintenance_model->get_by_Catgoryname("liner price")->row();
		$mideumpric = $this->maintenance_model->get_by_Catgoryname("mideum pric")->row();
		$gumcili = $this->maintenance_model->get_by_Catgoryname("gum & cili price")->row();
		if( $this->input->post('Size')=='CM')
		$Dim = (2*($length+$width+$wastagewid->value )/2.54);
		else
		$Dim = (2*($length+$width+$wastagewid->value));
		echo "<tr><td>Dim</td><td>".number_format($Dim,2)."</td>/tr>";
		
		$NumberofLiner = $lin;
		if( ($ply+$lin)==4 || ($ply+$lin)==5)
		$NoofcorogatedLayer = 1;
		 else if( ($ply+$lin)==6 || ($ply+$lin)==7)
		$NoofcorogatedLayer = 2;
		else if( ($ply+$lin)==8 || ($ply+$lin)==9)
		$NoofcorogatedLayer = 3;
		
		echo "<tr><td>No of corogated Layer</td><td>".number_format($NoofcorogatedLayer,2)."</td>/tr>";
		
		if( ($ply+$lin)==4)
		$noofstraightlayer =1; 
		else if( ($ply+$lin)==5)
		$noofstraightlayer =0;
		else if( ($ply+$lin)==8)
		$noofstraightlayer =3;
		else if( ($ply+$lin)==7)
		$noofstraightlayer =1;
		else if( ($ply+$lin)==6 || ($ply+$Lin)==9)
		$noofstraightlayer =2;
		
		echo "<tr><td>No of straight layer</td><td>".number_format($noofstraightlayer,2)."</td>/tr>";
        
		$usage_of_Lin_per_unit_in_kg= (((number_format($Dim,2)*$rollsize*$lineunit->value*$lin))/1560000)/$number; 
		echo "<tr><td>Usage of Lin per unit in kg</td><td>".number_format($usage_of_Lin_per_unit_in_kg,2)."</td>/tr>";
		$usage_of_Mideum_per_Unit_in_Kg=( $NoofcorogatedLayer *$crogated->value)+($noofstraightlayer*$straight->value);
               
		$usage_of_Mideum_per_Unit_in_Kg=(($usage_of_Mideum_per_Unit_in_Kg*number_format($Dim,2)*$rollsize)/1560000)/$number;
		echo "<tr><td>Usage of Mideum per Unit in Kg</td><td>".number_format($usage_of_Mideum_per_Unit_in_Kg,2)."</td>/tr>";
		
		$usage_Per_Unit_of_Liner_in_kg=number_format($usage_of_Lin_per_unit_in_kg,2) +number_format($usage_of_Mideum_per_Unit_in_Kg,2);
		echo "<tr><td>Usage Per Unit of Liner in kg</td><td>".number_format($usage_Per_Unit_of_Liner_in_kg,2)."</td>/tr>";
		$totalusage=  $carton*number_format($usage_Per_Unit_of_Liner_in_kg,2);
		echo "<tr><td>Total usage</td><td>".number_format($totalusage,2)."</td>/tr>";
		$price_per_unit_of_Linr_in_taka=number_format($usage_of_Lin_per_unit_in_kg,2)*$linerprice->value;
		echo "<tr><td>Price per unit of Linr in taka</td><td>".number_format($price_per_unit_of_Linr_in_taka,2)."</td>/tr>";
		$price_per_unit_of_Midium_in_taka= 	number_format($usage_of_Mideum_per_Unit_in_Kg,2)*$mideumpric->value;
		echo "<tr><td>Price per unit of Midium in taka</td><td>".number_format($price_per_unit_of_Midium_in_taka,2)."</td>/tr>";
		
		$total_Cost_Liner_in_taka=number_format($price_per_unit_of_Linr_in_taka,2)*$carton;
		echo "<tr><td>Total Cost Liner in taka</td><td>".number_format($total_Cost_Liner_in_taka,2)."</td>/tr>";
		$total_Cost_of_Midum_in_taka=number_format($price_per_unit_of_Midium_in_taka,2)*$carton;
		echo "<tr><td>Total Cost of Midum in taka</td><td>".number_format($total_Cost_of_Midum_in_taka,2)."</td>/tr>";
		$SUB_Total_of_Cost=$total_Cost_Liner_in_taka+$total_Cost_of_Midum_in_taka;
                
		echo "<tr><td>SUB Total of Cost</td><td>".number_format($SUB_Total_of_Cost,2)."</td>/tr>";
		$Over_Head_and_Others_Cost=$SUB_Total_of_Cost*$gumcili->value;
		echo "<tr><td>Over Head and Others Cost</td><td>".number_format($Over_Head_and_Others_Cost,2)."</td>/tr>";
		$Grand_Total_Cost_of_Goods=$SUB_Total_of_Cost+$Over_Head_and_Others_Cost;
		echo "<tr><td>Grand Total Cost of Goods</td><td>".number_format($Grand_Total_Cost_of_Goods,2)."</td>/tr>";
		$SalesRevenue=$sales*$carton;
		echo "<tr><td>Sales Revenue</td><td>".number_format($SalesRevenue,2)."</td>/tr>";
		$Profit=$SalesRevenue-$Grand_Total_Cost_of_Goods;
		echo "<tr><td>Profit</td><td>".number_format($Profit,2)."</td>/tr>";  
	    if($board=="true")
		{
		
		$Board= $this->maintenance_model->get_by_Catgoryname("board")->row();
		$boarduse= ($Dim*($rollsize/$number)*$Board->value)/1560000;
		echo "<tr><td>Board</td><td>".number_format($boarduse,2)."</td>/tr>";
		
		}
        //echo  $sales;
    

    }



   
	
	 
	
	
	


}