<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('ReturnJsonSimple'))
{
    function ReturnJsonSimple(bool $success, string $head, string $text)
    {
        header('Content-Type: application/json');
        $arr =    array(
            "success" => $success,
            "head" => $head,
            "text" => $text,
            );
        echo json_encode( $arr );
        return;
    }
   
}
if ( ! function_exists('LoadDataAwal'))
{
    function LoadDataAwal($pageTitle)
    {
        $CI = &get_instance();
        $data['page_title'] = $pageTitle;
        $data['nama'] = $CI->session->userdata('nama');
        $data['status'] = $CI->session->userdata('status');
        $data['userid'] = $CI->session->userdata('userid');
        $data['username'] = $CI->session->userdata('username');
        $data['email'] = $CI->session->userdata('email');
        $data['error'] = $CI->session->flashdata('error');
        return $data;
    }  
   
}
