<?php

require "AbstractController.php";

class ExpenseController extends AbstractController {
    
    private ExpenseManager $manager;
    
    public function __construct($manager)
    {
        $this->manager = $manager;
    }
    
    //GET EXPENSES OF USER
    public function expensesIndex()
    {
        $expenses = $this->manager->getExpensesByUser();
        $this->render("index", $expenses);
    }
    
    //CREATE A NEW EXPENSE
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