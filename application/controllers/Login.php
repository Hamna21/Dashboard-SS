<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('User_model');
    }

    //Login form page
    public function index()
    {
        //Redirect to Dashboard if a user is already logged in
        if(isset($_SESSION['user']))
        {
            redirect('/Dashboard');

        }
        if ( ! file_exists(APPPATH.'views/pages/loginView.php'))
        {
            show_404(); // Whoops, we don't have a page for that!
        }

        $data['title'] = 'Login';
        $this->load->view('pages/loginView', $data);
    }

    //POST direct from login form redirects here
    public function loginUser()
    {
        if($this->input->server("REQUEST_METHOD") == 'POST')
        {
            //Getting data from form
            $userdata = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );

            //Validating data from login form
            $this->form_validation->set_data($userdata);
            $this->form_validation->set_rules($this->User_model->loginValidationRules());

            //Reload page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $data['title'] = 'Login';
                $this->load->view('pages/loginView', $data);
                return;
            }

            //Redirect to Dashboard on successful login
            if ($this->User_model->get_user_login($userdata))
            {
                redirect('/Dashboard');
            }

            //Redirect to login page if user not found in DB
            else
            {
                $data['title'] = 'Login';
                $data['error'] = 'Invalid Email/Password';
                $this->load->view('pages/loginView', $data);
                return;
            }
        }

        //Call this if a user tries to access this method from URL
        show_404();
    }

    public function logoutUser()
    {
        if(!isset($_SESSION['user']))
        {
            show_error("You do not have access. ", "500", "Unauthorized User");
        }
        $this->session->sess_destroy();
        redirect('/Login');
    }

    //Check if user's email exists in DB or not - AJAX request redirects here
    public function userExist()
    {
        if(!$_REQUEST)
        {
           show_404();
        }
        $email = $_REQUEST["q"];
        $result = $this->User_model->getUser($email);
        echo $result;
    }

}