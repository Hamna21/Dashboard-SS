<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'image', 'request'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Teacher_model');
    }

    //Add Teacher form
    public function add()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/teacher/addTeacherView.php'))
        {
            show_404();
        }

        $data['title'] = ('Teacher');
        $data['subtitle'] = ('Add Teacher');

        //Sending request to API
        $result = sendGetRequest('api/categories');
        if($result->status == ("error"))
        {
            $data['categories'] =  ('No category found');
        }
        else{
            $data['categories'] =  $result->categories;
        }

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/teacher/addTeacherView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //POST request on New Teacher form submission redirects here
    public function addTeacher()
    {
        if($this->input->server('REQUEST_METHOD')== 'POST') {
            $teacher_data = array(
                'teacher_Name' => $this->input->post('teacher_Name'),
                'teacher_Designation' => $this->input->post('teacher_Designation'),
                'teacher_Domain' => $this->input->post('teacher_Domain')
            );

            $this->form_validation->set_data($teacher_data); //Setting Data
            $this->form_validation->set_rules($this->Teacher_model->getTeacherRegistrationRules()); //Setting Rules

            //Setting Image Rule - Required
            if (empty($_FILES['image_Path']['name'])) {
                $this->form_validation->set_rules('image_Path', 'Image', 'required');
            }

            //Reloading form page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'teacher',
                    'message' => 'Error in registering new Teacher',
                    'teacherName_Error' => form_error('teacher_Name'),
                    'teacherDesignation_Error' => form_error('teacher_Designation'),
                    'teacherDomain_Error' => form_error('teacher_Domain'),
                    'teacherImage_Error' => form_error('image_Path')
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($teacher_data);
                redirect('/Teacher/add');
            }

            //Validating image and uploading it
            $image_attributes = uploadPicture();
            $imageUploadStatus = $image_attributes[0];

            //If imageValidation fails, then exit!
            if ($imageUploadStatus == 0) {
                $error_data = array(
                    'error'  => 'teacher',
                    'message' => 'Error in registering new Teacher',
                    'teacherID_Error' => form_error('teacher_ID'),
                    'teacherName_Error' => form_error('teacher_Name'),
                    'teacherDesignation_Error' => form_error('teacher_Designation'),
                    'teacherDomain_Error' => form_error('teacher_Domain'),
                    'teacherImage_Error' => $image_attributes[1]
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($teacher_data);
                redirect('/Teacher/add');
            }

            //Setting image uploaded path
            $image_Name = $image_attributes[1];
            $teacher_data['teacher_Image'] = base_url().'/uploads/'.$image_Name;

            //Sending request to API
            $result = sendPostRequest('api/teacher/add', $teacher_data);

            if($result->status == ('error in validation')) {
                $error_validation = $result->error_messages;
                $error_data = array(
                    'error'  => 'teacher',
                    'message' => 'Error in registering new Teacher',
                    'teacherName_Error' => $error_validation->teacherName_Error,
                    'teacherDesignation_Error' => $error_validation->teacherDesignation_Error,
                    'teacherDomain_Error' => $error_validation->teacherDomain_Error,
                    'teacherImage_Error' => $error_validation->teacherImage_Error
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($teacher_data);
                redirect('/teacher/add');

            }
            if($result->status == ('error in db'))
            {
                $this->session->set_flashdata('error', 'teacher');
                $this->session->set_flashdata('message', "Error in registering new Teacher to Database");
                redirect('/teachers');
            }
            if($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'teacher');
                $this->session->set_flashdata('message', "New Teacher successfully added.");
                redirect('/teachers');
            }
            else{
                $this->session->set_flashdata('error', 'teacher');
                $this->session->set_flashdata('message', "Error -- Couldn't perform operation--Syntax Error");
                redirect('/teachers');
            }
        }
        //Call this if a user tries to access this method from URL
        show_404();
    }

    //Edit teacher form view
    public function edit()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/teacher/editTeacherView.php'))
        {
            show_404();
        }

        //Getting teacher information by ID - sending request
        $result = sendGetRequest('api/teacher/?teacher_id='.$_REQUEST["q"]);
        if($result->status== ("error"))
        {
            show_error("Teacher not found", 500, "Error");
        }

        $teacher= $result->teacher;
        $teacher_data = array(
            'teacher_ID' => $teacher->teacher_id,
            'teacher_Name' =>  $teacher->teacher_name,
            'teacher_Designation' =>  $teacher->teacher_designation,
            'teacher_Domain' =>  $teacher->teacher_domain
        );

        //Setting teacher data - Information will be displayed on form
        $this->session->set_flashdata($teacher_data);

        //Setting Image in user-data because required more then once!
        $this->session->set_userdata('teacher_ThumbImage', $teacher->teacher_thumbimage);
        $this->session->set_userdata('teacher_Image', $teacher->teacher_image);

        $data['title'] = ('Teacher');
        $data['subtitle'] = ('Edit Teacher');
        //Sending request to API
        $result = sendGetRequest('api/categories');

        if($result->status == ("error"))
        {
            $data['categories'] =  ('No category found');
        }
        else{
            $data['categories'] =  $result->categories;
        }

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/teacher/editTeacherView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST request on Edit teacher redirects here
    public function editTeacher()
    {
        if($this->input->server('REQUEST_METHOD') == "POST") {
            $teacherID = $this->session->teacher_ID;
            $teacher_data = array(
                'teacher_ID' => $teacherID,
                'teacher_Name' => $this->input->post('teacher_Name'),
                'teacher_Designation' => $this->input->post('teacher_Designation'),
                'teacher_Domain' => $this->input->post('teacher_Domain')
            );

             $this->form_validation->set_data($teacher_data); //Setting Data
             $this->form_validation->set_rules($this->Teacher_model->getTeacherEditRules()); //Setting Rules
 
             //Reloading edit teacher page if validation fails
             if ($this->form_validation->run() == FALSE) {
                 $error_data = array(
                     'error'  => 'teacher',
                     'message'     => 'Error in editing Teacher',
                     'teacherName_Error' => form_error('teacher_Name'),
                     'teacherDesignation_Error' => form_error('teacher_Designation'),
                     'teacherDomain_Error' => form_error('teacher_Domain')
                 );
 
                 $this->session->set_flashdata($error_data);
                 $this->session->set_flashdata($teacher_data);
                 redirect('/Teacher/edit?q='.$teacherID);
             }

             //If new Image uploaded
            if(!empty($_FILES['image_Path']['name']))
            {
                //Validating image and uploading it
                $image_attributes = uploadPicture();
                $imageUploadStatus = $image_attributes[0];

                //If imageValidation fails, then reload add teacher page
                if ($imageUploadStatus == 0) {
                    $error_data = array(
                        'error'  => 'teacher',
                        'message'     => 'Error in editing teacher',
                        'teacherName_Error' => form_error('teacher_Name'),
                        'teacherImage_Error' => $image_attributes[1]
                    );

                    $this->session->set_flashdata($error_data);
                    $this->session->set_flashdata($teacher_data);
                    redirect('/Teacher/edit?q='.$teacherID);
                }

                //New image successfully uploaded on web server

                //Deleting images from web server and setting path for API server
                unlink("uploads/".$this->session->teacher_Image);
                $teacher_data['teacher_PrevImage'] = $this->session->teacher_Image;
                $teacher_data['teacher_PrevThumbImage'] = $this->session->teacher_ThumbImage;

                //Setting image uploaded path
                $image_Name = $image_attributes[1];
                $teacher_data['teacher_Image'] = base_url().'/uploads/'.$image_Name;
            }

            //Sending request to API
            $result = sendPostRequest('api/teacher/edit', $teacher_data);
            if($result->status == ('error in validation'))
            {
                $error_validation = $result->error_messages;
                $error_data = array(
                    'error'  => 'teacher',
                    'message'     => 'Error in editing Teacher',
                    'teacherName_Error' => $error_validation->teacherName_Error,
                    'teacherDesignation_Error' => $error_validation->teacherDesignation_Error,
                    'teacherDomain_Error' => $error_validation->teacherDomain_Error
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($teacher_data);
                redirect('/Teacher/edit?q='.$teacherID);
            }
            if($result->status == ('error in db'))
            {
                $this->session->set_flashdata('error', 'teacher');
                $this->session->set_flashdata('message', "Error in editing Teacher");
                redirect('/teachers');
            }
            if($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'teacher');
                $this->session->set_flashdata('message', "Teacher successfully edited.");
                redirect('/teachers');
            }
            else{
                $this->session->set_flashdata('error', 'teacher');
                $this->session->set_flashdata('message', "Error -- Couldn't perform operation--syntax error");
                redirect('/teachers');
            }
        }

    }

    //Delete Teacher
    public function deleteTeacher()
    {
        if(!$_REQUEST)
        {
            show_404();
        }

        //Sending request to API
        $result = sendGetRequest('api/teacher/delete?teacher_id='.$_REQUEST["q"]);
        if($result->status== ("success"))
        {
            $this->session->set_flashdata('success', 'teacher');
            $this->session->set_flashdata('message', "Teacher successfully Deleted.");
            redirect('/teachers');
        }
        else{
            $this->session->set_flashdata('error', 'teacher');
            $this->session->set_flashdata('message', "Error in deleting teacher");
            redirect('/teachers');
        }
    }

}