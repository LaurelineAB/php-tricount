<?php

require_once "AbstractManager.php";

class ExpenseManager extends AbstractManager {
    
    //GET ALL EXPENSES
    public function getAllExpenses() : array
    {
        $query = $this->db->prepare("SELECT * FROM expenses");
        $query->execute;
        $expenses = $query->fetchAll(PDO::FETCH_ASSOC);
        return $expenses;
    }
    
    //GET BUYER BY EXPENSE ID
    public function getBuyerByExpenseId(int $id) : User
    {
        $query = $this->db->prepare("SELECT payer_id FROM expenses WHERE expenses.id = ?");
        $query->execute([$id]);
        $buyer_id = $query->fetch(PDO::FETCH_ASSOC);
        $query = $this->db->prepare("SELECT * FROM users WHERE users.id = ?");
        $query->execute([$buyer_id]);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $buyer = new User($fetch['username'], $fetch['email'], $fetch['password']);
        $buyer->setId($buyer_id);
        return $buyer;
        
    }
    
    //GET EXPENSE BY ID
    public function getExpenseById(int $id) : Expense
    {
        $query = $this->db->prepare(
            "SELECT * FROM expenses WHERE expenses.id = ?");
        $query->execute([$id]);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        //Récupérer la catégorie
        $query = $this->db->prepare("SELECT * FROM categories WHERE categories.id = ?");
        $query->execute([$fetch['category_id']]);
        $fetchCat = $query->fetch(PDO::FETCH_ASSOC);
        $category = new Category($fetchCat['name'], $fetchCat['description']);
        $category->setId($fetchCat['id']);
        //Récupérer le user
        $query = $this->db->prepare("SELECT * FROM users WHERE users.id = ?");
        $query->execute([$fetch['payer_id']]);
        $fetchUser = $query->fetch(PDO::FETCH_ASSOC);
        $user = new User($fetchUser['username'], $fetchUser['email'], $fetchUser['password']);
        $user->setId($fetchUser['id']);
        //Récupérer les dettes
        $query = $this->db->prepare("SELECT debt_id FROM users_expenses WHERE expense_id = ?");
        $query->execute([$id]);
        $fetchDebts = $query->fetchAll(PDO::FETCH_ASSOC);
        $debts = [];
        foreach($fetchDebts as $debt)
        {
            array_push($debts, $debt['debt_id']);
        }

        $expense = new Expense($fetch['title'], $fetch['total'], $category, $user, $debts);
        $expense->setId($id);
        return $expense;
    }
    
    //GET EXPENSES BY USER
    public function getExpensesByUser(User $user) : array
    {
        $query = $this->db->prepare("SELECT * FROM expenses WHERE expenses.payer_id = ?");
        $query->execute([$user->getId()]);
        $expenses = $query->fetchAll(PDO::FETCH_ASSOC);
        return $expenses;
    }
    
    //GET DEBTS BY USER
    public function getDebtsByUser(User $user) : array
    {
        $query = $this->db->prepare("SELECT expense_id FROM users_expenses WHERE users_expenses.debt_id = ?");
        $query->execute([$user->getId()]);
        $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
        $debts = [];
        foreach($fetch as $item)
        {
            $debt = getExpenseById($item);
            array_push($debts, $debt);
        }
        return $debts;
        
    }
    
    //NEW EXPENSE IN DATABASE
    public function insertExpense(Expense $expense) : Expense
    {
        $query = $this->db->prepare("INSERT INTO expenses (title, total, payer_id, category_id) VALUES (:title, :total, :user, :category)");
        $parameters =
        [
            'title' => $expense->getTitle(),
            'total' => $expense->getTotal(),
            'user' => $expense->getBuyer()->getId(),
            'category' => $expense->getCategory()->getId()
        ];
        $query->execute($parameters);
        $id = $this->db->lastInsertId();
        $expense->setId($id);
        return $expense;
    }
    
    //NEW USER_DEPENSE IN DATABASE
    public function insertUserExpense(Expense $expense)
    {
        foreach($expense->getUsers as $debt)
        {
            $query = $this->db->prepare(
                "INSERT INTO users_expenses (expense_id, debt_id) 
                VALUES (:expense_id, :debt_id)");
            $parameters =
            [
                'expense_id' => $expense->getId(),
                'debt_id' => $debt->getId()
            ];
            $query->execute($parameters);
        };
    }
    
    //EDIT EXPENSE
    public function editExpense(Expense $expense) : Expense
    {
        $query = $this->db->prepare("UPDATE expenses SET title = :title, total = :total, payer_id = :payer, category_id = :category WHERE id = :id");
        $parameters = 
        [
            'title' => $expense->getTitle(),
            'total' => $expense->getTotal(),
            'payer' => $expense->getBuyer()->getId(),
            'category' => $expense->getCategory()->getId(),
            'id' => $expense->getId()
        ];
        $query->execute($parameters);
    }
}

?>