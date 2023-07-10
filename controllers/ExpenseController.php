<?php

require_once "AbstractController.php";

class ExpenseController extends AbstractController {
    
    private ExpenseManager $manager;
    
    public function __construct($manager)
    {
        $this->manager = $manager;
    }
    
    public function expensesIndex()
    {
        $expenses = $this->manager->getAllExpenses();
        $this->render("index", $expenses);
    }
    
    //GET EXPENSES OF USER
    public function userExpensesIndex()
    {
        $expenses = $this->manager->getExpensesByUser($_SESSION['user']);
        $this->render("index", $expenses);
    }
    
    //CREATE A NEW EXPENSE
    public function createExpense(array $post, CategoryManager $categoryManager)
    {
        if(isset($_POST['submit-new-expense']))
        {
            $category = $categoryManager->getCategoryById($post['category']);
            $buyer = $_SESSION['user'];
            $users = $post['users'];
            $expense = new Expense($post['title'], $post['total'], $category, $buyer, $users);
            $this->manager->insertCategory($expense);
            $this->render("create", []);
        }
    }
    
    //EDIT CATEGORY
    public function editExpense(array $post, CategoryManager $categoryManager)
    {
        if(isset($_POST['submit-edit-expense']))
        {
            $category = $categoryManager->getCategoryById($post['category']);
            $buyer = $_SESSION['user'];
            $users = $post['users'];
            $expense = new Expense($post['title'], $post['total'], $category, $buyer, $users);
            $expense->setId($post['id']);
            $this->manager->editCategory($expense);
        }
        $this->render("edit", []);
    }
}

?>