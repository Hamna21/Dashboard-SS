<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lecture_Reference extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url','request','image'));
        $this->load->library(array('session', 'form_validation', 'pagination'));
        $this->load->model('Lecture_model');
    }

    //View all references of a lecture
    public function view()
    {
        //Redirect to Login page if user is not logged in
        if (!isset($_SESSION['user'])) {
            redirect('/Login');
        }
        if (!file_exists(APPPATH . 'views/pages/reference/referenceView.php')) {
            show_404();
        }

        $data['title'] = ('Reference');
        $data['subtitle'] = ('');

        //get lecture_id sent via GET request - if empty then use the one stored in session
        //To maintain links for pagination using session one

        if($_REQUEST)
        {
            $lecture_id = $this->input->get('lecture_id');
            $this->session->set_userdata('lecture_id',$lecture_id);
        }
        else
        {
            $lecture_id = $this->session->lecture_id;
        }

        //--------Pagination--------//
        $config["base_url"] = base_url() . "reference";
        $config['per_page'] = 5;
        $page =($this->uri->segment(2)) ? ($this->uri->segment(2) -1) * 5 : 0;

        //If $page = -1
        if($page < 0)
        {
            $page = 0;
        }
        $pagination_data = array(
            'limit' => $config['per_page'],
            'start' => $page
        );

        //Getting lecture name, all references of that lecture
        $result = sendPostRequest('api/lecture/reference_pagination?lecture_id=' .$lecture_id, $pagination_data);

        if($result->status == ("error")) {
            show_error("No references found for this lecture", 500, 'Error');
        }

        $config["total_rows"] = $result->referenceTotal;
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['references'] = ($result->references);
        $data['lecture'] = ($result->lecture);

        //Sending request to API - for all lectures - to be used in Reference
        $result = sendGetRequest('api/lectures_reference');
        $data['lectures_reference'] = $result->lectures;

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/reference/referenceView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST request on New Reference submission redirects here
    public function addReference_old()
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
                redirect('reference?lecture_id='.$reference_data['lecture_id']);
            }
            else{
                $this->session->set_flashdata('error', 'reference');
                $this->session->set_flashdata('message', "Error in registering new Reference to Database - Syntax Error");
                redirect('lectures');
            }
        }
    }

    //POST request on New Reference submission redirects here
    public function addReference()
    {
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $reference_data = array(
                'lecture_id' => $this->input->post('lectureID'),
                'type' => $this->input->post('type')
            );

            $date = $this->input->post('date');
            $start_time = $this->input->post('start_time');
            $minute = $this->input->post('minute');
            $second = $this->input->post('second');

            //Adding 0 to minute and second - in case of single digit
            $minute = sprintf("%02s", $minute);
            $second = sprintf("%02s", $second);

            //Adding minutes and second to lecture starting time to get reference time
            $updated_time = strtotime($start_time);
            $updated_time = $updated_time + ($minute * 60); //Adding minutes
            $updated_time = $updated_time + ($second); //Adding seconds
            $updated_time = date("H:i:s", $updated_time);


            //Adding date to reference time
            $reference_time = $date . ' ' . $updated_time;

            //Formatting time
            $reference_time= new DateTime($reference_time);
            $reference_data['time'] = $reference_time->format('Y-m-d H:i:s');

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
                    redirect('reference?lecture_id='.$reference_data['lecture_id']);
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
                redirect('reference?lecture_id='.$reference_data['lecture_id']);
            }

            if($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'reference');
                $this->session->set_flashdata('message', "New Reference successfully added.");
                redirect('reference?lecture_id='.$reference_data['lecture_id']);
            }
            else{
                $this->session->set_flashdata('error', 'reference');
                $this->session->set_flashdata('message', "Error in registering new Reference to Database - Syntax Error");
                redirect('reference?lecture_id='.$reference_data['lecture_id']);
            }
        }
    }

    public function editReference()
    {
        if($this->input->server('REQUEST_METHOD') == "POST")
        {
            $lecture_id = $this->input->post('lecture_ID_edit');

            $reference_data = array(
                'reference_id' => $this->input->post('reference_ID_edit'),
                'time' => $this->input->post('time_edit'),
                'type' => $this->input->post('type_edit')
            );

            //Formatting time
            $date = new DateTime($reference_data['time']);
            $reference_data['time'] = $date->format('Y-m-d H:i:s');

            if($reference_data['type'] == "lecture")
            {
                $reference_data['value'] = $this->input->post('prev_lectureID_edit');
            }
            else
            {
                $reference_data['value'] = $this->input->post('link_edit');

                //If user uploaded new Image
                if(!empty($_FILES['image_Path']['name']))
                {
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
            }

            $result = sendPostRequest('api/reference/edit', $reference_data);

            if($result->status == ('error in db'))
            {
                $this->session->set_flashdata('error', 'reference');
                $this->session->set_flashdata('message', "Error in editing Reference to Database");
                redirect('reference?lecture_id='.$lecture_id);
            }

            if($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'reference');
                $this->session->set_flashdata('message', "Reference successfully edited.");
                redirect('reference?lecture_id='.$lecture_id);
            }
            else
            {
                $this->session->set_flashdata('error', 'reference');
                $this->session->set_flashdata('message', "Error in editing Reference to Database - Syntax Error");
                redirect('reference?lecture_id='.$lecture_id);
            }
        }

    }

    public function deleteReference()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        //Sending request to API
        $result = sendGetRequest('api/reference/delete?reference_id='.$_REQUEST["reference_id"]);
        if($result->status== ("success"))
        {
            $this->session->set_flashdata('success', 'reference');
            $this->session->set_flashdata('message', "Reference successfully deleted.");
            redirect('reference?lecture_id='.$_REQUEST["lecture_id"]);
        }
        else{
            $this->session->set_flashdata('error', 'reference');
            $this->session->set_flashdata('message', "Error in deleting reference");
            redirect('reference?lecture_id='.$_REQUEST["lecture_id"]);
        }
    }
}