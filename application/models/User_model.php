<?php
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
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