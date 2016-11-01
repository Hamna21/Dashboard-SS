<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'image', 'request'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('Category_model');
    }

    //Add Category Form
    public function add()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/category/addCategoryView.php'))
        {
            show_404();
        }

        $data['title'] = ('Category');
        $data['subtitle'] = ('Add Category');

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/category/addCategoryView.php', $data);
        $this->load->view('templates/footer.php', $data);

    }

    //POST request on Add Category form submission redirects here
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

            //Reload add Category page if Validation fails - web server validation
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
            $image_Name = $image_attributes[1];
            $category_data['category_Image'] = base_url().'/uploads/'.$image_Name;

            //Sending request to API
            $result = sendPostRequest('api/category/add', $category_data);

            if($result->status == ('error in validation')) {
                $error_validation = $result->error_messages;
                $error_data = array(
                    'error'  => 'category',
                    'message'     => 'Error in registering new Category',
                    'categoryName_Error' => $error_validation->category_Name,
                    'categoryImageError' => $error_validation->image_Path
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($category_data);
                redirect('/Category/add');

            }

            if($result->status == ('error in db'))
            {
                $this->session->set_flashdata('error', 'category');
                $this->session->set_flashdata('message', "Error in registering new Category to Database");
                redirect('/categories');
            }

            if ($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'category');
                $this->session->set_flashdata('message', "New Category successfully added.");
                redirect('/categories');
            }

            else{
                $this->session->set_flashdata('error', 'category');
                $this->session->set_flashdata('message', "Error in performing action--syntax error");
                redirect('/categories');

            }
        }
        //Call this if a user tries to access this method from URL
        show_404();
    }

    //Edit category form view
    public function edit()
    {
        //Redirect to Login page if user is not logged in
        if(!isset($_SESSION['user']))
        {
            redirect('/Login');
        }
        if(!file_exists(APPPATH. 'views/pages/category/editCategoryView.php'))
        {
            show_404();
        }

        //Getting category information by ID - sending request
        $result = sendGetRequest('api/category/?categoryID='.$_REQUEST["q"]);
        if($result->status== ("error"))
        {
            show_error('Category not found',500, "Error");
        }

        $category = $result->category;
        $category_data = array(
            'category_ID' => $category->category_ID,
            'category_Name' =>  $category->category_Name
        );

        //Setting category data - Information will be displayed on form
        $this->session->set_flashdata($category_data);
        //Setting Image in user-data because needed more then once!
        $this->session->set_userdata('category_ThumbImage', $category->category_ThumbImage);
        $this->session->set_userdata('category_Image', $category->category_Image);

        $data['title'] = ('Category');
        $data['subtitle'] = ('Edit Category');

        $this->load->view('templates/header.php', $data);
        $this->load->view('templates/navbar.php', $data);
        $this->load->view('pages/category/editCategoryView.php', $data);
        $this->load->view('templates/footer.php', $data);
    }

    //POST request on Edit Category redirects here
    public function editCategory()
    {
        if($this->input->server('REQUEST_METHOD') == "POST") {
            $categoryID = $this->session->category_ID;
            $category_data = array(
                'category_ID' => $categoryID,
                'category_Name' => $this->input->post('category_Name')
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

           //If new image is uploaded
            if(!empty($_FILES['image_Path']['name']))
            {
                //Validating image and uploading it
                $image_attributes = uploadPicture();
                $imageUploadStatus = $image_attributes[0];

                //If imageValidation fails, then reload add category page
                if ($imageUploadStatus == 0) {
                    $error_data = array(
                        'error'  => 'category',
                        'message'     => 'Error in editing category',
                        'categoryName_Error' => form_error('category_Name'),
                        'categoryImage_Error' => $image_attributes[1]
                    );

                    $this->session->set_flashdata($error_data);
                    $this->session->set_flashdata($category_data);
                    redirect('/category/edit?q='.$category_data['category_ID']);
                }

                //New image successfully uploaded on web server

                //Deleting images from web server and setting path for API server
                unlink("uploads/".$this->session->category_Image);
                $category_data['category_PrevImage'] = $this->session->category_Image;
                $category_data['category_PrevThumbImage'] = $this->session->category_ThumbImage;



                $image_Name = $image_attributes[1];
                $category_data['category_Image'] = base_url().'/uploads/'.$image_Name;
            }

            //Sending request to API
            $result = sendPostRequest('api/category/edit', $category_data);

            if($result->status == ('error in validation')) {
                $error_validation = $result->error_messages;
                $error_data = array(
                    'error'  => 'category',
                    'message'     => 'Error in editing Category',
                    'categoryName_Error' => $error_validation->category_Name
                );

                $this->session->set_flashdata($error_data);
                $this->session->set_flashdata($category_data);
                redirect('/category/edit?q='.$category_data['category_ID']);

            }

            if($result->status == ('error in db'))
            {
                $this->session->set_flashdata('error', 'category');
                $this->session->set_flashdata('message', "Error in editing category");
                redirect('/categories');
            }

            if($result->status == ('success'))
            {
                $this->session->set_flashdata('success', 'category');
                $this->session->set_flashdata('message', "Category successfully edited.");
                redirect('/categories');
            }

            else
            {
                $this->session->set_flashdata('error', 'category');
                $this->session->set_flashdata('message', "Error in editing category --- Syntax Error");
                redirect('/categories');
            }

        }

    }
    
    //Delete Category
    public function deleteCategory()
    {
        if(!$_REQUEST)
        {
            show_404();
        }

        //Sending request to API
        $result = sendGetRequest('api/category/delete?categoryID='.$_REQUEST["q"]);
        if($result->status== ("success"))
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