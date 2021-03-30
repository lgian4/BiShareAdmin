<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('username') == null ) {
            
            redirect('Auth/SignIn');
        }

        $this->load->model('user_model');
        $this->load->helper('new_helper');
    }

    public function Index()
    {
        $data = LoadDataAwal('Daftar User');

        $data['status'] = $this->session->userdata('status');
        $data['error'] = $this->session->flashdata('error');

        $data['users'] = $this->user_model->getlist();
        $this->load->view('header', $data);
        $this->load->view('UserList', $data);
        $this->load->view('footer', $data);
    }
    public function UserForm($userid = null)
    {
        $data = LoadDataAwal('User Form');

        $data['user'] = $this->user_model->GetEmpty();
        if ($userid != null) {
            $data['user'] = $this->user_model->get($userid);
        }

        $this->load->view('header', $data);
        $this->load->view('UserForm', $data);
        $this->load->view('footer', $data);
    }
    public function Profile()
    {
        $data = LoadDataAwal('User Profile');
        $userid = $this->session->userdata('userid');
        $data['user'] = $this->user_model->GetEmpty();
        if ($userid != null) {
            $data['user'] = $this->user_model->get($userid);
        }

        $this->load->view('header', $data);
        $this->load->view('Profile', $data);
        $this->load->view('footer', $data);
    }

    public function SaveProfile()
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
        $validUserid = $this->session->userdata('userid');
        if ($validUserid != $userid) {
            $this->session->set_flashdata('error', 'User Salah');
            redirect("User/Profile/");
            return;
        }
        if (!isset($email) || $email == '') {
            $this->session->set_flashdata('error', 'Email kosong');
            redirect("User/Profile");
            return;
        } else if (!isset($jeniskelamin) || $jeniskelamin == '') {
            $this->session->set_flashdata('error', 'Jenis Kelamin kosong');
            redirect("User/Profile");
            return;
        } else if (!isset($nama) || $nama == '') {
            $this->session->set_flashdata('error', 'Nama kosong');
            redirect("User/Profile");
            return;
        } else if (!isset($password) || $password == '') {
            $this->session->set_flashdata('error', 'Password kosong');
            redirect("User/Profile");
            return;
        } else if (!isset($username) || $username == '') {
            $this->session->set_flashdata('error', 'Username kosong');
            redirect("User/Profile");
            return;
        }

        //update
        $user = $this->user_model->get($userid);

        $user['email'] = $email;
        $user['jeniskelamin'] = $jeniskelamin;
        $user['nama'] = $nama;
        $user['nohp'] = $nohp;
        $user['password'] = $password;
        $user['tanggallahir'] = $tanggallahir;
        $user['alamat'] = $alamat;
        $user['username'] = $username;

        $this->user_model->insert($user, $user['userid']);
        $userid = $user['userid'];

        redirect("User/Profile");
        return;
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
            if ($this->user_model->Duplicate($username, $email,)) {
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
            if (!isset($status) || $status == '') {
                $user['status'] =  'customer';
            } else {
                $user['status'] =  $status;
            }
            $user['tanggallahir'] = $tanggallahir;
            $user['alamat'] = $alamat;
            $user['username'] = $username;
            $user['userdate'] = date("Y-m-d H:i:s");
            $user['userid'] = $count;
            $user['usercode'] = 'U' . $count;

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

            $user['tanggallahir'] = $tanggallahir;
            $user['alamat'] = $alamat;
            $user['username'] = $username;

            $this->user_model->insert($user, $user['userid']);
            $userid = $user['userid'];
        }

        redirect("User/UserForm/" . $userid);
        return;
    }

    public function Delete()
    {
        $data = LoadDataAwal('User Form');
        $userid = $this->input->post('userid');
        //cek data
        if (!isset($userid) || $userid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'User Kosong');
        }

        //pastikan jika ada
        $user = $this->user_model->get($userid);
        if (!isset($user) || $user['userid'] == '') {
            return ReturnJsonSimple(false, 'Gagal', 'User Kosong');
        }
        // hapus

        $this->user_model->SoftDelete($user['userid']);

        return ReturnJsonSimple(true, 'Suksus', 'User dihapus');
    }
}
