<?php
class Teacher_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //-------Validation Rules-------//

    //Teacher Registration Validation rules!
    public function getTeacherRegistrationRules()
    {
        $config = array(
            array(
                'field' => 'teacher_Name',
                'label' => 'Teacher Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'teacher_Designation',
                'label' => 'Teacher Designation',
                'rules' => 'required|regex_match[/^[A-Za-z_ -]+$/]'
            ),
            array(
                'field' => 'teacher_Domain',
                'label' => 'Teacher Domain',
                'rules' => 'required'
            )
        );

        return $config;
    }

    //Teacher Edit Validation rules!
    public function getTeacherEditRules()
    {
        $config = array(
            array(
                'field' => 'teacher_Name',
                'label' => 'Teacher Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'teacher_Designation',
                'label' => 'Teacher Designation',
                'rules' => 'required|regex_match[/^[A-Za-z_ -]+$/]'
            ),
            array(
                'field' => 'teacher_Domain',
                'label' => 'Teacher Domain',
                'rules' => 'required'
            )
        );

        return $config;
    }

}