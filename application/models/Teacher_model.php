<?php
class Teacher_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //-------SELECT-------//

    //Getting all teachers
    public function get_teachers()
    {
        $query = $this->db
            ->get('Teacher');

        return $query->result_array();
    }

    //Get a single teacher by it's ID
    public function get_teacher($teacher_id)
    {
        $query = $this->db
            ->where('teacher_ID', $teacher_id)
            ->get('Teacher');

        return $query->row_array();
    }

    //Get all teachers within limit - for pagination purposes
    public function get_teachers_limit($limit, $start)
    {
        $query = $this->db
            ->limit($limit, $start)
            ->get('Teacher');

        return $query->result_array();
    }

    //Getting total count of Teachers
    public function getTeacherTotal()
    {
        $this->db->from('Teacher');
        return $this->db->count_all_results();
    }

    //-------UPDATE------//

    //Update a teacher by its ID
    public function updateTeacher($teacherID, $teacherData)
    {
        $this->db->where("teacher_ID", $teacherID);
        $this->db->update("Teacher", $teacherData);
        return true;
    }

    //-------DELETE-------//

    //Delete a teacher by its ID
    public function deleteTeacher($teacherID)
    {
        $this->db->where('teacher_ID', $teacherID);
        $this->db->delete('Teacher');
        return true;
    }

    //-------INSERT-------//

    //Insert new Teacher
    public function insertTeacher($teacherData)
    {
        if($this->db->insert('Teacher', $teacherData))
        {
            return true;
        }
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