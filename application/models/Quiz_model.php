<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Quiz_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getQuizRegistrationRules()
    {
        $config = array(
            array(
                'field' => 'quiz_time',
                'label' => 'Quiz Time',
                'rules' => 'required'
            ),
            array(
                'field' => 'quiz_duration',
                'label' => 'Quiz Duration',
                'rules' => 'required'
            )
        );

        return $config;
    }

}