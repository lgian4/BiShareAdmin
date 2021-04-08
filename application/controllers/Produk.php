<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('username') == null) {
            redirect('Auth/SignIn');
        }

        $this->load->model('produk_model');
        $this->load->model('toko_model');
        $this->load->model('kategori_model');
        $this->load->helper('new_helper');
    }
    public function Uploadmedia()
    {

        // cari produk
        $produkid = $this->input->post('produkid');
        $produk = $this->produk_model->get($produkid);
        if ($produk == null || !isset($produk)) {
            $this->session->set_flashdata('error', 'Produk kosong');
            redirect("Produk/ProdukForm/$produkid");
            return;
        }
        //ambil count
        $count = $this->produk_model->AddCountMedia($produkid);
        
        // isi ke produkmedia
        $media = $this->produk_model->GetMediaEmpty();

        $bucket = $this->produk_model->defaultBucket;

        $dname = explode("/", $_FILES['uploadfile']['type']);
        $media['mediatype'] = reset($dname);
        $dname = explode(".", $_FILES['uploadfile']['name']);
        $media['mediaext'] = end($dname);
        $media['mediasize'] = $_FILES['uploadfile']['size'];
        $media['mediaid'] = $count;
        $media['produkid'] = $produk['produkid'];
        $media['medianama'] = $count . "." . $media['mediaext'];

        //upload file
        $object = $bucket->upload(
            file_get_contents($_FILES['uploadfile']['tmp_name']),
            [
                'name' => 'Produk/' . $produkid . "/" . $media['medianama'],
                'predefinedAcl' => 'publicRead',
            ]
        );

        $media['mediaurl'] = "https://{$bucket->name()}.storage.googleapis.com/{$object->name()}";
        if (!isset($produk['produkmedia']) || $produk['produkmedia'] == null) {
            $produk['produkmedia'] = [];
        }
        $produk['produkmedia'][$count] = $media;

        $this->produk_model->insert($produk, $produk['produkid']);

        redirect("Produk/ProdukForm/$produkid");
        return;
    }

    public function Index($tokoid = null)
    {
        $data = LoadDataAwal('Daftar Produk Saya');

        if ($this->session->userdata('status') != 'admin') {
            $tokoid = $this->session->userdata('tokoid');
        }
        if (!isset($tokoid) || $tokoid == '') {
            $tokoid = $this->session->userdata('tokoid');
            $data['produk'] = $this->produk_model->GetListByToko($tokoid);
        }
        $data['produk'] = $this->produk_model->GetListByToko($tokoid);
        $this->load->view('header', $data);
        $this->load->view('ProdukList', $data);
        $this->load->view('footer', $data);
    }
    public function ProdukList($status = 'approve')
    {
        $data = LoadDataAwal('Daftar produk');

        $produk = $this->produk_model->getlist();
        $data['produkstatus'] = $status;
        $hasil = [];
        for ($x = 0; $x < count($produk); $x++) {
            if ($produk[$x]['status'] == $status) {
                array_push($hasil, $produk[$x]);
            }
        }
        $data['produk'] = $hasil;
        $this->load->view('header', $data);
        $this->load->view('produkListAdmin', $data);
        $this->load->view('footer', $data);
    }
    public function ProdukForm($produk = null, $tokoid = null)
    {
        $data = LoadDataAwal('Product Form');
       
        if ($this->session->userdata('status') != 'admin') {
            $tokoid = $this->session->userdata('tokoid');
        }
        if (!isset($tokoid) || $tokoid == '') {
            $tokoid = $this->session->userdata('tokoid');
        }

        $data['produk'] = $this->produk_model->GetEmpty();
        if ($produk != null && $produk != 'null') {
            $data['produk'] = $this->produk_model->get($produk);
        } else {
            $toko = $this->toko_model->Get($tokoid);

            $data['produk']['tokoid'] = $toko['tokoid'];
            $data['produk']['tokoname'] = $toko['tokoname'];
            $data['produk']['status'] = 'pending';
        }

        $data['kategori'] = $this->kategori_model->getlist();
        $data['toko'] = $this->toko_model->getlist();

        if (!isset($data['produk']['produkmedia']) || $data['produk']['produkmedia'] == null) {
            $data['produk']['produkmedia'] = array();
        }

        $this->load->view('header', $data);
        $this->load->view('ProdukForm', $data);
        $this->load->view('footer', $data);
    }

    public function Save()
    {

        $data = LoadDataAwal('Product Form');
        $produkid = $this->input->post('produkid');
        $tokoid = $this->input->post('tokoid');
        $tokoname = $this->input->post('tokoname');
        $kategoriid = $this->input->post('kategoriid');
        $kategoriname = $this->input->post('kategoriname');
        $produkcode = $this->input->post('produkcode');
        $produkdate = $this->input->post('produkdate');
        $produkname = $this->input->post('produkname');
        $stok = $this->input->post('stok');
        $harga = $this->input->post('harga');
        $deskripsi = $this->input->post('deskripsi');
        $fitur = $this->input->post('fitur');
        $spesifikasi = $this->input->post('spesifikasi');
        $status = $this->input->post('status');
        $alasan = $this->input->post('alasan');

        //cek data
        if (!isset($tokoid) || $tokoid == '') {
            $this->session->set_flashdata('error', 'Toko kosong');
            redirect("Produk/ProdukForm/$produkid");
            return;
        } else if (!isset($kategoriid) || $kategoriid == '') {
            $this->session->set_flashdata('error', 'Kategori kosong');
            redirect("Produk/ProdukForm/$produkid");
            return;
        } else if (!isset($produkcode) || $produkcode == '') {
            $this->session->set_flashdata('error', 'Produk Code kosong');
            redirect("Produk/ProdukForm/$produkid");
            return;
        }
        $kategori = $this->kategori_model->Get($kategoriid);
        $toko = $this->toko_model->Get($tokoid);

        if (!isset($produkid) || $produkid == '') {

            //baru
            $count = $this->produk_model->AddCount();
            $produk = $this->produk_model->GetEmpty();

            $produk['produkid'] = $count;
            $produk['produkcode'] = $produkcode;
            $produk['produkdate'] = date("Y-m-d H:i:s");
            $produk['tokoid'] = $tokoid;
            $produk['tokoname'] = $toko['tokoname'];
            $produk['kategoriid'] = $kategoriid;
            $produk['kategoriname'] = $kategori['kategoriname'];

            if ($data['status'] == 'admin') {
                $produk['status'] = 'approve';
            } else {
                $produk['status'] = 'pending';
            }

            $produk['produkname'] = $produkname;
            $produk['stok'] = $stok;
            $produk['harga'] = $harga;
            $produk['deskripsi'] = $deskripsi;
            $produk['fitur'] = $fitur;
            $produk['spesifikasi'] = $spesifikasi;

            $this->produk_model->insert($produk, $count);

            $produkid = $produk['produkid'];
        } else {
            //update
            $produk = $this->produk_model->get($produkid);

            $produk['produkcode'] = $produkcode;
            $produk['produkdate'] = date("Y-m-d H:i:s");
            $produk['tokoid'] = $tokoid;
            $produk['tokoname'] = $tokoname;
            $produk['kategoriid'] = $kategoriid;
            $produk['kategoriname'] = $kategori['kategoriname'];
            $produk['status'] = $status;

            if ($status == 'reject') {
                $produk['status'] = 'pending';
            }

            $produk['produkname'] = $produkname;
            $produk['stok'] = $stok;
            $produk['harga'] = $harga;
            $produk['deskripsi'] = $deskripsi;
            $produk['fitur'] = $fitur;
            $produk['spesifikasi'] = $spesifikasi;

            $this->produk_model->insert($produk, $produk['produkid']);
            $produkid = $produk['produkid'];
        }

        redirect("produk/produkForm/" . $produkid);
        return;
    }

    public function Delete()
    {
        $data = LoadDataAwal('produk Form');
        $produkid = $this->input->post('produkid');
        //cek data
        if (!isset($produkid) || $produkid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'produk Kosong');
        }

        //pastikan jika ada
        $produk = $this->produk_model->get($produkid);
        if (!isset($produk) || $produk['produkid'] == '') {
            return ReturnJsonSimple(false, 'Gagal', 'produk Kosong');
        }
        // hapus

        $this->produk_model->SoftDelete($produk['produkid']);

        return ReturnJsonSimple(true, 'Sukses', 'produk dihapus');
    }
    public function DeleteMedia()
    {
        $data = LoadDataAwal('produk media');
        $produkid = $this->input->post('produkid');
        $mediaid = $this->input->post('mediaid');

        if (!isset($produkid) || $produkid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'produk Kosong');
        }

        //pastikan jika ada
        $produk = $this->produk_model->get($produkid);
        if (!isset($produk) || $produk['produkid'] == '') {
            return ReturnJsonSimple(false, 'Gagal', 'produk Kosong');
        }

        // hapus
        $bucket = $this->produk_model->defaultBucket;
        $object = $bucket->upload(
           null,
            [
                'name' => "Produk/".$produk['produkid']."/".$produk['produkmedia'][$mediaid]['medianama'],
                'predefinedAcl' => 'publicRead',
            ]
        );
        $produk['produkmedia'][$mediaid]['dlt'] = true;
        $this->produk_model->insert($produk, $produk['produkid']);
        return ReturnJsonSimple(true, 'Sukses', 'Media dihapus');
    }
    public function Review()
    {
        $data = LoadDataAwal('Review');
        $produkid = $this->input->post('produkid');
        $tokoid = $this->input->post('tokoid');

        $status = $this->input->post('status');
        $alasan = $this->input->post('alasan');

        //cek data
        if (!isset($tokoid) || $tokoid == '') {
            $this->session->set_flashdata('error', 'User kosong');
            redirect("produk/produkForm/$produkid");
            return;
        } else if (!isset($alasan) || $alasan == '') {
            $this->session->set_flashdata('error', 'alasan kosong');
            redirect("produk/produkForm/$produkid");
            return;
        }
        if (!isset($produkid) || $produkid == '') {

            $this->session->set_flashdata('error', 'produk kosong');
            redirect("produk/produkForm/$produkid");
            return;
        } else {
            //update
            $produk = $this->produk_model->get($produkid);

            $produk['status'] = $status;
            $produk['alasan'] = $alasan;
            $produk['produkdate'] = date("Y-m-d H:i:s");
            $this->produk_model->insert($produk, $produk['produkid']);

            $produkid = $produk['produkid'];
        }

        redirect("produk/produkForm/$produkid");
        return;
    }
}
