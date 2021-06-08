<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('username') || $this->session->userdata('status') != 'admin') {
            redirect('Auth/SignIn');
        }

        $this->load->model('event_model');
        $this->load->model('produk_model');
        $this->load->helper('new_helper');
    }

    public function Index()
    {
        $data = LoadDataAwal('Daftar Event');

        

        $data['event'] = $this->event_model->getlist();
        $this->load->view('header', $data);
        $this->load->view('EventList', $data);
        $this->load->view('footer', $data);
    }
    public function eventForm($event = null)
    {
        $data = LoadDataAwal('Event Form');

        $data['event'] = $this->event_model->GetEmpty();
        if ($event != null) {
            $data['event'] = $this->event_model->get($event);
            $data['eventdetail'] = $this->event_model->getDetail($event);
            
        }
        $produk = $this->produk_model->getlist();
        
        $data['produk'] = $produk;
        $this->load->view('header', $data);
        $this->load->view('EventForm', $data);
        $this->load->view('footer', $data);
    }
 
    public function Save()
    {

        $data['page_title'] = 'Save';
        $eventid = $this->input->post('eventid');
        $eventnama = $this->input->post('eventnama');
        $eventcode = $this->input->post('eventcode');
        $eventdesc = $this->input->post('eventdesc');
        $status = $this->input->post('status');
       

        //cek data
        if (!isset($eventnama) || $eventnama == '') {
            $this->session->set_flashdata('error', 'Nama kosong');
            redirect("event/eventForm/$eventid");
            return;
        }
        if (!isset($eventid) || $eventid == '') {

            //baru
            
            $event = $this->event_model->GetEmpty();

            $event['eventnama'] = $eventnama;
            $event['eventcode'] = $eventcode;
            $event['eventdesc'] = $eventdesc;          
            $event['status'] = $status;   
            $event['eventid'] = "";          

            $event = $this->event_model->insert($event);            
            $eventid = $event['eventid'];
        } else {
            //update
            $event = $this->event_model->get($eventid);

            $event['eventname'] = $eventname;
            $event['eventcode'] = $eventcode;
            $event['eventdesc'] = $eventdesc; 
            $event['status'] = $status;   

            $this->event_model->update($event, $event['eventid']);
            $eventid = $event['eventid'];
        }

        redirect("event/eventForm/" . $eventid);
        return;
    }
    public function SaveProduk()
    {

        $data['page_title'] = 'Save';
        $eventid = $this->input->post('eventid');
        $produkid = $this->input->post('produkid');
       

        //cek data
        if (!isset($eventid) || $eventid == '') {
            $this->session->set_flashdata('error', 'Event kosong');
            redirect("event/eventForm/$eventid");
            return;
        }
        if (!isset($produkid) || $produkid == '') {
            $this->session->set_flashdata('error', 'Produk kosong');
            redirect("event/eventForm/$eventid");
            return;
        }
            $this->event_model->addproduk($eventid,$produkid);
            
        redirect("event/eventForm/" . $eventid);
        return;
    }

    public function Delete()
    {
        $data = LoadDataAwal('Event Form');
        $eventid = $this->input->post('eventid');
        //cek data
        if (!isset($eventid) || $eventid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'Event Kosong');
        }

        //pastikan jika ada
        $event = $this->event_model->get($eventid);
        if (!isset($event) || $event['eventid'] == '') {
            return ReturnJsonSimple(false, 'Gagal', 'Event Kosong');
        }
        // hapus

        $this->event_model->SoftDelete($event['eventid']);

        return ReturnJsonSimple(true, 'Sukses', 'Event dihapus');
    }
    public function DeleteProduk()
    {
        $data = LoadDataAwal('Event Delete');
        $eventid = $this->input->post('eventid');
        $produkid = $this->input->post('produkid');
        //cek data
        if (!isset($eventid) || $eventid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'Event Kosong');
        }
        if (!isset($produkid) || $produkid == '') {
            return ReturnJsonSimple(false, 'Gagal', 'Produk Kosong');
        }

       

        $this->event_model->DeleteProduk($eventid,$produkid);

        return ReturnJsonSimple(true, 'Sukses', 'Event dihapus');
    }
}
