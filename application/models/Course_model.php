<?php
class Course_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //-------------Validation Rules------------------//

    //Course Registration Validation rules!
    public function getCourseRegistrationRules()
    {
        $config = array(
            array(
                'field' => 'course_Name',
                'label' => 'Course Name',
                'rules' => 'required|regex_match[/^[A-Za-z0-9_ -]+$/]'
            ),

            array(
                'field' => 'course_Description',
                'label' => 'Course Description',
                'rules' => 'required'
            ),
            array(
                'field' => 'category_ID',
                'label' => 'Category',
                'rules' => 'required'
            ),
            array(
                'field' => 'teacher_ID',
                'label' => 'Teacher',
                'rules' => 'required'
            )
        );

        return $config;
    }

    //Course Edit Validation rules!
    public function getCourseEditRules()
    {
        $config = array(
            array(
                'field' => 'course_Name',
                'label' => 'Course Name',
                'rules' => 'required|regex_match[/^[A-Za-z0-9_ -]+$/]'
            ),
            array(
                'field' => 'course_Description',
                'label' => 'Course Description',
                'rules' => 'required'
            ),
            array(
                'field' => 'category_ID',
                'label' => 'Category',
                'rules' => 'required'
            ),
            array(
                'field' => 'teacher_ID',
                'label' => 'Teacher',
                'rules' => 'required'
            )
        );

        return $config;
    }

}