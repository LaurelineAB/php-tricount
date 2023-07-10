<?php

require "AbstractManager.php";

class ExpenseManager extends AbstractManager {
    
    //GET ALL EXPENSES
    public function getAllExpenses() : array
    {
        $query = $this->db->prepare("SELECT * FROM expenses");
        $query->execute;
        $expenses = $query->fetchAll(PDO::FETCH_ASSOC);
        return $expenses;
    }
    
    //GET EXPENSE BY ID
    public function getExpenseById($id) : Expense
    {
        $query = $this->db->prepare("SELECT * FROM expenses WHERE expenses.id = ?");
        $query->execute([$id]);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $category = getCategoryById($fetch['category']);
        $expense = new Expense($fetch['title'], $fetch['total'], $category);
        $expense->setId($id);
        return $expense;
    }
    
    //GET EXPENSES BY USER
    public function getExpensesByUser(User $user) : array
    {
        $query = $this->db->prepare("SELECT expense_id FROM users_expenses WHERE users_expenses.buyer_id = ?");
        $query->execute([$user->getId()]);
        $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
        $expenses = [];
        foreach($fetch as $item)
        {
            $expense = getExpenseById($item);
            array_push($expenses, $expense);
        }
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
        $query = $this->db->prepare("INSERT INTO expenses (title, total, category) VALUES (:title, :total, :category)");
        $parameters =
        [
            'title' => $expense->getTitle(),
            'total' => $expense->getTotal(),
            'category' => $expense->getCategory()->getId()
        ];
        $query->execute($parameters);
        $id = $this->db->lastInsertId();
        $expense->setId($id);
        return $expense;
    }
    
    //EDIT EXPENSE
    public function editExpense(Expense $expense) : Expense
    {
        $query = $this->db->prepare("UPDATE expenses SET title = :title, total = :total, category = :category WHERE id = :id");
        $parameters = 
        [
            'title' => $expense->getTitle(),
            'total' => $expense->getTotal(),
            'category' => $expense->getCategory()->getId(),
            'id' => $expense->getId()
        ];
        $query->execute($parameters);
    }
}

?>