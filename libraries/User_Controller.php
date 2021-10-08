<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User_Controller extends CI_Controller {

    public function __construct(){
		parent::__construct();
        $user_info = $this->session->userdata('user_info');
        if(empty($user_info))
        {
            $msg = array(
                'status' => false,
                'class' => 'errormsgbox',
                'msg' => 'To access this page please login.'
            );

            $data = json_encode($msg);

            $this->session->set_flashdata('msg', $data);
            redirect('/login');
        }
        $this->template->set_template('user');
        //$template['active_template'] = 'user';
		$this->set_temlates();
    }
	
	public function set_temlates(){
        $user_info = $this->session->userdata('user_info');
        $user_id = $user_info['user_id'];
        $this->load->model('user_model');
        $User = $this->user_model->getUserInfo($user_id)->row();
		$data['user_info']=$User->Name;
		$data['category']=$User->category;
		$sess_category = array(
         'user_category' => $User->category
       );
       $this->session->set_userdata('sess_category', $sess_category);
		
		$this->template->write_view('header', 'template/user/header',array('data'=>$data));
		$this->template->write_view('footer', 'template/user/footer',array());
	}
}

/* End of file Someclass.php */