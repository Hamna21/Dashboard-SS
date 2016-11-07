<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sample extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'request'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('User_model');
    }

    //POST direct from login form redirects here
    public function loginAdmin()
    {
        if($this->input->server("REQUEST_METHOD") == 'POST')
        {
            //Getting data from login form
            $admin_data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://cte.itu.edu.pk/second_screen_api/api/loginAdmin",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\t\"email\": \"hamna.usmani@gmail.com\",\n\t\"password\": \"asdf1234\"\n}",
                CURLOPT_HTTPHEADER => array(
                    "authorization: Basic RGV2ZWxvcGVyOjEyMzQ=",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        }

    }

}