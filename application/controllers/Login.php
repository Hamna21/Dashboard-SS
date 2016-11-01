<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'request'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('User_model');
    }

    //Login form page
    public function index()
    {
        //Redirect to Dashboard if a user is already logged in
        if(isset($_SESSION['user']))
        {
            redirect('/dashboard');

        }
        if (!file_exists(APPPATH.'views/pages/loginView.php'))
        {
            show_404(); // Whoops, we don't have a page for that!
        }

        $data['title'] = 'Login';
        $this->load->view('pages/loginView', $data);
    }

    //POST direct from login form redirects here
    public function loginAdmin()
    {
        if($this->input->server("REQUEST_METHOD") == 'POST')
        {
            //Getting data from login form
            $admin_data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );

            //Initial Validation of Admin Login on web server
            $this->form_validation->set_data($admin_data);
            $this->form_validation->set_rules($this->User_model->loginValidationRules());

            //Reload page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'login',
                    'message'     => 'Invalid Email/Password',
                    'email_Error' => form_error('email'),
                    'email' => $this->input->post('email'),
                    'password_Error' => form_error('password')
                );

                $this->session->set_flashdata($error_data);
                redirect('/Login');
            }

            //Sending request to API
            $result = sendPostRequest('api/loginAdmin', $admin_data);
            if($result->status == ('error in validation'))
            {
                $error_validation = $result->error_messages;
                $error_data = array(
                    'error'  => 'login',
                    'message'     => 'Invalid Email/Password',
                    'email_Error' => $error_validation->email_Error,
                    'email' => $this->input->post('email'),
                    'password_Error' => $error_validation->password_Error
                );

                $this->session->set_flashdata($error_data);
                redirect('/Login');
            }

            if($result->status == ('error in db'))
            {
                $error_data = array(
                    'error'  => 'login',
                    'message'     => 'Invalid Email,Password',
                    'email' => $this->input->post('email')
                );

                $this->session->set_flashdata($error_data);
                redirect('/Login');
            }

            if($result->status == ('success'))
            {
                $admin = $result->admin;
                $this->session->set_userdata('user',$admin->user_Name);
                redirect('/Dashboard');
            }
        }

        //Call this if a user tries to access this method from URL
        show_404();
    }

    //Logging out user and destroying session
    public function logoutAdmin()
    {
        if(!isset($_SESSION['user']))
        {
            show_error("You do not have access. ", "500", "Unauthorized User");
        }
        $this->session->sess_destroy();
        redirect('/Login');
    }


    //-----RESET PASSWORD --- USER
    public function resetPassword()
    {
        if($this->input->server('REQUEST_METHOD') == "GET")
        {
            $reset_hash =  $this->input->get('reset_hash');

            $result = sendGetRequest('api/isValidHash?reset_hash='.$reset_hash);

            if($result->status == ("success"))
            {
                if (!file_exists(APPPATH.'views/pages/resetView.php'))
                {
                    show_404(); // Whoops, we don't have a page for that!
                }

                $data['title'] = 'Reset Password';
                $data['reset_hash'] = $reset_hash;
                $this->load->view('pages/resetView', $data);
            }
            elseif($result->status == ("error"))
            {
                show_error('Invalid Reset Password Request',500, 'Unauthorized Request');
            }
        }
    }
}