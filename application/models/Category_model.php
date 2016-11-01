<?php
class Category_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    //------------Validation Functions-----------//

    //Category Registration Validation rules!
    public function getCategoryRegistrationRules()
    {
        $config = array(
            array(
                'field' => 'category_Name',
                'label' => 'Category Name',
                'rules' => 'required|regex_match[/^[A-Za-z0-9_ -]+$/]'
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
                'rules' => 'required|regex_match[/^[A-Za-z0-9_ -]+$/]'
            )
        );

        return $config;
    }
}