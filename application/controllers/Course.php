<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'image'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Course_model');
        $this->load->model('Category_model');
        $this->load->model('Teacher_model');
    }

    //Add new Course form view
    public function add()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/addCourseView.php'))
        {
            show_404();
        }

        $data['title'] = ('Course');
        $data['subtitle'] = ('Add Course');

        //Storing complete information of categories and teachers
        $data['categories'] = $this->Category_model->get_categories();
        $data['teachers'] = $this->Teacher_model->get_teachers();

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/addCourseView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //POST request on New Course submission redirects here
    public function addCourse()
    {
        if($this->input->server('REQUEST_METHOD') == "POST") {
            $course_data = array(
                'course_ID' => $this->input->post('course_ID'),
                'course_Name' => $this->input->post('course_Name'),
                'course_Description' => $this->input->post('course_Description'),
                'category_ID' => $this->input->post('category'),
                'teacher_ID' => $this->input->post('teacher')
            );

            $this->form_validation->set_data($course_data); //Setting Data
            $this->form_validation->set_rules($this->Course_model->getCourseRegistrationRules()); //Setting Rules

            //Setting Image Rule - Required
            if (empty($_FILES['image_Path']['name'])) {
                $this->form_validation->set_rules('image_Path', 'Image', 'required');
            }

            //Reloading add course page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'course',
                    'message'     => 'Error in registering new Course',
                    'courseID_Error' => form_error('course_ID'),
                    'courseName_Error' => form_error('course_Name'),
                    'courseDescription_Error' => form_error('course_Description'),
                    'categoryID_Error' => form_error('category_ID'),
                    'teacherID_Error' => form_error('teacher_ID'),
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($course_data);
                redirect('/Course/add');
            }

            //Validating image and uploading it
            $image_attributes = uploadPicture();
            $imageUploadStatus = $image_attributes[0];

            //If imageValidation fails, then reload add course page
            if ($imageUploadStatus == 0) {
                $error_data = array(
                    'error'  => 'course',
                    'message'     => 'Error in registering new Course',
                    'courseID_Error' => form_error('course_ID'),
                    'courseName_Error' => form_error('course_Name'),
                    'courseDescription_Error' => form_error('course_Description'),
                    'courseImage_Error' => $image_attributes[1],
                    'categoryID_Error' => form_error('category_ID'),
                    'teacherID_Error' => form_error('teacher_ID'),
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($course_data);
                redirect('/Course/add');
            }
            //Setting image uploaded path
            $course_data['course_Image'] = $image_attributes[1];

            if ($this->Course_model->insertCourse($course_data))
            {
                $this->session->set_flashdata('success', 'course');
                $this->session->set_flashdata('message', "New Course successfully added.");
                redirect('/courses');
            }
            else
            {
                $this->session->set_flashdata('error', 'course');
                $this->session->set_flashdata('message', "Error in registering new Course to Database");
                redirect('/courses');
            }
        }

    }

    //Edit course form view
    public function edit()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/editCourseView.php'))
        {
            show_404();
        }
        //Getting course information by ID
        $courseID = $_REQUEST["q"];
        $course = $this->Course_model->get_course($courseID);
        $course_data = array(
            'course_ID' => $course['course_ID'],
            'course_Name' =>  $course['course_Name'],
            'course_Description' => $course['course_Description'],
            'category_Name' => $course['category_Name'],
            'teacher_Name' => $course['teacher_Name'],
            'category_ID' => $course['category_ID'],
            'teacher_ID' => $course['teacher_ID'],
            'course_Image' => $course['course_Image']
        );

        //Setting course data - Information will be displayed on form
        $this->session->set_flashdata($course_data);

        $data['title'] = ('Course');
        $data['subtitle'] = ('Edit Course');
        //Storing complete information of categories and teachers
        $data['categories'] = $this->Category_model->get_categories();
        $data['teachers'] = $this->Teacher_model->get_teachers();

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/editCourseView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST request on Edit Course redirects here
    public function editCourse()
    {
        if($this->input->server('REQUEST_METHOD') == "POST") {
            $courseID = $this->input->post('course_ID');
            $course_data = array(
                'course_Description' => $this->input->post('course_Description'),
                'category_ID' => $this->input->post('category'),
                'teacher_ID' => $this->input->post('teacher')
            );

            $this->form_validation->set_data($course_data); //Setting Data
            $this->form_validation->set_rules($this->Course_model->getCourseEditRules()); //Setting Rules

            //Setting Image Rule - Required
            if (empty($_FILES['image_Path']['name'])) {
                $this->form_validation->set_rules('image_Path', 'Image', 'required');
            }

            //Reloading edit course page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'course',
                    'message'     => 'Error in editing Course',
                    'courseName_Error' => form_error('course_Name'),
                    'courseDescription_Error' => form_error('course_Description'),
                    'categoryID_Error' => form_error('category_ID'),
                    'teacherID_Error' => form_error('teacher_ID'),
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($course_data);
                redirect('/Course/edit?q='.$courseID);
            }

            //Validating image and uploading it
            $image_attributes = uploadPicture();
            $imageUploadStatus = $image_attributes[0];

            //If imageValidation fails, then reload add course page
            if ($imageUploadStatus == 0) {
                $error_data = array(
                    'error'  => 'course',
                    'message'     => 'Error in editing Course',
                    'courseName_Error' => form_error('course_Name'),
                    'courseDescription_Error' => form_error('course_Description'),
                    'courseImage_Error' => $image_attributes[1],
                    'categoryID_Error' => form_error('category_ID'),
                    'teacherID_Error' => form_error('teacher_ID'),
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($course_data);
                redirect('/Course/edit?q=3');
            }
            //Setting image uploaded path
            $course_data['course_Image'] = $image_attributes[1];

            if ($this->Course_model->updateCourse($courseID,$course_data))
            {
                $this->session->set_flashdata('success', 'course');
                $this->session->set_flashdata('message', "Course successfully edited.");
                redirect('/courses');
            }
            else
            {
                $this->session->set_flashdata('error', 'course');
                $this->session->set_flashdata('message', "Error in editing course");
                redirect('/courses');
            }
        }

    }

    //Checking if ID is already in DB
    public function courseIDExist()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        $courseID = $_REQUEST["q"];
        $result = $this->Course_model->getCourse_ID($courseID);
        echo $result;
    }

    //Checking if Name is already in DB
    public function courseNameExist()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        $courseName = $_REQUEST["q"];
        $result = $this->Course_model->getCourse_Name($courseName);
        echo $result;
    }

    public function deleteCourse()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        $courseID = $_REQUEST["q"];
        echo $courseID;
    }
}