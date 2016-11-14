<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Question_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getQuestionRegistrationRules()
    {
        $config = array(
            array(
                'field' => 'question_text',
                'label' => 'Question Text',
                'rules' => 'required'
            ),
            array(
                'field' => 'option_one',
                'label' => 'Option One',
                'rules' => 'required'
            ),
            array(
                'field' => 'option_two',
                'label' => 'Option Two',
                'rules' => 'required'
            ),
            array(
                'field' => 'option_three',
                'label' => 'Option Three',
                'rules' => 'required'
            ),
            array(
                'field' => 'correct_option',
                'label' => 'Correct Option',
                'rules' => 'required'
            )
        );

        return $config;
    }

}