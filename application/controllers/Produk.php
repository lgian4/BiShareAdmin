<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('status') == 'customer' ) {
            redirect('Auth/SignIn');
        }

        $this->load->model('produk_model');
        $this->load->model('toko_model');
        $this->load->model('kategori_model');
        $this->load->helper('new_helper');
    }

    public function Index($tokoid =  null)
    {
        $data = LoadDataAwal('Daftar Produk Saya');

        if( $this->session->userdata('status') != 'admin' ){
            $tokoid = $this->session->userdata('tokoid');
        
        }
        if(!isset($tokoid) || $tokoid == '')                {
            $tokoid = $this->session->userdata('tokoid');
            $data['produk'] = $this->produk_model->GetListByToko($tokoid);
        }
        $data['produk'] = $this->produk_model->GetListByToko($tokoid);
        $this->load->view('header', $data);
        $this->load->view('ProdukList', $data);
        $this->load->view('footer', $data);
    }
    public function KategoriForm($kategori = null)
    {
        $data = LoadDataAwal('Kategori Form');

        $data['kategori'] = $this->kategori_model->GetEmpty();
        if ($kategori != null) {
            $data['kategori'] = $this->kategori_model->get($kategori);
        }

        $this->load->view('header', $data);
        $this->load->view('KategoriForm', $data);
        $this->load->view('footer', $data);
    }
 
    public function Save()
    {

        $data['page_title'] = 'Save';
        $kategoriid = $this->input->post('kategoriid');
        $kategoriname = $this->input->post('kategoriname');
        $kategoricode = $this->input->post('kategoricode');
        $kategoridesc = $this->input->post('kategoridesc');
       

        //cek data
        if (!isset($kategoriname) || $kategoriname == '') {
            $this->session->set_flashdata('error', 'Nama kosong');
            redirect("Kategori/KategoriForm/$kategoriid");
            return;
        } else if (!isset($kategoricode) || $kategoricode == '') {
            $this->session->set_flashdata('error', 'Code kosong');
            redirect("Kategori/KategoriForm/$kategoriid");
            return;
        }
        if (!isset($kategoriid) || $kategoriid == '') {

          

            //baru
            $count = $this->kategori_model->AddCount();
            $kategori = $this->kategori_model->GetEmpty();

            $kategori['kategoriname'] = $kategoriname;
            $kategori['kategoricode'] = $kategoricode;
            $kategori['kategoridesc'] = $kategoridesc;          
            $kategori['kategoriid'] = $count;          

            $this->kategori_model->insert($kategori, $count);
            $kategoriid = $kategori['kategoriid'];
        } else {
            //update
            $kategori = $this->kategori_model->get($kategoriid);

            $kategori['kategoriname'] = $kategoriname;
            $kategori['kategoricode'] = $kategoricode;
            $kategori['kategoridesc'] = $kategoridesc;  

            $this->kategori_model->insert($kategori, $kategori['kategoriid']);
            $kategoriid = $kategori['kategoriid'];
        }

        redirect("Kategori/KategoriForm/" . $kategoriid);
        return;
    }

    public function Delete()
    {
        $data = LoadDataAwal('Kategori Form');
        $kategoriid = $this->input->post('kategoriid');
        //cek data
        if (!isset($kategoriid) || $kategoriid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'kategori Kosong');
        }

        //pastikan jika ada
        $kategori = $this->kategori_model->get($kategoriid);
        if (!isset($kategori) || $kategori['kategoriid'] == '') {
            return ReturnJsonSimple(false, 'Gagal', 'kategori Kosong');
        }
        // hapus

        $this->kategori_model->SoftDelete($kategori['kategoriid']);

        return ReturnJsonSimple(true, 'Sukses', 'Kategori dihapus');
    }
}
