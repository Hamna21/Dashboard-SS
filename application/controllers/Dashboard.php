<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->library('pagination');
        $this->load->model('Course_model');
        $this->load->model('Category_model');
        $this->load->model('Teacher_model');
        $this->load->model('Lecture_model');
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
        //Getting total count of all entities stored in DB
        $data['courseTotal'] = $this->Course_model->getCourseTotal();
        $data['categoryTotal'] = $this->Category_model->getCategoryTotal();
        $data['teacherTotal'] = $this->Teacher_model->getTeacherTotal();
        $data['lectureTotal'] = $this->Lecture_model->getLectureTotal();

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
        $config["base_url"] = base_url() . "index.php/courses";
        $total_row = $this->Course_model->getCourseTotal();
        $config["total_rows"] = $total_row;
        $config['per_page'] = 3;
        $this->pagination->initialize($config);
        $page =($this->uri->segment(2)) ? ($this->uri->segment(2) -1) * 3 : 0;
        $data["links"] = $this->pagination->create_links();

        //Getting courses info from table within limit
        $data['courses'] = $this->Course_model->get_courses_limit($config['per_page'], $page);

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
        if(!file_exists(APPPATH. 'views/pages/categoryView.php'))
        {
            show_404();
        }

        $data['title'] = ('Categories');
        $data['subtitle'] = ('');

        //-----Pagination-------//
        $config["base_url"] = base_url() . "index.php/categories";
        $total_row = $this->Category_model->getCategoryTotal();
        $config["total_rows"] = $total_row;
        $config['per_page'] = 3;
        $this->pagination->initialize($config);
        $page =($this->uri->segment(2)) ? ($this->uri->segment(2) -1) * 3 : 0;
        $data["links"] = $this->pagination->create_links();
        

        //Getting all categories within limit
        $data['categories'] = $this->Category_model->get_categories_limit($config['per_page'], $page);

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/categoryView.php', $data);
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
        if(!file_exists(APPPATH. 'views/pages/teacherView.php'))
        {
            show_404();
        }
        $data['title'] = ('Teachers');
        $data['subtitle'] = ('');

        //-----Pagination-------//
        $config["base_url"] = base_url() . "index.php/teachers";
        $total_row = $this->Teacher_model->getTeacherTotal();
        $config["total_rows"] = $total_row;
        $config['per_page'] = 3;
        $this->pagination->initialize($config);
        $page =($this->uri->segment(2)) ? ($this->uri->segment(2) -1) * 3 : 0;
        $data["links"] = $this->pagination->create_links();

        //Getting teachers info within limit
        $data['teachers'] = $this->Teacher_model->get_teachers_limit($config['per_page'], $page);

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/teacherView.php', $data);
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
        if(!file_exists(APPPATH. 'views/pages/lectureView.php'))
        {
            show_404();
        }

        $data['title'] = ('Lectures');
        $data['subtitle'] = ('');

        //-----Pagination-------//
        $config["base_url"] = base_url() . "index.php/lectures";
        $total_row = $this->Lecture_model->getLectureTotal();
        $config["total_rows"] = $total_row;
        $config['per_page'] = 3;
        $this->pagination->initialize($config);
        $page =($this->uri->segment(2)) ? ($this->uri->segment(2) -1) * 3 : 0;
        $data["links"] = $this->pagination->create_links();

        //Getting lectures info within limit
        $data['lectures'] = $this->Lecture_model->get_lectures_limit($config['per_page'], $page);

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/lectureView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

}