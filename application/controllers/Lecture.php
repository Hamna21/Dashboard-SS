<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lecture extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Lecture_model');
        $this->load->model('Course_model');
    }

    //New Lecture add form
    public function add()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/addLectureView.php'))
        {
            show_404();
        }

        $data['title'] = ('Lecture');
        $data['subtitle'] = ('Add Lecture');

        //Storing complete information of courses
        $data['courses'] = $this->Course_model->get_courses();

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/addLectureView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //POST request on new Lecture submission redirects here
    public function addLecture()
    {
        if($this->input->server('REQUEST_METHOD') == "POST") {
            //Acquiring data from form
            $lecture_data = array(
                'lecture_ID' => $this->input->post('lecture_ID'),
                'lecture_Name' => $this->input->post('lecture_Name'),
                'lecture_Description' => $this->input->post('lecture_Description'),
                'lecture_Time' => $this->input->post('lecture_Time'),
                'course_ID' => $this->input->post('course'),
            );

            $this->form_validation->set_data($lecture_data); //Setting Data
            $this->form_validation->set_rules($this->Lecture_model->getLectureRegistrationRules()); //Setting Rules

            //Reloading add lecture page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'lecture',
                    'message'     => 'Error in registering new Lecture',
                    'lectureID_Error' => form_error('lecture_ID'),
                    'lectureName_Error' => form_error('lecture_Name'),
                    'lectureDescription_Error' => form_error('lecture_Description'),
                    'lectureTime_Error' => form_error('lecture_Time'),
                    'courseID_Error' => form_error('course_ID'),
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($lecture_data);
                redirect('/Lecture/add');
            }

            if ($this->Lecture_model->insertLecture($lecture_data))
            {
                $this->session->set_flashdata('success', 'course');
                $this->session->set_flashdata('message', "New Lectures successfully added.");
                redirect('/lectures');
            }
            else
            {
                $this->session->set_flashdata('error', 'lecture');
                $this->session->set_flashdata('message', "Error in registering new Lecture to Database");
                redirect('/lectures');
            }
        }

        //Call this if a user tries to access this method from URL
        show_404();
    }

    //Checking if ID is already in DB
    public function lectureIDExist()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        $lectureID = $_REQUEST["q"];
        $result = $this->Lecture_model->getLecture_ID($lectureID);
        echo $result;
    }

    //Checking if Name is already in DB
    public function lectureNameExist()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        $lectureName = $_REQUEST["q"];
        $result = $this->Lecture_model->getLecture_Name($lectureName);
        echo $result;
    }

}