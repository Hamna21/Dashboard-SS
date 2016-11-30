<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lecture_Reference extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url','request','image'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Lecture_model');
    }

    //POST request on New Reference submission redirects here
    public function addReference()
    {
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $reference_data = array(
                'lecture_id' => $this->input->post('lectureID'),
                'time' => $this->input->post('time'),
                'type' => $this->input->post('type')
            );

            //Formatting time
            $date = new DateTime($reference_data['time']);
            $reference_data['time'] = $date->format('Y-m-d H:i:s');

            if($reference_data['type'] == "lecture")
            {
                $reference_data['value'] = $this->input->post('prev_lectureID');
            }
            else
            {
                $reference_data['value'] = $this->input->post('link');
                $image_attributes = uploadPicture();
                $imageUploadStatus = $image_attributes[0];

                //If imageValidation fails, then reload lecture page
                if ($imageUploadStatus == 0) {
                    $error_data = array(
                        'error' => 'reference',
                        'message' => 'Error in registering new Reference - Image not right.'
                    );

                    $this->session->set_flashdata($error_data);
                    redirect('lectures');
                }

                //Setting image  name
                $image_Name = $image_attributes[1];
                $reference_data['image'] = base_url().'/uploads/'.$image_Name;
            }


            $result = sendPostRequest('api/reference/add', $reference_data);

            if($result->status == ('error in db'))
            {
                $this->session->set_flashdata('error', 'reference');
                $this->session->set_flashdata('message', "Error in registering new Reference to Database");
                redirect('lectures');
            }

            if($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'reference');
                $this->session->set_flashdata('message', "New Reference successfully added.");
                redirect('lectures');
            }
            else{
                $this->session->set_flashdata('error', 'reference');
                $this->session->set_flashdata('message', "Error in registering new Reference to Database - Syntax Error");
                redirect('lectures');
            }
        }
    }

}