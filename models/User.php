<?php

class User {
    
    //ATTRIBUTES
    private ?int $id;
    private string $username;
    private string $email;
    private string $password;
    private array $expenses;
    
    //CONSTRUCTOR
    public function __construct(string $username, string $email, string $password)
    {
        $this->id = null;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->expenses = [];
    }
    
    //ID
    public function getId() : ?int
    {
        return $this->id;
    }
    public function setId(int $id) : void
    {
        $this->id = $id;
    }
    
    //USERNAME
    public function getUsername() : string
    {
        return $this->username;
    }
    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }
    
    //EMAIL
    public function getEmail() : string
    {
        return $this->email;
    }
    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }
    
    //PASSWORD
    public function getPassword() : string
    {
        return $this->password;
    }
    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }
    
    //EXPENSES
    public function getExpenses() : array
    {
        return $this->expenses;
    }
    public function setExpenses(array $expenses) : void
    {
        $this->expenses = $expenses;
    }

?>