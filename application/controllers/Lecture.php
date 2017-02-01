<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lecture extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url','request', 'video'));
        $this->load->library(array('session', 'form_validation', 'pagination'));
        $this->load->model('Lecture_model');
    }

    //Add Lecture form
    public function add()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/lecture/addLectureView.php'))
        {
            show_404();
        }

        $data['title'] = ('Lecture');
        $data['subtitle'] = ('Add Lecture');

        //Storing complete information of courses
        //Sending request to API
        $result = sendGetRequest('api/courses');
        if($result->status == ("error"))
        {
            $data['courses'] =  ('No course found');
        }
        else{
            $data['courses'] =  $result->courses;
        }

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/lecture/addLectureView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //POST request on new Lecture submission redirects here
    public function addLecture()
    {
        if($this->input->server('REQUEST_METHOD') == "POST") {
            //Acquiring data from form
            $lecture_data = array(
                'lecture_Name' => $this->input->post('lecture_Name'),
                'lecture_Description' => $this->input->post('lecture_Description'),
                'lecture_date' => $this->input->post('lecture_date'),
                'lecture_end' => $this->input->post('lecture_end'),
                'course_ID' => $this->input->post('course')
            );

            $date = new DateTime($lecture_data['lecture_date']);
            $lecture_data['lecture_date'] = $date->format('Y-m-d H:i:s');

            $time_end = new DateTime($lecture_data['lecture_end']);
            $lecture_data['lecture_end'] = $time_end->format('H:i:s');

            $this->form_validation->set_data($lecture_data); //Setting Data
            $this->form_validation->set_rules($this->Lecture_model->getLectureRegistrationRules()); //Setting Rules

            //Reloading add lecture page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'lecture',
                    'message'     => 'Error in registering new Lecture',
                    'lectureName_Error' => form_error('lecture_Name'),
                    'lectureDescription_Error' => form_error('lecture_Description'),
                    'lectureStart_Error' => form_error('lecture_start'),
                    'lectureEnd_Error' => form_error('lecture_end'),
                    'courseID_Error' => form_error('course_ID')
                );



                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($lecture_data);
                redirect('/Lecture/add');
            }

            //Video Link
            if($_POST['lecture_video_link'])
            {
                $lecture_data['lecture_video_link'] = $this->input->post('lecture_video_link');
            }


            $result = sendPostRequest('api/lecture/add', $lecture_data);
            if($result->status == ('error in validation')) {
                $error_validation = $result->error_messages;
                $error_data = array(
                    'error'  => 'lecture',
                    'message'     => 'Error in registering new Lecture',
                    'lectureName_Error' => $error_validation->lectureName_Error,
                    'lectureDescription_Error' => $error_validation->lectureDescription_Error,
                    'lectureStart_Error' => $error_validation->lectureStart_Error,
                    'lectureEnd_Error' => $error_validation->lectureEnd_Error,
                    'courseID_Error' => $error_validation->courseID_Error
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($lecture_data);
                redirect('/Lecture/add');

            }
            if($result->status == ('error in db')) {
                $this->session->set_flashdata('error', 'lecture');
                $this->session->set_flashdata('message', "Error in registering new Lecture to Database");
                redirect('/lectures');
            }
            if($result->status == ('success')) {
                $this->session->set_flashdata('success', 'lecture');
                $this->session->set_flashdata('message', "New Lectures successfully added.");
                redirect('/lectures');
            }
            else
            {
                $this->session->set_flashdata('error', 'lecture');
                $this->session->set_flashdata('message', "Error in registering new Lecture to Database - Syntax Error");
                redirect('/lectures');
            }
        }

        //Call this if a user tries to access this method from URL
        show_404();
    }

    //Edit lecture form view
    public function edit()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/lecture/editLectureView.php'))
        {
            show_404();
        }

        //Getting lecture information by ID - sending request
        $result = sendGetRequest('api/lecture_dashboard?lecture_id='.$_REQUEST["q"]);
        if($result->status== ("error"))
        {
            show_error("Lecture not found", 500, "Error");
        }

        $lecture = $result->lecture;
        $lecture_data = array(
            'lecture_ID' => $lecture->lecture_id,
            'lecture_Name' =>  $lecture->lecture_name,
            'lecture_Description' =>  $lecture->lecture_description,
            'lecture_date' =>  $lecture->lecture_date,
            'lecture_start' =>  $lecture->lecture_start,
            'lecture_end' =>  $lecture->lecture_end,
            'lecture_Domain' =>  $lecture->course_id,
            'lecture_video' => $lecture->lecture_video
        );


        //Appending lecture date and starting time
        $lecture_data['lecture_date'] = $lecture_data['lecture_date'] . " " . $lecture_data['lecture_start'];

        //Setting lecture data - Information will be displayed on form
        $this->session->set_flashdata($lecture_data);

        $data['title'] = ('Lecture');
        $data['subtitle'] = ('Edit Lecture');
        $result = sendGetRequest('api/courses');
        if($result->status == ("error"))
        {
            $data['courses'] =  ('No course found');
        }
        else{
            $data['courses'] =  $result->courses;
        }

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/lecture/editLectureView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST request on Edit lecture redirects here
    public function editLecture()
    {
        if($this->input->server('REQUEST_METHOD') == "POST") {
            $lectureID = $this->session->lecture_ID;
            $lecture_data = array(
                'lecture_ID' => $lectureID,
                'lecture_Name' => $this->input->post('lecture_Name'),
                'lecture_Description' => $this->input->post('lecture_Description'),
                'lecture_date' => $this->input->post('lecture_date'),
                'lecture_end' => $this->input->post('lecture_end'),
                'course_ID' => $this->input->post('course'),
            );

            $date = new DateTime($lecture_data['lecture_date']);
            $lecture_data['lecture_date'] = $date->format('Y-m-d H:i:s');

            $time_end = new DateTime($lecture_data['lecture_end']);
            $lecture_data['lecture_end'] = $time_end->format('H:i:s');



            $this->form_validation->set_data($lecture_data); //Setting Data
             $this->form_validation->set_rules($this->Lecture_model->getLectureEditRules()); //Setting Rules
 
             //Reloading edit lecture page if validation fails
             if ($this->form_validation->run() == FALSE) {
                 $error_data = array(
                     'error'  => 'lecture',
                     'message'     => 'Error in editing Lecture',
                     'lectureName_Error' => form_error('lecture_Name'),
                     'lectureDescription_Error' => form_error('lecture_Description'),
                     'lectureStart_Error' => form_error('lecture_start'),
                     'lectureEnd_Error' => form_error('lecture_end'),
                     'courseID_Error' => form_error('course_ID')
                 );
 
                 $this->session->set_flashdata($error_data);
                 $this->session->set_flashdata($lecture_data);
                 redirect('/lecture/edit?q='.$lectureID);
             }

            //Video Link
            if($_POST['lecture_video_link'])
            {
                $lecture_data['lecture_video_link'] = $this->input->post('lecture_video_link');
            }

            //Sending request to API
            $result = sendPostRequest('api/lecture/edit', $lecture_data);

            if($result->status == ('error in validation')) {
                $error_validation = $result->error_messages;
                $error_data = array(
                    'error'  => 'lecture',
                    'message'     => 'Error in editing Lecture',
                    'lectureName_Error' => $error_validation->lectureName_Error,
                    'lectureDescription_Error' => $error_validation->lectureDescription_Error,
                    'lectureStart_Error' => $error_validation->lectureStart_Error,
                    'lectureEnd_Error' => $error_validation->lectureEnd_Error,
                    'courseID_Error' => $error_validation->courseID_Error
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($lecture_data);
                redirect('/lecture/edit?q='.$lectureID);
            }

            if($result->status == ('error in db'))
            {
                $this->session->set_flashdata('error', 'Lecture');
                $this->session->set_flashdata('message', "Error in editing Lecture");
                redirect('/lectures');
            }

            if($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'Lecture');
                $this->session->set_flashdata('message', "Lecture successfully edited.");
                redirect('/lectures');
            }
            else
            {
                $this->session->set_flashdata('error', 'Lecture');
                $this->session->set_flashdata('message', "Error in editing Lecture-- Syntax Error");
                redirect('/lectures');
            }
        }

    }

    public function deleteLecture()
    {
        if(!$_REQUEST)
        {
            show_404();
        }

        //Sending request to API
        $result = sendGetRequest('api/lecture/delete?lecture_id='.$_REQUEST["q"]);
        if($result->status== ("success"))
        {
            $this->session->set_flashdata('success', 'lecture');
            $this->session->set_flashdata('message', "Lecture successfully deleted.");
            redirect('/lectures');
        }
        else{
            $this->session->set_flashdata('error', 'lecture');
            $this->session->set_flashdata('message', "Error in deleting lecture");
            redirect('/lectures');
        }

    }

    //All comments of a lecture by users
    public function lecture_comments()
    {
        //Redirect to Login page if user is not logged in
        if (!isset($_SESSION['user'])) {
            redirect('/Login');
        }
        if (!file_exists(APPPATH . 'views/pages/lecture/commentView.php')) {
            show_404();
        }

        if($_REQUEST)
        {
            $lecture_id = $this->input->get('lecture_id');
            $lecture_name = $this->input->get('lecture_name');
            $this->session->set_userdata('lecture_id', $lecture_id);
            $this->session->set_userdata('lecture_name', $lecture_name);
        }
        else
        {
            $lecture_id = $this->session->lecture_id;
            $lecture_name = $this->session->lecture_name;
        }
        $data['title'] = ('Comments');
        $data['subtitle'] = ('');
        $data['lecture_name'] = $lecture_name;


        //-----Pagination-------//
        $config["base_url"] = base_url() . "lecture/comments";
        $config['per_page'] = 2;
        $page =($this->uri->segment(3)) ? ($this->uri->segment(3) -1) * 2 : 0;

        //If $page = -1
        if($page < 0)
        {
            $page = 0;
        }
        $pagination_data = array(
            'limit' => $config['per_page'],
            'start' => $page,
            'lecture_id' => $lecture_id
        );


        //Sending request to API for comments
        $result = sendPostRequest('api/lecture/comments_dashboard', $pagination_data);


        if($result->status == "error")
        {
            show_error("Error",500, "No comments found for this lecture!");
        }

        $config["total_rows"] = $result->comment_total;
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['comments'] = $result->comments;

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/lecture/commentView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //Total duration of a lecture in minutes - to be used in adding lecture reference
    public function minuteCalculator()
    {
        $lecture_start = $this->input->get('lecture_start');
        $lecture_end = $this->input->get('lecture_end');
        $date1 = new DateTime($lecture_start);
        $date2 = new DateTime($lecture_end);

        $interval = $date2->diff($date1);

        $hourTominute = ($interval->h)*60;
        $secondTominute = ($interval->s)*60*60;
        $minute = ($interval->i);

        $totalMinutes = $hourTominute + $minute + $secondTominute;
        echo $totalMinutes;
    }
}