<?php
class Course_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

   //Getting all courses
    public function get_courses()
    {
        $query = $this->db
            ->get('Course');

        return $query->result_array();
    }

    public function get_courses_limit($limit, $start)
    {
        //$this->db->select('comment_text,  comment.user_ID,user_Name, image_Path');
        $this->db->limit($limit, $start);
        $this->db->from('Course');
        $this->db->join('Category', 'Course.category_ID= Category.category_ID');
        $this->db->join('Teacher', 'Course.teacher_ID= Teacher.teacher_ID');
        $query = $this->db->get();
        return $query->result_array();
    }

    //Get a course by ID
    public function get_course($courseID)
    {
        $this->db->from('Course');
        $this->db->join('Category', 'Course.category_ID= Category.category_ID');
        $this->db->join('Teacher', 'Course.teacher_ID= Teacher.teacher_ID');
        $this->db->where('course_ID', $courseID);
        $query = $this->db->get();
        return $query->row_array();
    }

    //Inserting new Course
    public function insertCourse($courseData)
    {
        if($this->db->insert('Course', $courseData))
        {
            return true;
        }
    }

    //Getting total count of Courses
    public function getCourseTotal()
    {
        $this->db->from('Course');
        return $this->db->count_all_results();
    }

    //Finding a course by its Name
    public function getCourse_Name($q)
    {
        $exist = "Course Name already exists - Try Again!";
        $query = $this->db
            ->where('course_Name',$q)
            ->get('Course');
        if($query->num_rows() > 0)
        {
            return $exist;
        }
    }

    //Finding a course by its ID
    public function getCourse_ID($q)
    {
        $exit = "Course ID already exists - Try Again!";
        $query = $this->db
            ->where('course_ID',$q)
            ->get('Course');
        if($query->num_rows() > 0)
        {
            return $exit;
        }
    }

    //Update a course by its ID
    public function updateCourse($courseID, $courseData)
    {
        $this->db->where("course_ID", $courseID);
        $this->db->update("Course", $courseData);
        return true;
    }

    //Delete a course by its ID
    public function deleteCourse($courseID)
    {
        $this->db->where('course_ID', $courseID);
        $this->db->delete('Course');
        return true;
    }

    //Course Registration Validation rules!
    public function getCourseRegistrationRules()
    {
        $config = array(
            array(
                'field' => 'course_Name',
                'label' => 'Course Name',
                'rules' => 'required|regex_match[/^[A-Za-z0-9_ -]+$/]|is_unique[Course.course_Name]'
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