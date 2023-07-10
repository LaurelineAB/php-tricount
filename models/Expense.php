<?php

class Expense {
    
    //ATTRIBUTES
    private ?int $id;
    private string $title;
    private float $total;
    private Category $category;
    private User $buyer;
    private array $users;
    
    //CONSTRUCTOR
    public function __construct(string $title, float $total, Category $category, User $buyer, array $users)
    {
        $this->id = null;
        $this->title = $title;
        $this->total = $total;
        $this->category = $category;
        $this->buyer = $buyer;
        $this->users = $users;
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
    
    //TITLE
    public function  getTitle() : string
    {
        return $this->title;
    }
    public function setTitle(string $title)
    {
        $this->title = $title;
    }
    
    //TOTAL
    public function  getTotal() : float
    {
        return $this->total;
    }
    public function setTotal(float $total)
    {
        $this->total = $total;
    }
    
    //CATEGORY
    public function  getCategory() : Category
    {
        return $this->category;
    }
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }
    
    //BUYER
    public function  getBuyer() : User
    {
        return $this->buyer;
    }
    public function setBuyer(User $buyer)
    {
        $this->buyer = $buyer;
    }
    
    //USERS
    public function  getUsers() : array
    {
        return $this->users;
    }
    public function setUsers(array $users)
    {
        $this->users = $users;
    }
    
}

?>