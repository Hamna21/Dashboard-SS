<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'image'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Category_model');
    }

    //Add New Category Form
    public function add()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/addCategoryView.php'))
        {
            show_404();
        }

        $data['title'] = ('Category');
        $data['subtitle'] = ('Add Category');

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/addCategoryView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //POST request on New Category form submission redirects here
    public function addCategory()
    {
        if($this->input->server('REQUEST_METHOD') == 'POST') {
            $category_data = array(
                'category_Name' => $this->input->post('category_Name')
            );
            $this->form_validation->set_data($category_data); //Setting Data
            $this->form_validation->set_rules($this->Category_model->getCategoryRegistrationRules()); //Setting Rules

            //Setting Image Rule - Required
            if (empty($_FILES['image_Path']['name'])) {
                $this->form_validation->set_rules('image_Path', 'Image', 'required');
            }

            //Reload add Category page if Validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'category',
                    'message'     => 'Error in registering new Category',
                    'categoryName_Error' => form_error('category_Name'),
                    'categoryImageError' => form_error('image_Path')
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($category_data);
                 redirect('/Category/add');
            }

            //Validating image and uploading it
            $image_attributes = uploadPicture();
            $imageUploadStatus = $image_attributes[0];

            //If imageValidation fails, then exit!
            if ($imageUploadStatus == 0) {
                $error_data = array(
                    'error'  => 'category',
                    'message'     => 'Error in registering new Category',
                    'categoryName_Error' => form_error('category_Name'),
                    'categoryImage_Error' => $image_attributes[1]
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($category_data);
                redirect('/Category/add');
            }
            //Setting image uploaded path
            $category_data['category_Image'] = $image_attributes[1];
            $category_data['category_ThumbImage'] = $image_attributes[2];

            if ($this->Category_model->insertCategory($category_data))
            {
                $this->session->set_flashdata('success', 'category');
                $this->session->set_flashdata('message', "New Category successfully added.");
                redirect('/categories');
            }
            else
            {
                $this->session->set_flashdata('error', 'category');
                $this->session->set_flashdata('message', "Error in registering new Category to Database");
                redirect('/categories');
            }
        }
        //Call this if a user tries to access this method from URL
        show_404();
    }

    //Checking if ID is already in DB
    public function categoryIDExist()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        $categoryID = $_REQUEST["q"];
        $result = $this->Category_model->getCategory_ID($categoryID);
        echo $result;
    }

    //Checking if Name is already in DB
    public function categoryNameExist()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        $categoryName = $_REQUEST["q"];
        $result = $this->Category_model->getCategory_Name($categoryName);
        echo $result;
    }


    //Edit category form view
    public function edit()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/editCategoryView.php'))
        {
            show_404();
        }
        //Getting category information by ID
        $categoryID = $_REQUEST["q"];
        $category = $this->Category_model->get_category($categoryID);
        $category_data = array(
            'category_ID' => $category['category_ID'],
            'category_Name' =>  $category['category_Name']
        );

        //Setting category data - Information will be displayed on form
        $this->session->set_flashdata($category_data);
        $this->session->set_userdata('category_ThumbImage', $category['category_ThumbImage']);
        $this->session->set_userdata('category_Image', $category['category_Image']);

        $data['title'] = ('Category');
        $data['subtitle'] = ('Edit Category');

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/editCategoryView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST request on Edit Category redirects here
    public function editCategory()
    {
        if($this->input->server('REQUEST_METHOD') == "POST") {
            $categoryID = $this->session->category_ID;
            $category_data = array(
                'category_Name' => $this->input->post('category_Name'),
            );

           /* $this->form_validation->set_data($category_data); //Setting Data
            $this->form_validation->set_rules($this->Category_model->getCategoryEditRules()); //Setting Rules

            //Reloading edit category page if validation fails
            if ($this->form_validation->run() == FALSE) {
                $error_data = array(
                    'error'  => 'category',
                    'message'     => 'Error in editing category',
                    'categoryName_Error' => form_error('category_Name'),
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($category_data);
                redirect('/category/edit?q='.$categoryID);
            }*/

            if(!empty($_FILES['image_Path']['name']))
            {
                unlink("uploads/".$this->session->category_ThumbImage);
                unlink("uploads/".$this->session->category_Image);
                //Validating image and uploading it
                $image_attributes = uploadPicture();
                $imageUploadStatus = $image_attributes[0];

                //If imageValidation fails, then reload add category page
                if ($imageUploadStatus == 0) {
                    $error_data = array(
                        'error'  => 'category',
                        'message'     => 'Error in registering new category',
                        'categoryName_Error' => form_error('category_Name'),
                        'categoryImage_Error' => $image_attributes[1]
                    );

                    $this->session->set_flashdata($error_data);
                    $this->session->set_flashdata($category_data);
                    redirect('/category/add');
                }
                //Setting image uploaded path
                $category_data['category_Image'] = $image_attributes[1];
                $category_data['category_ThumbImage'] = $image_attributes[2];
                // createThumbnail($image_attributes[1]);
            }

            if ($this->Category_model->updateCategory($categoryID,$category_data))
            {
                $this->session->set_flashdata('success', 'category');
                $this->session->set_flashdata('message', "Category successfully edited.");
                redirect('/categories');
            }
            else
            {
                $this->session->set_flashdata('error', 'category');
                $this->session->set_flashdata('message', "Error in editing category");
                redirect('/categories');
            }
        }

    }
    
    
    public function deleteCategory()
    {
        if(!$_REQUEST)
        {
            show_404();
        }
        $categoryID = $_REQUEST["q"];
        if($this->Category_model->deleteCategory($categoryID))
        {
            $this->session->set_flashdata('success', 'category');
            $this->session->set_flashdata('message', "Category successfully Deleted.");
            redirect('/categories');
        }
        else{
            $this->session->set_flashdata('error', 'course');
            $this->session->set_flashdata('message', "Error in deleting Category");
            redirect('/categories');
        }

    }

    //Save table Data in excel file
    public function save_in_excel()
    {
        //load our new PHPExcel library
        $this->load->library('excel');
        $data = $this->Category_model->get_categories();
        $this->excel->stream('Categories.xls', $data);
    }
}