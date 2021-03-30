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
        $this->load->helper('new_helper');
    }

    public function SignIn()
    {
        $this->load->view('login');

    }
    public function Register()
    {
        $data['error'] = $this->session->flashdata('error');
        
        $this->load->view('register',$data);

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
    public function ProcessRegister()
    {
        $data['page_title'] = 'Register';
        $email = $this->input->post('email');
        $jeniskelamin = $this->input->post('jeniskelamin');
        $nama = $this->input->post('nama');
        $nohp = $this->input->post('nohp');
        $password = $this->input->post('password');
        $tanggallahir = $this->input->post('tanggallahir');
        $username = $this->input->post('username');
        //cek data
        if (!isset($email) || $email == '') {
            $this->session->set_flashdata('error','Email kosong');
            redirect("auth/Register");
            return;
        } else if (!isset($jeniskelamin) || $jeniskelamin == '') {
            $this->session->set_flashdata('error','Jenis Kelamin kosong');
            redirect("auth/Register");
            return;
        } else if (!isset($nama) || $nama == '') {
            $this->session->set_flashdata('error','Nama kosong');
            redirect("auth/Register");
            return;
        } else if (!isset($password) || $password == '') {
            $this->session->set_flashdata('error','Password kosong');
            redirect("auth/Register");
            return;
        }
        else if (!isset($username) || $username == '') {
            $this->session->set_flashdata('error','Password kosong');
            redirect("auth/Register");
            return;
        }

        $this->load->model('user_model');

        //cek data email, username duplicate
        if($this->user_model->Duplicate($username, $email))
        { 
            $this->session->set_flashdata('error','Username atau email Dupliate');
            redirect("auth/Register");
            return;
        }
        
        $user = $this->user_model->Register($username, $password, $email, $jeniskelamin, $nama, $nohp, $tanggallahir);
        
        if (isset($user)) {
            $this->session->set_userdata($user);

            redirect("auth/index");
            return;

        } else {
            $data['error'] = 'Your Account is Invalid';
            $this->load->view('login', $data);
            return;
        }

    }

   
    public function SignOut()
    {
        $this->session->sess_destroy();
        redirect('auth/SignIn');
    }
    public function index()
    {

        if ($this->session->userdata('username')=='') {
            redirect('Auth/SignIn');
        }
        $data = LoadDataAwal('Dashboard');

        $this->load->view('header', $data);
        
        $this->load->view('admin', $data);
        
        $this->load->view('footer', $data);
    }
}
