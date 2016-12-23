<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'request'));
        $this->load->library(array('session', 'form_validation', 'pagination'));
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

        $data['title'] = ('Quiz');
        $data['subtitle'] = ('');

        //get lectureID sent via GET request - if empty then use the one stored in session
        //To maintain links for pagination using session one

        if($_REQUEST)
        {
            $lecture_id = $this->input->get('lecture');
            $this->session->set_userdata('lecture_id',$lecture_id);
        }
        else
        {
            $lecture_id = $this->session->lecture_id;
        }

        //--------Pagination--------//
        $config["base_url"] = base_url() . "quiz";
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

        //Getting lecture name, all quizzes of that lecture
        $result = sendPostRequest('api/lecture/quiz_pagination?lecture_id=' . $lecture_id, $pagination_data);

        if($result->status == ("error")) {
            show_error("No quizzes found for this lecture", 500, 'Error');
        }


        $config["total_rows"] = $result->quizTotal;
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();

        $data['quizzes'] = ($result->quizzes);
        $data['lecture'] = ($result->lecture);

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/quiz/quizView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST direct from add quiz redirects here
    //Request from Lecture page
    public function addQuiz()
    {
        if($this->input->server('REQUEST_METHOD') == "POST")
        {
            $quiz_data = array(
                'lecture_id' => $this->input->post('lecture_id'),
                'quiz_title' => $this->input->post('quiz_title'),
                'quiz_time' => $this->input->post('quiz_time'),
                'quiz_duration' => $this->input->post('quiz_duration')
            );

            $date = new DateTime($quiz_data['quiz_time']);
            $quiz_data['quiz_time'] = $date->format('Y-m-d H:i:s');

            $this->form_validation->set_data($quiz_data); //Setting Data
            $this->form_validation->set_rules($this->Quiz_model->getQuizRegistrationRules()); //Setting Rules

            //Reloading lecture page if validation fails
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
                    'message' => 'Error in registering new Quiz'
                );

                $this->session->set_flashdata($error_data);
                redirect('lectures');

            }

            if($result->status == ('success')) {
                $this->session->set_flashdata('success', 'quiz');
                $this->session->set_flashdata('message', "New Quiz successfully added.");
                redirect('quiz/view?lecture='.$quiz_data['lecture_id']);
            }
            else
            {
                $this->session->set_flashdata('error', 'quiz');
                $this->session->set_flashdata('message', "Error in registering new Quiz to Database - Syntax Error");
                redirect('lectures');
            }


        }
    }

    //POST direct from add quiz redirects here
    //Request from Quiz page
    public function addQuizfromQuiz()
    {
        if($this->input->server('REQUEST_METHOD') == "POST")
        {
            $quiz_data = array(
                'lecture_id' => $this->input->post('lecture_id'),
                'quiz_title' => $this->input->post('quiz_title'),
                'quiz_time' => $this->input->post('quiz_time'),
                'quiz_duration' => $this->input->post('quiz_duration')
            );

            $date = new DateTime($quiz_data['quiz_time']);
            $quiz_data['quiz_time'] = $date->format('Y-m-d H:i:s');

            $this->form_validation->set_data($quiz_data); //Setting Data
            $this->form_validation->set_rules($this->Quiz_model->getQuizRegistrationRules()); //Setting Rules

            //Reloading quizzes page if validation fails
            if ($this->form_validation->run() == FALSE)
            {
                $error_data = array(
                    'error'  => 'quiz',
                    'message'     => 'Error in registering new Quiz'
                );

                $this->session->set_flashdata($error_data);
                redirect('quiz/view?lecture='.$quiz_data['lecture_id']);
            }

            $result = sendPostRequest('api/quiz/add', $quiz_data);

            if($result->status == ('error'))
            {
                $error_data = array(
                    'error'  => 'quiz',
                    'message' => 'Error in registering new Quiz'
                );

                $this->session->set_flashdata($error_data);
                redirect('quiz/view?lecture='.$quiz_data['lecture_id']);
            }

            if($result->status == ('success')) {
                $this->session->set_flashdata('success', 'quiz');
                $this->session->set_flashdata('message', "New Quiz successfully added.");
                redirect('quiz/view?lecture='.$quiz_data['lecture_id']);
            }
            else
            {
                $this->session->set_flashdata('error', 'quiz');
                $this->session->set_flashdata('message', "Error in registering new Quiz to Database - Syntax Error");
                redirect('quiz/view?lecture='.$quiz_data['lecture_id']);
            }
        }
    }

    //Edit quiz request redirects here
    public function editQuiz()
    {
        if($this->input->server('REQUEST_METHOD') == "POST")
        {
            $lecture_id = $this->input->post('lecture_id_edit');
            $quiz_data = array(
                'quiz_id' => $this->input->post('quiz_ID'),
                'quiz_title' => $this->input->post('quiz_title_edit'),
                'quiz_time' => $this->input->post('quiz_time_edit'),
                'quiz_duration' => $this->input->post('quiz_duration_edit')
            );

            $date = new DateTime($quiz_data['quiz_time']);
            $quiz_data['quiz_time'] = $date->format('Y-m-d H:i:s');

            $this->form_validation->set_data($quiz_data); //Setting Data
            $this->form_validation->set_rules($this->Quiz_model->getQuizRegistrationRules()); //Setting Rules

            //Reloading page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'quiz',
                    'message'     => 'Error in editing Quiz'
                );

                $this->session->set_flashdata($error_data);
                redirect('quiz/view?lecture='.$lecture_id);
            }

            $quiz_data['lecture_id'] = $lecture_id;
            $result = sendPostRequest('api/quiz/edit', $quiz_data);

            if($result->status == ('error')) {
                $error_data = array(
                    'error'  => 'quiz',
                    'message'     => 'Error in editing Quiz'
                );

                $this->session->set_flashdata($error_data);
                redirect('quiz/view?lecture='.$lecture_id);
            }

            if($result->status == ('success')) {
                $this->session->set_flashdata('success', 'quiz');
                $this->session->set_flashdata('message', "Quiz successfully edited.");
                redirect('quiz/view?lecture='.$lecture_id);
            }
            else
            {
                $this->session->set_flashdata('error', 'quiz');
                $this->session->set_flashdata('message', "Error in editing quiz in Database - Syntax Error");
                redirect('quiz/view?lecture='.$lecture_id);
            }
        }
    }

    //Delete quiz
    public function deleteQuiz()
    {
        if(!$_REQUEST)
        {
            show_404();
        }

        //Sending request to API
        $result = sendGetRequest('api/quiz/delete?quiz_id='.$_REQUEST["quiz_id"]);
        if($result->status== ("success"))
        {
            $this->session->set_flashdata('success', 'quiz');
            $this->session->set_flashdata('message', "Quiz successfully deleted.");
            redirect('quiz?lecture='.$_REQUEST["lecture_id"]);
        }
        else{
            $this->session->set_flashdata('error', 'quiz');
            $this->session->set_flashdata('message', "Error in deleting quiz");
            redirect('quiz?lecture='.$_REQUEST["lecture_id"]);
        }
    }

}