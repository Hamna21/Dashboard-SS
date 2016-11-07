<?php
class Lecture_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    //-----Validation rules-----//

    //Lecture Registration Validation rules!
    public function getLectureRegistrationRules()
    {
        $config = array(
            array(
                'field' => 'lecture_Name',
                'label' => 'Lecture Name',
                'rules' => 'required'
            ),

            array(
                'field' => 'lecture_Description',
                'label' => 'Lecture Description',
                'rules' => 'required'
            ),
            array(
                'field' => 'lecture_start',
                'label' => 'Lecture Starting Time',
                'rules' => 'required'
            ),
            array(
                'field' => 'lecture_end',
                'label' => 'Lecture Ending Time',
                'rules' => 'required'
            ),
            array(
                'field' => 'course_ID',
                'label' => 'Course',
                'rules' => 'required'
            )
        );

        return $config;
    }

    //Lecture Edit Validation rules!
    public function getLectureEditRules()
    {
        $config = array(
            array(
                'field' => 'lecture_Name',
                'label' => 'Lecture Name',
                'rules' => 'required'
            ),

            array(
                'field' => 'lecture_Description',
                'label' => 'Lecture Description',
                'rules' => 'required'
            ),
            array(
                'field' => 'lecture_start',
                'label' => 'Lecture Starting Time',
                'rules' => 'required'
            ),
            array(
                'field' => 'lecture_end',
                'label' => 'Lecture Ending Time',
                'rules' => 'required'
            ),
            array(
                'field' => 'course_ID',
                'label' => 'Course',
                'rules' => 'required'
            )
        );

        return $config;
    }

}