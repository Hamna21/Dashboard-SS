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

    //Add Course form view
    public function add()
    {        //Redirect to Login page if user is not logged in
        if (!isset($_SESSION['user'])) {
            redirect('/Login');
        }
        if (!file_exists(APPPATH . 'views/pages/course/addCourseView.php')) {
            show_404();
        }

        $data['title'] = ('Course');
        $data['subtitle'] = ('Add Course');

        //Storing complete information of categories and teachers
        $data['categories'] = $this->Category_model->get_categories();
        $data['teachers'] = $this->Teacher_model->get_teachers();

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/course/addCourseView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST request on New Course submission redirects here
    public function addCourse()
    {
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $course_data = array(
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

            //Reloading add course page with same fields if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error' => 'course',
                    'message' => 'Error in registering new Course',
                    'courseName_Error' => form_error('course_Name'),
                    'courseDescription_Error' => form_error('course_Description'),
                    'categoryID_Error' => form_error('category_ID'),
                    'teacherID_Error' => form_error('teacher_ID')
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($course_data);
                redirect('/Course/add');
            }

            //Validating image and uploading it
            $image_attributes = uploadPicture();
            $imageUploadStatus = $image_attributes[0];

            //If imageValidation fails, then reload add course page with same fields
            if ($imageUploadStatus == 0) {
                $error_data = array(
                    'error' => 'course',
                    'message' => 'Error in registering new Course',
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
            //Setting image and thumbnail name
            $course_data['course_Image'] = $image_attributes[1];
            $course_data['course_ThumbImage'] = $image_attributes[2];
            // createThumbnail($image_attributes[1]);

            if ($this->Course_model->insertCourse($course_data)) {
                $this->session->set_flashdata('success', 'course');
                $this->session->set_flashdata('message', "New Course successfully added.");
                redirect('/courses');
            } else {
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
        if(!file_exists(APPPATH. 'views/pages/course/editCourseView.php'))
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
            'teacher_ID' => $course['teacher_ID']
        );

        //Setting course data - Information will be displayed on form
        $this->session->set_flashdata($course_data);

        //Setting image in userdata because required more then once
        $this->session->set_userdata('course_ThumbImage', $course['course_ThumbImage']);
        $this->session->set_userdata('course_Image', $course['course_Image']);

        $data['title'] = ('Course');
        $data['subtitle'] = ('Edit Course');
        //Storing complete information of categories and teachers
        $data['categories'] = $this->Category_model->get_categories();
        $data['teachers'] = $this->Teacher_model->get_teachers();

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/course/editCourseView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST request on Edit Course redirects here
    public function editCourse()
    {
        if($this->input->server('REQUEST_METHOD') == "POST") {
            $courseID = $this->session->course_ID;
            $course_data = array(
                'course_Description' => $this->input->post('course_Description'),
                'category_ID' => $this->input->post('category'),
                'teacher_ID' => $this->input->post('teacher')
            );

            $this->form_validation->set_data($course_data); //Setting Data
            $this->form_validation->set_rules($this->Course_model->getCourseEditRules()); //Setting Rules

            //Reloading edit course page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'course',
                    'message'     => 'Error in editing Course',
                    'courseName_Error' => form_error('course_Name'),
                    'courseDescription_Error' => form_error('course_Description'),
                    'categoryID_Error' => form_error('category_ID'),
                    'teacherID_Error' => form_error('teacher_ID')
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($course_data);
                redirect('/Course/edit?q='.$courseID);
            }

            //If user uploaded new Image
            if(!empty($_FILES['image_Path']['name']))
            {
                //Delete previous pictures from server
                unlink("uploads/".$this->session->course_ThumbImage);
                unlink("uploads/".$this->session->course_Image);

                //Validating image and uploading it
                $image_attributes = uploadPicture();
                $imageUploadStatus = $image_attributes[0];

                //If imageValidation fails, then reload add course page
                if ($imageUploadStatus == 0) {
                    $error_data = array(
                        'error'  => 'course',
                        'message'     => 'Error in registering new Course',
                        'courseName_Error' => form_error('course_Name'),
                        'courseDescription_Error' => form_error('course_Description'),
                        'courseImage_Error' => $image_attributes[1],
                        'categoryID_Error' => form_error('category_ID'),
                        'teacherID_Error' => form_error('teacher_ID')
                    );

                    $this->session->set_flashdata($error_data);
                    $this->session->set_flashdata($course_data);
                    redirect('/Course/add');
                }
                //Setting image and thumbnail uploaded path
                $course_data['course_Image'] = $image_attributes[1];
                $course_data['course_ThumbImage'] = $image_attributes[2];
                // createThumbnail($image_attributes[1]);
            }

            if ($this->Course_model->updateCourse($courseID,$course_data))
            {
                $this->session->set_flashdata('success', 'course');
                $this->session->set_flashdata('message', "Course successfully edited.");
                redirect('/courses');
            }
            else
            {
                $this->session->set_flashdata('error', 'course');
                $this->session->set_flashdata('message', "Error in editing course.");
                redirect('/courses');
            }
        }

    }

    //Delete course
    public function deleteCourse()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        $courseID = $_REQUEST["q"];
        $course= $this->Course_model->get_course($courseID);
        //Delete previous pictures from server
        unlink("uploads/".$course['course_ThumbImage']);
        unlink("uploads/".$course['course_Image']);

        if($this->Course_model->deleteCourse($courseID))
        {
            $this->session->set_flashdata('success', 'course');
            $this->session->set_flashdata('message', "Course Deleted.");
            redirect('/courses');
        }
        else{
            $this->session->set_flashdata('error', 'course');
            $this->session->set_flashdata('message', "Course Deleted.");
            redirect('/courses');
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

    public function tester2()
    {
        // First, include Requests
        // include('vendor/rmccue/requests/library/Requests.php');
        // Next, make sure Requests can load internal classes
        // Requests::register_autoloader();


        $url = 'http://localhost:8080/Second-Screen-API-v2/index.php/Course/check';
        $headers = array('Content-Type' => 'application/json', 'Authorization' => 'Basic RGV2ZWxvcGVyOjEyMzQ=');
        $data = array('name' => 'Hamna');
        $response = (Requests::post($url, $headers, json_encode($data)));
        $result = json_decode($response->body);

        echo $result->status;
    }

    public function tester3()
    {
        $session = new Requests_Session('http://localhost:8080/Second-Screen-API-v2/index.php/Course/check');
        $session->headers['Content-Type'] = 'application/json';
        $session->headers['Authorization'] = 'Basic RGV2ZWxvcGVyOjEyMzQ=';
        $response = $session->get('/zen');
        var_dump($response->body);
    }

    public function testerCourse()
    {
        // First, include Requests
         include('vendor/rmccue/requests/library/Requests.php');
        // Next, make sure Requests can load internal classes
         Requests::register_autoloader();

        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $course_data = array(
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

            //Reloading add course page with same fields if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error' => 'course',
                    'message' => 'Error in registering new Course',
                    'courseName_Error' => form_error('course_Name'),
                    'courseDescription_Error' => form_error('course_Description'),
                    'categoryID_Error' => form_error('category_ID'),
                    'teacherID_Error' => form_error('teacher_ID')
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($course_data);
                redirect('/Course/add');
            }

            $image_attributes = uploadPicture();
            $imageUploadStatus = $image_attributes[0];

            //If imageValidation fails, then reload add course page with same fields
            if ($imageUploadStatus == 0) {
                $error_data = array(
                    'error' => 'course',
                    'message' => 'Error in registering new Course',
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
            //Setting image and thumbnail name
            $image_Name = $image_attributes[1];
            $course_data['course_Image'] = 'http://localhost:8080/Dashboard-SS/uploads/'.$image_Name;

            $url = 'http://localhost:8080/Second-Screen-API-v2/index.php/Course/checkCourse';
            $headers = array('Content-Type' => 'application/json', 'Authorization' => 'Basic RGV2ZWxvcGVyOjEyMzQ=');
            $response = (Requests::post($url, $headers, json_encode($course_data)));
            $result = json_decode($response->body);

            if($result->status == ('Error in Validation'))
            {
                $error_validation = $result->error_messages;
                $error_data = array(
                    'error' => 'course',
                    'message' => 'Error in registering new Course',
                    'courseName_Error' => $error_validation->courseName_Error,
                    'courseDescription_Error' => $error_validation->courseDescription_Error,
                    'categoryID_Error' => $error_validation->categoryID_Error,
                    'teacherID_Error' => $error_validation->teacherID_Error,
                    'courseImage_Error' => $error_validation->courseImage_Error
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($course_data);
                redirect('/Course/add');
            }

            if($result->status == ('Error in DB'))
            {
                $this->session->set_flashdata('error', 'course');
                $this->session->set_flashdata('message', "Error in registering new Course to Database");
                redirect('/courses');
            }

            if($result->status == ('Success'))
            {
                $this->session->set_flashdata('success', 'course');
                $this->session->set_flashdata('message', "New Course successfully added.");
                redirect('/courses');
            }
        }
    }

}