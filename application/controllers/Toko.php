<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('status') != 'admin') {
            redirect('Auth/SignIn');
        }

        $this->load->model('toko_model');
        $this->load->model('user_model');
        $this->load->helper('new_helper');
    }

    public function Index($status = 'approve')
    {
        $data = LoadDataAwal('Daftar Toko');

        $data['status'] = $this->session->userdata('status');
        $data['error'] = $this->session->flashdata('error');

        $toko = $this->toko_model->getlist();
        for ($x = 0; $x < count($toko); $x++) {
            if ($toko[$x]['status'] == $status) {
                unset($toko[$x]);
            }

        }
        $data['toko'] = $toko;
        $this->load->view('header', $data);
        $this->load->view('TokoList', $data);
        $this->load->view('footer', $data);
    }
    public function TokoForm($userid = null, $tokoid = null)
    {
        $data = LoadDataAwal('Toko Formulir');
        //jika toko id ada ambil data
        //jika kosong ambil nama user
        $data['toko'] = $this->toko_model->GetEmpty();

        if ($tokoid != null) {
            $data['toko'] = $this->toko_model->get($tokoid);

        } else {
            $user = $this->user_model->get($userid);
            if (!isset($user)) {
                $this->session->set_flashdata('error', 'User Kosong');
                redirect("Toko/Index/");
                return;

            }
            $data['toko']['userid'] = $user['userid'];
            $data['toko']['usernama'] = $user['nama'];
            $data['toko']['status'] = 'pending';
            $data['toko']['tokodate'] = date("Y-m-d H:i:s");
        }

        $this->load->view('header', $data);
        $this->load->view('TokoForm', $data);
        $this->load->view('footer', $data);
    }
    public function Save()
    {

        $data['page_title'] = 'Save';
        $tokoid = $this->input->post('tokoid');
        $userid = $this->input->post('userid');
        $usernama = $this->input->post('usernama');
        $tokoname = $this->input->post('tokoname');
        $tokoid = $this->input->post('tokoid');
        $tokodesc = $this->input->post('tokodesc');
        $kontak = $this->input->post('kontak');
        $status = $this->input->post('status');

        //cek data
        if (!isset($userid) || $userid == '') {
            $this->session->set_flashdata('error', 'User kosong');
            redirect("Toko/TokoForm/$userid");
            return;
        } else if (!isset($tokoname) || $tokoname == '') {
            $this->session->set_flashdata('error', 'Toko kosong');
            redirect("Toko/TokoForm/$userid");
            return;
        } else if (!isset($tokodesc) || $tokodesc == '') {
            $this->session->set_flashdata('error', 'Deskripso kosong');
            redirect("Toko/TokoForm/$userid");
            return;
        }
        if (!isset($tokoid) || $tokoid == '') {

            //baru
            $count = $this->toko_model->AddCount();
            $toko = $this->toko_model->GetEmpty();

            $toko['userid'] = $userid;
            $toko['usernama'] = $usernama;
            $toko['tokoname'] = $tokoname;
            $toko['tokoid'] = $count;
            $toko['tokocode'] = 'T' . $count;
            $toko['tokodesc'] = $tokodesc;
            $toko['status'] = 'pending';
            $toko['kontak'] = $kontak;
            $toko['tokodate'] = date("Y-m-d H:i:s");

            $this->toko_model->insert($toko, $count);

            $tokoid = $toko['tokoid'];

            $user = $this->user_model->get($userid);
            $user['tokoid'] = $tokoid;
            $this->user_model->insert($user, $user['userid']);
        } else {
            //update
            $toko = $this->toko_model->get($tokoid);

            $toko['tokoname'] = $tokoname;
            $toko['tokodesc'] = $tokodesc;
            $toko['status'] = 'pending';
            $toko['kontak'] = $kontak;

            $this->toko_model->insert($toko, $toko['tokoid']);
            $tokoid = $toko['tokoid'];
        }

        redirect("Toko/TokoForm/" . $userid . '/' . $tokoid);
        return;

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
        $user['status'] = 'customer';
        $user['tanggallahir'] = $tanggallahir;
        $user['alamat'] = $alamat;
        $user['username'] = $username;

        $this->user_model->insert($user, $user['userid']);
        $userid = $user['userid'];

        redirect("User/Profile");
        return;

    }

    public function Delete()
    {
        $data = LoadDataAwal('User Form');

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
