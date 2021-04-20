<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Toko extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('username') == null) {
            redirect('Auth/SignIn');
        }

        $this->load->model('toko_model');
        $this->load->model('produk_model');
        $this->load->model('user_model');
        $this->load->helper('new_helper');
    }

    public function Index($status = 'approve')
    {
        $data = LoadDataAwal('Daftar Toko');

        $data['status'] = $this->session->userdata('status');
        $data['error'] = $this->session->flashdata('error');

        $toko = $this->toko_model->getlist();
        $data['tokostatus'] = $status;
        $hasil = [];
        for ($x = 0; $x < count($toko); $x++) {
            if ($toko[$x]['status'] == $status) {
                array_push($hasil, $toko[$x]);
            }
        }
        $data['toko'] = $hasil;
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
            redirect("Toko/TokoForm/$userid/$tokoid");
            return;
        } else if (!isset($tokoname) || $tokoname == '') {
            $this->session->set_flashdata('error', 'Toko kosong');
            redirect("Toko/TokoForm/$userid/$tokoid");
            return;
        } else if (!isset($tokodesc) || $tokodesc == '') {
            $this->session->set_flashdata('error', 'Deskripso kosong');
            redirect("Toko/TokoForm/$userid/$tokoid");
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


            if ($toko['tokoname'] != $tokoname) {
                $produk = $this->produk_model->GetListByToko($tokoid);
                foreach ($produk as $value) {
                    if ($value['tokoid'] == $toko['tokoid'] && $value['dlt'] == false)  {
                        $value['tokoname'] = $tokoname; //
                        var_dump($value);
                        //$this->produk_model->insert($value,$value['produkid']);
                    }
                }
            }
            $toko['tokoname'] = $tokoname;
            $toko['tokodesc'] = $tokodesc;
            $toko['status'] = $status;

            if ($status == 'reject') {
                $toko['status'] = 'pending';
            }

            $toko['kontak'] = $kontak;

            $this->toko_model->insert($toko, $toko['tokoid']);



            $tokoid = $toko['tokoid'];
        }

        redirect("Toko/TokoForm/" . $userid . '/' . $tokoid);
        return;
    }
    public function Review()
    {

        $data['page_title'] = 'Review';
        $tokoid = $this->input->post('tokoid');
        $userid = $this->input->post('userid');

        $status = $this->input->post('status');
        $alasan = $this->input->post('alasan');

        //cek data
        if (!isset($userid) || $userid == '') {
            $this->session->set_flashdata('error', 'User kosong');
            redirect("Toko/TokoForm/$userid/$tokoid");
            return;
        } else if (!isset($alasan) || $alasan == '') {
            $this->session->set_flashdata('error', 'alasan kosong');
            redirect("Toko/TokoForm/$userid/$tokoid");
            return;
        }
        if (!isset($tokoid) || $tokoid == '') {

            $this->session->set_flashdata('error', 'Toko kosong');
            redirect("Toko/TokoForm/$userid/$tokoid");
            return;
        } else {
            //update
            $toko = $this->toko_model->get($tokoid);

            $toko['status'] = $status;
            $toko['alasan'] = $alasan;
            $toko['tokodate'] = date("Y-m-d H:i:s");
            $this->toko_model->insert($toko, $toko['tokoid']);

            if ($status == 'approve') {
                $user = $this->user_model->get($userid);
                if ($user['status'] == 'customer') {
                    $user['status'] = 'penjual';
                }
                $user['tokoid'] = $toko['tokoid'];
                $this->user_model->insert($user, $user['userid']);
            }
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

    public function Delete()
    {
        $data = LoadDataAwal('Delete');
        $tokoid = $this->input->post('tokoid');
        //cek data
        if (!isset($tokoid) || $tokoid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'Toko Kosong');
        }
        //pastikan jika ada
        $toko = $this->toko_model->get($tokoid);
        if (!isset($toko) || $toko['tokoid'] == '') {
            return ReturnJsonSimple(false, 'Gagal', 'Toko Kosong');
        }
        // hapus

        $this->toko_model->SoftDelete($toko['tokoid']);
        $user = $this->user_model->get($toko['userid']);
        $user['tokoid'] = '';
        $this->user_model->insert($user, $user['userid']);
        return ReturnJsonSimple(true, 'Suksus', 'toko dihapus');
    }
}
