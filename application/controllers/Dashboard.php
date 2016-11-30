<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'request'));
        $this->load->library(array('session', 'form_validation', 'pagination'));
    }

    //Dashboard Page
    public function index()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/dashboardView.php'))
        {
            show_404();
        }

        $data['title'] = ('Dashboard');
        $data['subtitle'] = ('Second Screen');

        //Sending request to API - Getting total count of all elements
        $result = sendGetRequest('api/totalCount');
        if($result->status == ("error"))
        {
            show_error("Error in retrieving total count",500, "Error");
        }
        //Getting total count of all entities stored in DB
        $data['courseTotal'] = $result->courseTotal;
        $data['categoryTotal'] = $result->categoryTotal;
        $data['teacherTotal'] = $result->teacherTotal;
        $data['lectureTotal'] = $result->lectureTotal;

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/dashboardView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //Courses
    public function courses()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');

        }
        if(!file_exists(APPPATH. 'views/pages/course/courseView.php'))
        {
            show_404();
        }
        $data['title'] = ('Courses');
        $data['subtitle'] = ('');

        //-----Pagination-------//
        $config["base_url"] = base_url() . "courses";
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

        //-----Sending request to API-----//
        $result = sendPostRequest('api/courses/dashboard',$pagination_data);

        if($result->status == ("error"))
        {
            show_error("Error in courses.", "500", "Unauthorized.");
        }

        $config["total_rows"] = $result->courseTotal;
        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();
        $data['courses'] = $result->courses;

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/course/courseView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //Categories
    public function categories()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');

        }
        if(!file_exists(APPPATH. 'views/pages/category/categoryView.php'))
        {
            show_404();
        }

        $data['title'] = ('Categories');
        $data['subtitle'] = ('');

        //-----Pagination-------//
        $config["base_url"] = base_url() . "categories";
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

        //-----Sending request to API-----//
        $result = sendPostRequest('api/categories/dashboard',$pagination_data);
        if($result->status == ("error"))
        {
            show_error("Error in categories.", "500", "Unauthorized.");
        }

        $config["total_rows"] = $result->categoryTotal;
        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();
        $data['categories'] = $result->categories;

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/category/categoryView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //Teachers
    public function teachers()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/teacher/teacherView.php'))
        {
            show_404();
        }
        $data['title'] = ('Teachers');
        $data['subtitle'] = ('');

        //-----Pagination-------//
        $config["base_url"] = base_url() . "teachers";
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

        //-----Sending request to API-----//
        $result = sendPostRequest('api/teachers/dashboard',$pagination_data);
        if($result->status == ("error"))
        {
            show_error("Error in teachers.", "500", "Unauthorized.");
        }

        $config["total_rows"] = $result->teacherTotal;
        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();
        $data['teachers'] = $result->teachers;

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/teacher/teacherView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //Lectures
    public function lectures()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/lecture/lectureView.php'))
        {
            show_404();
        }

        $data['title'] = ('Lectures');
        $data['subtitle'] = ('');

        //-----Pagination-------//
        $config["base_url"] = base_url() . "lectures";
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

        //-----Sending request to API-----//
        $result = sendPostRequest('api/lectures/dashboard',$pagination_data);
        if($result->status == ("error"))
        {
            show_error("Error in lectures.", "500", "Unauthorized.");
        }

        $config["total_rows"] = $result->lectureTotal;
        $this->pagination->initialize($config);

        $data["links"] = $this->pagination->create_links();
        $data['lectures'] = $result->lectures;

        //Sending request to API - for all lectures - to be used in Reference
        $result = sendGetRequest('api/lectures_reference');
        $data['lectures_reference'] = $result->lectures;

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/lecture/lectureView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

}