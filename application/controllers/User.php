<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username')) {
            redirect('Auth/SignIn');
        }

        $this->load->model('user_model');
    }

    public function Index()
    {
        $data['page_title'] = 'User';
        $data['nama'] = $this->session->userdata('nama');
        $data['error'] = $this->session->flashdata('error');

        $data['users'] = $this->user_model->getlist();
        $this->load->view('header', $data);
        $this->load->view('UserList', $data);
        $this->load->view('footer', $data);
    }
    public function UserForm($userid = null)
    {

        $data['page_title'] = 'User Form';
        $data['nama'] = $this->session->userdata('nama');
        $data['error'] = $this->session->flashdata('error');

        $data['user'] = $this->user_model->GetEmpty();
        if ($userid != null) {
            $data['user'] = $this->user_model->get($userid);
        }

        $this->load->view('header', $data);
        $this->load->view('UserForm', $data);
        $this->load->view('footer', $data);
    }
    public function Save()
    {
        
        $data['page_title'] = 'Save';
        $email = $this->input->post('email');
        $jeniskelamin = $this->input->post('jeniskelamin');
        $nama = $this->input->post('nama');
        $nohp = $this->input->post('nohp');
        $password = $this->input->post('password');
        $status = $this->input->post('status');
        $tanggallahir = $this->input->post('tanggallahir');
        $alamat = $this->input->post('alamat');
        $username = $this->input->post('username');
        $userid = $this->input->post('userid');
        $usercode = $this->input->post('usercode');
        $userdate = $this->input->post('userdate');

        //cek data
        if (!isset($email) || $email == '') {
            $this->session->set_flashdata('error', 'Email kosong');
            redirect("User/UserForm/$userid");
            return;
        } else if (!isset($jeniskelamin) || $jeniskelamin == '') {
            $this->session->set_flashdata('error', 'Jenis Kelamin kosong');
            redirect("User/UserForm/$userid");
            return;
        } else if (!isset($nama) || $nama == '') {
            $this->session->set_flashdata('error', 'Nama kosong');
            redirect("User/UserForm/$userid");
            return;
        } else if (!isset($password) || $password == '') {
            $this->session->set_flashdata('error', 'Password kosong');
            redirect("User/UserForm/$userid");
            return;
        } else if (!isset($username) || $username == '') {
            $this->session->set_flashdata('error', 'Password kosong');
            redirect("User/UserForm/$userid");
            return;
        }
        if (!isset($userid) || $userid == '') {

            //cek data email, username duplicate
            if ($this->user_model->Duplicate($username, $email, )) {
                $this->session->set_flashdata('error', 'Username atau email Duplicate');
                redirect("User/UserForm/$userid");
                return;
            }

            //baru
            $count = $this->user_model->AddCount();
            $user = $this->user_model->GetEmpty();

            
            $user['email'] = $email;
            $user['jeniskelamin'] = $jeniskelamin;
            $user['nama'] = $nama;
            $user['nohp'] = $nohp;
            $user['password'] = $password;
            $user['status'] = 'customer';
            $user['tanggallahir'] = $tanggallahir;
            $user['alamat'] = $alamat;
            $user['username'] = $username;
            $user['userdate'] = date("Y-m-d H:i:s");
            $user['userid'] = $count;
            $user['usercode'] = $count;
            
            

            $this->user_model->insert($user, $count);
            $userid = $user['userid'];
        } else {
            //update
            $user = $this->user_model->get($userid);
            
            $user['email'] = $email;
            $user['jeniskelamin'] = $jeniskelamin;
            $user['nama'] = $nama;
            $user['nohp'] = $nohp;
            $user['password'] = $password;
            $user['status'] = 'customer';
            $user['tanggallahir'] = $tanggallahir;
            $user['alamat'] = $alamat;
            $user['username'] = $username;
            
            $this->user_model->insert($user, $user['userid']);
            $userid = $user['userid'];
        }

        redirect("User/UserForm/".$userid);
        return;

    }
}
