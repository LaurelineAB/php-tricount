<?php

class Category {
    
    //ATTRIBUTES
    private ?int $id;
    private string $name;
    private string $description;
    private array $expenses;
    
    //CONSTRUCTOR
    public function __construct(string $name, string $description)
    {
        $this->id = null;
        $this->name = $name;
        $this->description = $description;
        $this->expenses = [];
    }
    
    //ID
    public function  getId() : int
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }
    
    //NAME
    public function  getName() : string
    {
        return $this->name;
    }
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    //DESCRIPTION
    public function  getDescription() : string
    {
        return $this->description;
    }
    public function setDescription(string $description)
    {
        $this->description = $description;
    }
    
    //POSTS
    public function  getExpenses() : array
    {
        return $this->expenses;
    }
    public function setExpenses(array $expenses)
    {
        $this->expenses = $expenses;
    }
    
    
    //METHODS
    public function addExpense(Expense $expense) : array
    {
        array_push($this->expenses, $expense);
        return $this->expenses;
    }
    
    public function removeExpense(Expense $expense) : array
    {
        $key = array_search($expense,$this->expenses);
        array_splice($this->expenses, $key, 1);
        return $this->expenses;
    }
}

?>