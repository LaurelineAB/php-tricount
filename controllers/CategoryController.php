<?php

require "AbstractController.php";

class CategoryController extends AbstractController {
    
    private CategoryManager $manager;
    
    public function __construct($manager)
    {
        $this->manager = $manager;
    }
    
    //GET ALL CATEGORIES
    public function categoriesIndex()
    {
        $categories = $this->manager->getAllCategories();
        $this->render("index", $categories);
    }
    
    //CREATE A NEW CATEGORY
    public function createCategory(array $post)
    {
        if(isset($_POST['submit-new-category']))
        {
            $category = new Category($post['name'], $post['description']);
            $this->manager->insertCategory($category);
            $this->render("create", []);
        }
    }
    
    //EDIT CATEGORY
    public function editCategory(array $post)
    {
        if(isset($_POST['submit-edit-category']))
        {
            $category = new Category($post['name'], $post['description']);
            $category->setId($post['id']);
            $this->manager->editCategory($category);
        }
        $this->render("edit", []);
    }
}

?>