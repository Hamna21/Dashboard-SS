<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //Getting user for login
    public function get_user_login($userdata)
    {
        $query = $this->db
            ->where('email',  $userdata['email'] )
            ->where('password', $userdata['password'])
            ->get('Admin');

        if ( $query->num_rows() > 0 )
        {
            $row = $query->row_array();
            $this->session->set_userdata('user',$row["user_Name"]);    //Setting login user name in session
            return true;
        }
        else
        {
            return false;
        }
    }

    //Login Validation Rules
    public function loginValidationRules()
    {
        $config = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            )
        );

        return $config;

    }

}