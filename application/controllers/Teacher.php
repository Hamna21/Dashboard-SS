<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'image'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Teacher_model');
        $this->load->model('Category_model');
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
        $data['categories'] = $this->Category_model->get_categories();

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
                    'teacherID_Error' => form_error('teacher_ID'),
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
            $teacher_data['teacher_Image'] = $image_attributes[1];
            $teacher_data['teacher_ThumbImage'] = $image_attributes[2];

            if ($this->Teacher_model->insertTeacher($teacher_data))
            {
                $this->session->set_flashdata('success', 'teacher');
                $this->session->set_flashdata('message', "New Teacher successfully added.");
                redirect('/teachers');
            }
            else
            {
                $this->session->set_flashdata('error', 'teacher');
                $this->session->set_flashdata('message', "Error in registering new Teacher to Database");
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
        //Getting teacher information by ID
        $teacherID = $_REQUEST["q"];
        $teacher = $this->Teacher_model->get_teacher($teacherID);
        $teacher_data = array(
            'teacher_ID' => $teacher['teacher_ID'],
            'teacher_Name' =>  $teacher['teacher_Name'],
            'teacher_Designation' =>  $teacher['teacher_Designation'],
            'teacher_Domain' =>  $teacher['teacher_Domain']
        );

        //Setting teacher data - Information will be displayed on form
        $this->session->set_flashdata($teacher_data);

        //Setting Image in user-data because required more then once!
        $this->session->set_userdata('teacher_ThumbImage', $teacher['teacher_ThumbImage']);
        $this->session->set_userdata('teacher_Image', $teacher['teacher_Image']);

        $data['title'] = ('Teacher');
        $data['subtitle'] = ('Edit Teacher');
        $data['categories'] = $this->Category_model->get_categories();

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
                //Deleting previous images from server
                unlink("uploads/".$this->session->teacher_ThumbImage);
                unlink("uploads/".$this->session->teacher_Image);

                //Validating image and uploading it
                $image_attributes = uploadPicture();
                $imageUploadStatus = $image_attributes[0];

                //If imageValidation fails, then reload add teacher page
                if ($imageUploadStatus == 0) {
                    $error_data = array(
                        'error'  => 'teacher',
                        'message'     => 'Error in registering new teacher',
                        'teacherName_Error' => form_error('teacher_Name'),
                        'teacherImage_Error' => $image_attributes[1]
                    );

                    $this->session->set_flashdata($error_data);
                    $this->session->set_flashdata($teacher_data);
                    redirect('/Teacher/add');
                }
                //Setting image uploaded path
                $teacher_data['teacher_Image'] = $image_attributes[1];
                $teacher_data['teacher_ThumbImage'] = $image_attributes[2];
                // createThumbnail($image_attributes[1]);
            }

            if ($this->Teacher_model->updateteacher($teacherID,$teacher_data))
            {
                $this->session->set_flashdata('success', 'teacher');
                $this->session->set_flashdata('message', "Teacher successfully edited.");
                redirect('/teachers');
            }
            else
            {
                $this->session->set_flashdata('error', 'teacher');
                $this->session->set_flashdata('message', "Error in editing Teacher");
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
        $teacherID = $_REQUEST["q"];
        if($this->Teacher_model->deleteTeacher($teacherID))
        {
            $this->session->set_flashdata('success', 'teacher');
            $this->session->set_flashdata('message', "Teacher successfully Deleted.");
            redirect('/teachers');
        }
        else{
            $this->session->set_flashdata('error', 'course');
            $this->session->set_flashdata('message', "Error in deleting teacher");
            redirect('/teachers');
        }

    }

}