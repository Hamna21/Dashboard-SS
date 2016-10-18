<?php
class Category_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //Getting all categories
    public function get_categories()
    {
        $query = $this->db
            ->get('Category');

        return $query->result_array();
    }

    public function get_category($category_id)
    {
        $query = $this->db
            ->where('category_ID', $category_id)
            ->get('Category');

        return $query->row_array();
    }

    //Getting all categories within limit
    public function get_categories_limit($limit, $start)
    {
        $query = $this->db
            ->limit($limit, $start)
            ->get('Category');

        return $query->result_array();
    }

    //Update a category by its ID
    public function updateCategory($categoryID, $categoryData)
    {
        $this->db->where("category_ID", $categoryID);
        $this->db->update("Category", $categoryData);
        return true;
    }

    //Delete a course by its ID
    public function deleteCategory($categoryID)
    {
        //$category_Image = $this->db->select('category_Image');
        //$category_ThumbImage = $this->db->select('category_ThumbImage');
        $this->db->where('category_ID', $categoryID);
       // unlink("uploads/".$category_Image);
        //unlink("uploads/".$category_ThumbImage);
        $this->db->delete('Category');
        return true;
    }


    //Category Total Count
    public function getCategoryTotal()
    {
        $this->db->from('Category');
        return $this->db->count_all_results();
    }

    //Insert new Category
    public function insertCategory($categoryData)
    {
        if($this->db->insert('Category', $categoryData))
        {
            return true;
        }
    }

    //Finding a category by its ID
    public function getCategory_ID($categoryID)
    {
        $exist = "Category ID already in database - Try Again!";
        $query = $this->db
            ->where('category_ID',$categoryID )
            ->get('Category');

        if($query->num_rows() > 0)
        {
            return $exist;
        }

    }

    //Finding a category by its Name
    public function getCategory_Name($categoryName)
    {
        $exist = "Category Name already in database - Try Again!";
        $query = $this->db
            ->where('category_Name',$categoryName )
            ->get('Category');

        if($query->num_rows() > 0)
        {
            return $exist;
        }
    }

    //Category Registration Validation rules!
    public function getCategoryRegistrationRules()
    {
        $config = array(
            array(
                'field' => 'category_Name',
                'label' => 'Category Name',
                'rules' => 'required|regex_match[/^[A-Za-z0-9_ -]+$/]|is_unique[Category.category_Name]'
            )
        );

        return $config;
    }

    //Category Edit Validation rules!
    public function getCategoryEditRules()
    {
        $config = array(
            array(
                'field' => 'category_Name',
                'label' => 'Category Name',
                'rules' => 'required|regex_match[/^[A-Za-z0-9_ -]+$/]|is_unique[Category.category_Name]'
            )
        );

        return $config;
    }
}