<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'request'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Question_model');
    }

    //All Question of a quiz
    public function view()
    {
        //Redirect to Login page if user is not logged in
        if (!isset($_SESSION['user'])) {
            redirect('/Login');
        }
        if (!file_exists(APPPATH . 'views/pages/question/questionView.php')) {
            show_404();
        }

        $quiz_id = $this->input->get('quiz');
        $result = sendGetRequest('api/quiz/questions?quiz_id=' . $quiz_id);

        $data['title'] = ('Question');
        $data['subtitle'] = ('');
        if ($result->status == "success") {
            $data['questions'] = ($result->questions);
        } else
        {
            show_error("No questions found for this quiz",500,'Error');

        }
        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/question/questionView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }


    //POST direct from add question redirects here
    public function addQuestion()
    {
        if($this->input->server('REQUEST_METHOD') == "POST")
        {
            $question_data = array(
                'quiz_id' => $this->input->post('quiz_id'),
                'question_text' => $this->input->post('question_text'),
                'option_one' => $this->input->post('option_one'),
                'option_two' => $this->input->post('option_two'),
                'option_three' => $this->input->post('option_three'),
                'option_four' => $this->input->post('option_four'),
                'correct_option' => $this->input->post('correct_option')
            );



            $this->form_validation->set_data($question_data); //Setting Data
            $this->form_validation->set_rules($this->Question_model->getQuestionRegistrationRules()); //Setting Rules

            //Reloading add lecture page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'question',
                    'message'     => 'Error in registering new Question'
                );

                $this->session->set_flashdata($error_data);
                redirect('lectures');
            }

            $result = sendPostRequest('api/question/add', $question_data);

            if($result->status == ('error')) {
                $error_data = array(
                    'error'  => 'question',
                    'message'     => 'Error in registering new Question'
                );

                $this->session->set_flashdata($error_data);
                redirect('lectures');

            }

            if($result->status == ('success')) {
                $this->session->set_flashdata('success', 'question');
                $this->session->set_flashdata('message', "New Qestion successfully added.");
                redirect('/question/view?quiz='.$question_data['quiz_id']);
            }
            else
            {
                $this->session->set_flashdata('error', 'question');
                $this->session->set_flashdata('message', "Error in registering new Question to Database - Syntax Error");
                redirect('lectures');
            }


        }
    }

    public function deleteQuestion()
    {

    }

}