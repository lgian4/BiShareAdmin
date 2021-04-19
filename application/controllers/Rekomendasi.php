<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekomendasi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('username') == null) {
            redirect('Auth/SignIn');
        }
        if ($this->session->userdata('status') != 'admin') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses');
            redirect('Auth/index');
        }

        $this->load->model('rekomendasi_model');
        $this->load->model('produk_model');        
        $this->load->helper('new_helper');
    }
    

    public function Index()
    {
        $data = LoadDataAwal('Daftar rekomendasi');

        
        $data['produk'] = $this->produk_model->GetList();
        
        $data['rekomendasi'] = $this->rekomendasi_model->GetList();
        $this->load->view('header', $data);
        $this->load->view('rekomendasiList', $data);
        $this->load->view('footer', $data);
    }
    
    public function rekomendasiForm($rekomendasi = null)
    {
        $data = LoadDataAwal('Rekomendasi Form');
       
        $data['produk'] = $this->produk_model->GetList();

        $data['rekomendasi'] = $this->rekomendasi_model->GetEmpty();


        if ($rekomendasi != null && $rekomendasi != 'null') {
            $data['rekomendasi'] = $this->rekomendasi_model->get($rekomendasi);
        }

        
        $this->load->view('header', $data);
        $this->load->view('rekomendasiForm', $data);
        $this->load->view('footer', $data);
    }

    public function Save()
    {

        $data = LoadDataAwal('Rekomendasi Form');
        $rekomendasiid = $this->input->post('rekomendasiid');
        $produkid = $this->input->post('produkid');
        $urutan = $this->input->post('urutan'); 

        //cek data
        if (!isset($produkid) || $produkid == '') {
            $this->session->set_flashdata('error', 'produkid kosong');
            redirect("rekomendasi/rekomendasiForm/$rekomendasiid");
            return;
        } else if (!isset($urutan) || $urutan == '') {
            $this->session->set_flashdata('error', 'urutan kosong');
            redirect("rekomendasi/rekomendasiForm/$rekomendasiid");
            return;
        }
        $produk = $this->produk_model->Get($produkid);
     

        if (!isset($rekomendasiid) || $rekomendasiid == '') {

            //baru
            $count = $this->rekomendasi_model->AddCount();
            $rekomendasi = $this->rekomendasi_model->GetEmpty();

            $rekomendasi['rekomendasiid'] = $count;
            $rekomendasi['produkid'] = $produkid;
            $rekomendasi['urutan'] = $urutan;            
            $rekomendasi['produkname'] = $produk['produkname'];
            
            

            $this->rekomendasi_model->insert($rekomendasi, $count);

            $rekomendasiid = $rekomendasi['rekomendasiid'];
        } else {
            //update
            $rekomendasi = $this->rekomendasi_model->get($rekomendasiid);
            
            $rekomendasi['produkid'] = $produkid;
            $rekomendasi['urutan'] = $urutan;            
            $rekomendasi['produkname'] = $produk['produkname'];
            

            $this->rekomendasi_model->insert($rekomendasi, $rekomendasi['rekomendasiid']);
            $rekomendasiid = $rekomendasi['rekomendasiid'];
        }

        redirect("rekomendasi/rekomendasiForm/" . $rekomendasiid);
        return;
    }

    public function Delete()
    {
        $data = LoadDataAwal('rekomendasi Form');
        $rekomendasiid = $this->input->post('rekomendasiid');
        //cek data
        if (!isset($rekomendasiid) || $rekomendasiid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'rekomendasi Kosong');
        }

        //pastikan jika ada
        $rekomendasi = $this->rekomendasi_model->get($rekomendasiid);
        if (!isset($rekomendasi) || $rekomendasi['rekomendasiid'] == '') {
            return ReturnJsonSimple(false, 'Gagal', 'rekomendasi Kosong');
        }
        // hapus

        $this->rekomendasi_model->SoftDelete($rekomendasi['rekomendasiid']);

        return ReturnJsonSimple(true, 'Sukses', 'rekomendasi dihapus');
    }
   
}
