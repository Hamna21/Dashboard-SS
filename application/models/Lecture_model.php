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

    public function get_lecture($lecture_id)
    {
        $query = $this->db
            ->where('lecture_ID', $lecture_id)
            ->get('Lecture');

        return $query->row_array();
    }


    //Update a lecture by its ID
    public function updateLecture($lectureID, $lectureData)
    {
        $this->db->where("lecture_ID", $lectureID);
        $this->db->update("Lecture", $lectureData);
        return true;
    }

    //Delete a course by its ID
    public function deleteLecture($lectureID)
    {
        //$lecture_Image = $this->db->select('lecture_Image');
        //$lecture_ThumbImage = $this->db->select('lecture_ThumbImage');
        $this->db->where('lecture_ID', $lectureID);
        // unlink("uploads/".$lecture_Image);
        //unlink("uploads/".$lecture_ThumbImage);
        $this->db->delete('Lecture');
        return true;
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

    //Lecture Registration Validation rules!
    public function getLectureRegistrationRules()
    {
        $config = array(
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