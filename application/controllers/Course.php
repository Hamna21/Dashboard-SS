<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'image', 'request'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Course_model');
    }

    //Add Course form view
    public function add()
    {
        //Redirect to Login page if user is not logged in
        if (!isset($_SESSION['user'])) {
            redirect('/Login');
        }
        if (!file_exists(APPPATH . 'views/pages/course/addCourseView.php')) {
            show_404();
        }

        $data['title'] = ('Course');
        $data['subtitle'] = ('Add Course');

        //Sending request to API
        $result = sendGetRequest('api/categories_teachers');
        if($result->status == ("error"))
        {
            show_error("Add categories and teachers first" ,500, "Failure");
        }
        else{
            $data['categories'] =  $result->categories;
            $data['teachers'] =  $result->teachers;
        }

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
            $course_data['course_Image'] = base_url().'/uploads/'.$image_Name;

            $result = sendPostRequest('api/course/add', $course_data);

            if($result->status == ('error in validation'))
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

            if($result->status == ('error in db'))
            {
                $this->session->set_flashdata('error', 'course');
                $this->session->set_flashdata('message', "Error in registering new Course to Database");
                redirect('/courses');
            }

            if($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'course');
                $this->session->set_flashdata('message', "New Course successfully added.");
                redirect('/courses');
            }
            else{
                $this->session->set_flashdata('error', 'course');
                $this->session->set_flashdata('message', "Error in registering new Course to Database - Syntax Error");
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

        //Getting course information by ID - sending request
        $result = sendGetRequest('api/course/join?course_id='.$_REQUEST["q"]);
        if($result->status== ("error"))
        {
            show_error("Course not found", 500, "Error");
        }

        $course = $result->course;
        $course_data = array(
            'course_ID' => $course->course_id,
            'course_Name' =>  $course->course_name,
            'course_Description' => $course->course_description,
            'category_Name' => $course->category_name,
            'teacher_Name' => $course->teacher_name,
            'category_ID' => $course->category_id,
            'teacher_ID' => $course->teacher_id
        );

        //Setting course data - Information will be displayed on form
        $this->session->set_flashdata($course_data);

        //Setting image in userdata because required more then once
        $this->session->set_userdata('course_ThumbImage', $course->course_thumbimage);
        $this->session->set_userdata('course_Image', $course->course_image);

        $data['title'] = ('Course');
        $data['subtitle'] = ('Edit Course');

        //Sending request to API - storing complete information of categories and teachers
        $result = sendGetRequest('api/categories_teachers');
        if($result->status == ("error"))
        {
            show_error("Please add teachers and categories first.", 500, 'Failure');
        }
        else{
            $data['categories'] =  $result->categories;
            $data['teachers'] =  $result->teachers;
        }

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
                'course_ID' => $courseID,
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
                        'teacherID_Error' => form_error('teacher_ID')
                    );

                    $this->session->set_flashdata($error_data);
                    $this->session->set_flashdata($course_data);
                    redirect('/Course/edit?q='.$courseID);
                }

                //Delete previous pictures from server and setting path for API server
                unlink("uploads/".$this->session->course_Image);

                $course_data['course_PrevImage'] = $this->session->course_Image;
                $course_data['course_PrevThumbImage'] = $this->session->course_ThumbImage;

                //Setting image uploaded path
                $image_Name = $image_attributes[1];
                $course_data['course_Image'] = base_url().'/uploads/'.$image_Name;
            }


            $result = sendPostRequest('api/course/edit', $course_data);

            if($result->status == ('error in validation'))
            {
                $error_validation = $result->error_messages;
                $error_data = array(
                    'error' => 'course',
                    'message' => 'Error in editing Course',
                    'courseDescription_Error' => $error_validation->courseDescription_Error,
                    'categoryID_Error' => $error_validation->categoryID_Error,
                    'teacherID_Error' => $error_validation->teacherID_Error
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($course_data);
                redirect('/Course/edit?q='.$courseID);
            }

            if($result->status == ('error in db'))
            {
                $this->session->set_flashdata('error', 'course');
                $this->session->set_flashdata('message', "Error in editing course.");
                redirect('/courses');
            }

            if($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'course');
                $this->session->set_flashdata('message', "Course successfully edited.");
                redirect('/courses');
            }
            else{
                $this->session->set_flashdata('error', 'course');
                $this->session->set_flashdata('message', "Error in editing course ---- Syntax error.");
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

        //Sending request to API
        $result = sendGetRequest('api/course/delete?course_id='.$_REQUEST["q"]);
        if($result->status== ("success"))
        {
            $this->session->set_flashdata('success', 'course');
            $this->session->set_flashdata('message', "Course successfully Deleted.");
            redirect('/courses');
        }
        else{
            $this->session->set_flashdata('error', 'course');
            $this->session->set_flashdata('message', "Error in deleting course");
            redirect('/courses');
        }

    }

}