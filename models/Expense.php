<?php

class Expense {
    
    //ATTRIBUTES
    private ?int $id;
    private string $title;
    private float $total;
    private Category $category;
    
    //CONSTRUCTOR
    public function __construct(string $title, float $total, Category $category)
    {
        $this->id = null;
        $this->title = $title;
        $this->total = $total;
        $this->category = $category;
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
    
}

?>