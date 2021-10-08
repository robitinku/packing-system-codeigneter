<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/User_Controller.php');

class meal_schedule extends User_Controller {

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
        $title = 'Meal Information';
        $uri_segment = 3;
        $catagoryid = $this->uri->segment($uri_segment);


        $meals = $this->maintenance_model->get_by_Catgory($catagoryid)->result();




        // generate table data
        $this->load->library('table');
        $tmpl = array ( 'table_open'  => '<table class="table table-bordered">' );
        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        if($catagoryid==1){
            $this->table->set_heading('No', 'Category', 'Value', 'In-Range', 'Out-Range',"Action");
            $i = 0;

            foreach ($meals as $meal){

                $intime=explode(":",$meal->inrange);
                $outtime=explode(":",$meal->outrange);
                $this->table->add_row(++$i,$meal->catagory,'<input type="text" class="input-small" name="value" value="'.$meal->value.'"/>',
                    '<input type="text" disabled class="spinnerhour input-small" name="inhour" value="'.$intime[0].'"/> <input type="text" disabled class="spinnermin input-small" name="inmin" value="'.$intime[1].'"/>',
                    '<input type="text" disabled class="spinnerhour input-small" name="outhour" value="'.$outtime[0].'"/> <input type="text" disabled  class="spinnermin input-small" name="outmin" value="'.$outtime[1].'"/>',

                    '<input type="hidden" name="id" value="'.$meal->id.'"/> <a class="btn btn-small btn-warning" href="#">update </a>'

                );
            }
            $data['table'] = $this->table->generate();

            $this->template->write_view('content','meal_view',array('data'=>$data,'error'=>$error,'title'=>$title));
            $this->template->render();
        }
        else  if($catagoryid==3)
        {
            $this->table->set_heading('No', 'catagory', 'value',"");
            $i = 0;

            foreach ($meals as $meal){
              
                $this->table->add_row(++$i,$meal->catagory,'<input type="text" name="value" value="'.$meal->value.'"/>',

                    '<input type="hidden" name="id" value="'.$meal->id.'"/> <a class="btn btn-small btn-warning" href="#">update </a>'

                );

            }

            $data['table'] = $this->table->generate();

            $this->template->write_view('content','cost_view',array('data'=>$data,'error'=>$error,'title'=>$title));
            $this->template->render();
        }

        else  if($catagoryid==2)
        {
            $this->table->set_heading('No', 'catagory', 'inrange', 'outrange',"");
            $i = 0;

            foreach ($meals as $meal){

                $intime=explode(":",$meal->inrange);
                $outtime=explode(":",$meal->outrange);
                $this->table->add_row(++$i,$meal->catagory,'<input type="text" disabled class="spinnerhour" name="inhour" value="'.$intime[0].'"/> <input type="text" disabled class="spinnermin" name="inmin" value="'.$intime[1].'"/>','<input type="text" disabled class="spinnerhour" name="outhour" value="'.$outtime[0].'"/><input type="text" disabled  class="spinnermin" name="outmin" value="'.$outtime[1].'"/>',

                    '<input type="hidden" name="id" value="'.$meal->id.'"/> <a class="update" href="#">update </a>'

                );
				}
                $data['table'] = $this->table->generate();

                $this->template->write_view('content','shift_view',array('data'=>$data,'error'=>$error,'title'=>$title));
                $this->template->render();
            
        }

    }







    public function update()
    {

        $id = $this->input->post('id');

        $intime[0] =$this->input->post('inhour');
        $intime[1] =$this->input->post('inmin');
        $timein=implode(":", $intime);

        $outtime[0] =$this->input->post('outhour');
        $outtime[1] =$this->input->post('outmin');
        $timeout=implode(":", $outtime);

        $meal=array('value' => $this->input->post('value'),
            'inrange' => $timein,
            'outrange' => $timeout
        );

        $this->maintenance_model->update($id,$meal);
        echo  'Information Updated Successfully.';


    }




}

   
	
	 
	
	
	


