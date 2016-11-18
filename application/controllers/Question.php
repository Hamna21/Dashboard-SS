<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'request'));
        $this->load->library(array('session', 'form_validation', 'pagination'));
        $this->load->model('Question_model');
    }

    //All Question of a particular quiz
    public function view_old()
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

    //All Question of a particular quiz
    public function view()
    {
        //Redirect to Login page if user is not logged in
        if (!isset($_SESSION['user'])) {
            redirect('/Login');
        }
        if (!file_exists(APPPATH . 'views/pages/question/questionView.php')) {
            show_404();
        }

        $data['title'] = ('Question');
        $data['subtitle'] = ('');

        //get quizID sent via GET request - if empty then use the one stored in session
        //To maintain links for pagination

        if($_REQUEST)
        {
            $quiz_id = $this->input->get('quiz');
            $this->session->set_userdata('quiz_id',$quiz_id);
        }
        else
        {
            $quiz_id = $this->session->quiz_id;
        }

        $data['quiz_id'] = $quiz_id;

        //--------Pagination--------//
        $config["base_url"] = base_url() . "questions";
        $config['per_page'] = 3;
        $page =($this->uri->segment(2)) ? ($this->uri->segment(2) -1) * 3 : 0;

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

        //Getting all questions of quiz
        $result = sendPostRequest('api/quiz/questions_pagination?quiz_id=' . $quiz_id, $pagination_data);

        if($result->status == ("error")) {
            show_error("No questions found for this quiz", 500, 'Error');
        }


        $config["total_rows"] = $result->questionTotal;
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['questions'] = ($result->questions);

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
                redirect('/questions?quiz='.$question_data['quiz_id']);
            }
            else
            {
                $this->session->set_flashdata('error', 'question');
                $this->session->set_flashdata('message', "Error in registering new Question to Database - Syntax Error");
                redirect('lectures');
            }


        }
    }

    //POST direct from edit question redirects here
    public function editQuestion()
    {
        if($this->input->server('REQUEST_METHOD') == "POST")
        {
            $question_data = array(
                'question_id' => $this->input->post('question_id'),
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
                    'message'     => 'Error in editing Question'
                );

                $this->session->set_flashdata($error_data);
                redirect('/questions?quiz='.$this->session->quiz_id);
            }

            $result = sendPostRequest('api/question/edit', $question_data);

            if($result->status == ('error')) {
                $error_data = array(
                    'error'  => 'question',
                    'message'     => 'Error in editing Question'
                );

                $this->session->set_flashdata($error_data);
                redirect('/questions?quiz='.$this->session->quiz_id);

            }

            if($result->status == ('success')) {
                $this->session->set_flashdata('success', 'question');
                $this->session->set_flashdata('message', "Question successfully edited.");
                redirect('/questions?quiz='.$this->session->quiz_id);
            }
            else
            {
                $this->session->set_flashdata('error', 'question');
                $this->session->set_flashdata('message', "Error in editing question - Syntax Error");
                redirect('/questions?quiz='.$this->session->quiz_id);
            }
        }
    }

    public function deleteQuestion()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        //Sending request to API
        $result = sendGetRequest('api/question/delete?question_id='.$_REQUEST["question_id"]);
        if($result->status== ("success"))
        {
            $this->session->set_flashdata('success', 'question');
            $this->session->set_flashdata('message', "Question successfully deleted.");
            redirect('/questions?quiz='.$_REQUEST['quiz_id']);
        }
        else{
            $this->session->set_flashdata('error', 'question');
            $this->session->set_flashdata('message', "Error in deleting question");
            redirect('/questions?quiz='.$_REQUEST['quiz_id']);
        }
    }
}