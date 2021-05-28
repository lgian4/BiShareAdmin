<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diskusi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('status') != 'admin') {
            redirect('Auth/SignIn');
        }

        $this->load->model('diskusi_model');
        $this->load->helper('new_helper');
    }

    public function Index()
    {
        $data = LoadDataAwal('Daftar Diskusi');

        

        $data['diskusi'] = $this->diskusi_model->getlist();
        $this->load->view('header', $data);
        $this->load->view('DiskusiList', $data);
        $this->load->view('footer', $data);
    }
    public function DiskusiForm($diskusi = null)
    {
        $data = LoadDataAwal('Diskusi Form');

        $data['diskusi'] = $this->diskusi_model->GetEmpty();
        if ($diskusi != null) {
            $data['diskusi'] = $this->diskusi_model->get($diskusi);
        }

        $this->load->view('header', $data);
        $this->load->view('DiskusiForm', $data);
        $this->load->view('footer', $data);
    }
 
    public function Save()
    {

        $data['page_title'] = 'Save';
        $diskusiid = $this->input->post('diskusiid');
        $diskusiname = $this->input->post('diskusiname');
        $diskusitype = $this->input->post('diskusitype');
        $diskusidesc = $this->input->post('diskusidesc');
       

        //cek data
        if (!isset($diskusiname) || $diskusiname == '') {
            $this->session->set_flashdata('error', 'Nama kosong');
            redirect("Diskusi/DiskusiForm/$diskusiid");
            return;
        } else if (!isset($diskusitype) || $diskusitype == '') {
            $this->session->set_flashdata('error', 'Type kosong');
            redirect("Diskusi/DiskusiForm/$diskusiid");
            return;
        }
        if (!isset($diskusiid) || $diskusiid == '') {

            //baru
            
            $diskusi = $this->diskusi_model->GetEmpty();

            $diskusi['diskusiname'] = $diskusiname;
            $diskusi['diskusitype'] = $diskusitype;
            $diskusi['diskusidesc'] = $diskusidesc;          
            $diskusi['diskusiid'] = "";          

            $diskusi = $this->diskusi_model->insert($diskusi);            
            $diskusiid = $diskusi['diskusiid'];
        } else {
            //update
            $diskusi = $this->diskusi_model->get($diskusiid);

            $diskusi['diskusiname'] = $diskusiname;
            $diskusi['diskusitype'] = $diskusitype;
            $diskusi['diskusidesc'] = $diskusidesc;  

            $this->diskusi_model->update($diskusi, $diskusi['diskusiid']);
            $diskusiid = $diskusi['diskusiid'];
        }

        redirect("Diskusi/DiskusiForm/" . $diskusiid);
        return;
    }

    public function Delete()
    {
        $data = LoadDataAwal('Diskusi Form');
        $diskusiid = $this->input->post('diskusiid');
        //cek data
        if (!isset($diskusiid) || $diskusiid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'diskusi Kosong');
        }

        //pastikan jika ada
        $diskusi = $this->diskusi_model->get($diskusiid);
        if (!isset($diskusi) || $diskusi['diskusiid'] == '') {
            return ReturnJsonSimple(false, 'Gagal', 'diskusi Kosong');
        }
        // hapus

        $this->diskusi_model->SoftDelete($diskusi['diskusiid']);

        return ReturnJsonSimple(true, 'Sukses', 'Diskusi dihapus');
    }
}
