<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'libraries/My_Controller.php');

class Login extends My_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        //$this->load->view('welcome_message');
        $this->load->helper('form');
        $data = null;
        $error = null;
        $title = 'Sign in';
        $this->template->write_view('content','pages/login',array('data'=>$data,'error'=>$error,'title'=>$title));
        $this->template->render();
    }

    public function login_check()
    {
        $data = $this->input->post();
        if($_POST)
        {
            $this->load->model('user_model');
            if($this->user_model->login_check($data))
            {
                $msg = array(
                    'status' => true,
                    'class' => 'successbox',
                    'msg' => 'Registration complete successfully.'
                );

                $data = json_encode($msg);

                redirect('/userpanel');

                $this->session->set_flashdata('msg', $data);
            }
            else
            {
                $msg = array(
                    'status' => false,
                    'class' => 'errormsgbox',
                    'msg' => 'Login failed please try again.'
                );

                $data = json_encode($msg);

                $this->session->set_flashdata('msg', $data);
            }
        }
        redirect('/login');
    }

    public function logout()
    {
        $this->session->unset_userdata('user_info');
        redirect('/login');
    }

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */