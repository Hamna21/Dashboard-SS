<?php
class Lecture_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //Getting all lectures
    public function get_lectures()
    {
        $this->db->from('Lecture');
        $this->db->join('Course', 'Lecture.course_ID= Course.course_ID');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Getting lectures in limit
    public function get_lectures_limit($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->from('Lecture');
        $this->db->join('Course', 'Lecture.course_ID= Course.course_ID');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Getting total count of Lectures
    public function getLectureTotal()
    {
        $this->db->from('Lecture');
        return $this->db->count_all_results();
    }

    //Finding a lecture by its ID
    public function getLecture_ID($q)
    {
        $exist = "Lecture ID already exists - Try Again!";
        $query = $this->db
            ->where('lecture_ID',$q)
            ->get('Lecture');
        if($query->num_rows() > 0)
        {
            return $exist;
        }
    }

    //Finding a lecture by its Name
    public function getLecture_Name($q)
    {
        $exist = "Lecture Name already exists - Try Again!";
        $query = $this->db
            ->where('lecture_Name',$q)
            ->get('Lecture');
        if($query->num_rows() > 0)
        {
            return $exist;
        }
    }

    //Inserting new Lecture
    public function insertLecture($lectureData)
    {
        if($this->db->insert('Lecture', $lectureData))
        {
            return true;
        }
    }

    //LectureRegistration Validation rules!
    public function getLectureRegistrationRules()
    {
        $config = array(
            array(
                'field' => 'lecture_ID',
                'label' => 'Lecture ID',
                'rules' => 'required|regex_match[/^[0-9]+$/]|is_unique[Lecture.lecture_ID]'
            ),

            array(
                'field' => 'lecture_Name',
                'label' => 'Lecture Name',
                'rules' => 'required|is_unique[Lecture.lecture_Name]'
            ),

            array(
                'field' => 'lecture_Description',
                'label' => 'Lecture Description',
                'rules' => 'required'
            ),
            array(
                'field' => 'lecture_Time',
                'label' => 'Lecture Time',
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