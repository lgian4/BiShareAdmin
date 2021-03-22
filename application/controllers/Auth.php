<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // if ($this->session->userdata('username')) {
        //     redirect('Admin');
        // }
    }

    public function SignIn()
    {
		$this->load->view('login');
       

    }
	public function ProcessSignIn()
    {
		$data['page_title'] = 'Login';
        $username = $this->input->post('username');
        $password = $this->input->post('password');
		
        if (!isset($username) || $username == '') {
			redirect("auth/SignIn");
			return;
        } else {
            $this->load->model('user_model');

            $user = $this->user_model->login($username, $password);
		
            if (isset($user)) {
                $this->session->set_userdata($user);
				
                redirect("auth/index");
                return;

            } else {
                $data['error'] = 'Your Account is Invalid';
                $this->load->view('login', $data);

            }
        }
    }
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/index');
    }
    public function index()
    {

        if (!$this->session->userdata('username')) {
            redirect('Auth/SignIn');
        }
        $data['page_title'] = 'Login';
		$data['nama'] = $this->session->userdata('nama');
		
        $this->load->view('header', $data);
        $this->load->view('admin', $data);
        $this->load->view('footer', $data);
    }
}
