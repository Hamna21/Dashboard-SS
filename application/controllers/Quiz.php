<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'request'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Quiz_model');
    }


    //Quiz View of a all quizzes in a lecture
    public function view()
    {
        //Redirect to Login page if user is not logged in
        if (!isset($_SESSION['user'])) {
            redirect('/Login');
        }
        if (!file_exists(APPPATH . 'views/pages/quiz/quizView.php')) {
            show_404();
        }

        $lecture_id = $this->input->get('lecture');

        //Getting lecture name, all quizzes of that lecture and number of questions in each quiz
        $result = sendGetRequest('api/lecture/quiz?lecture_id=' . $lecture_id);

        $data['title'] = ('Quiz');
        $data['subtitle'] = ('');
        if ($result->status == "success") {
            $data['quizzes'] = ($result->quizzes);
            $data['lecture'] = ($result->lecture);
        } else
        {
            show_error("No quizzes found for this lecture",500,'Error');

        }
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/quiz/quizView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST direct from add quiz redirects here
    public function addQuiz()
    {
        if($this->input->server('REQUEST_METHOD') == "POST")
        {
            $quiz_data = array(
                'lecture_id' => $this->input->post('lecture_id'),
                'quiz_time' => $this->input->post('quiz_time'),
                'quiz_duration' => $this->input->post('quiz_duration')
            );

            $date = new DateTime($quiz_data['quiz_time']);
            $quiz_data['quiz_time'] = $date->format('Y-m-d H:i:s');

            $this->form_validation->set_data($quiz_data); //Setting Data
            $this->form_validation->set_rules($this->Quiz_model->getQuizRegistrationRules()); //Setting Rules

            //Reloading add lecture page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'quiz',
                    'message'     => 'Error in registering new Quiz'
                );

                $this->session->set_flashdata($error_data);
                redirect('lectures');
            }

            $result = sendPostRequest('api/quiz/add', $quiz_data);

            if($result->status == ('error')) {
                $error_data = array(
                    'error'  => 'quiz',
                    'message'     => 'Error in registering new Quiz'
                );

                $this->session->set_flashdata($error_data);
                redirect('lectures');

            }

            if($result->status == ('success')) {
                $this->session->set_flashdata('success', 'quiz');
                $this->session->set_flashdata('message', "New Quiz successfully added.");
                redirect('/quiz/view?lecture='.$quiz_data['lecture_id']);
            }
            else
            {
                $this->session->set_flashdata('error', 'quiz');
                $this->session->set_flashdata('message', "Error in registering new Quiz to Database - Syntax Error");
                redirect('lectures');
            }


        }
    }

    public function editQuiz()
    {

    }

    public function deleteQuiz()
    {

    }

}