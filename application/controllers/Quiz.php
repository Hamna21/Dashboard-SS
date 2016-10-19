<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Quiz_model');
    }


    //Single Quiz View
    public function view()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/quiz/quizView.php'))
        {
            show_404();
        }

        $data['title'] = ('Quiz');
        $data['subtitle'] = ('');

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/quiz/quizView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //Add quiz form page
    public function add()
    {
        //Redirect to Login page if user is not logged in
        if (!isset($_SESSION['user'])) {
            redirect('/Login');
        }
        if (!file_exists(APPPATH . 'views/pages/quiz/addQuizView.php')) {
            show_404();
        }

        $data['title'] = ('Quiz');
        $data['subtitle'] = ('Add Quiz');

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/quiz/addQuizView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //POST direct from add quiz redirects here
    public function addQuiz()
    {

    }

    public function deleteQuiz()
    {

    }

}