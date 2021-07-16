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
        $data['page_title'] = 'Register'; 
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
        $this->load->model('kategori_model');
        $this->load->model('produk_model');
        $this->load->model('user_model');
        $this->load->model('toko_model');

        $kategori = $this->kategori_model->GetList();
        $kategoricount = 0;
        foreach ($kategori as  $value) {
            if($value['dlt'])
                continue;
            $kategoricount++;
        }
        $data['kategoricount'] = NumberNice( $kategoricount);

        $produk = $this->produk_model->GetList();
        $produkcount = 0;
        $produkpendingcount = 0;
        foreach ($produk as  $value) {
            if($value['dlt'])
                continue;
            if($value["status"] =="approve")
            $produkcount++;
            if($value["status"] =="pending")
            $produkpendingcount++;
        }
        $data['produkcount'] = NumberNice( $produkcount);
        $data['produkpendingcount'] = NumberNice( $produkpendingcount);

        $user = $this->user_model->GetList();
        $usercount = 0;
        $tokocount = 0;
        foreach ($user as  $value) {
            if($value['dlt'])
                continue; 
            if($value["status"] =="customer")           
            $usercount++;            
            if($value["status"] =="penjual")           
            $tokocount++;            
        }
        $data['usercount'] = NumberNice( $usercount);        
        $data['tokocount'] = NumberNice( $tokocount);  

        $toko = $this->toko_model->GetList();
       
        $tokopendingcount = 0;
        foreach ($toko as  $value) {
            if($value['dlt'])
                continue;       
            if($value["status"] =="pending")
            $tokopendingcount++;
        }        
        $data['tokopendingcount'] = NumberNice( $tokopendingcount);

        $this->load->view('header', $data);
        
        $this->load->view('admin', $data);
        
        $this->load->view('footer', $data);
    }
}