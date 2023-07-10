<?php

require_once "AbstractController.php";

class UserController extends AbstractController {
    
    private UserManager $manager;
    
    public function __construct($manager)
    {
        $this->manager = $manager;
    }
    
    public function usersIndex()
    {
        $users = $this->manager->getAllUsers();
        $this->render("index", $users);
    }
    
    public function createUser(array $post)
    {
        if(isset($_POST['submit-create']))
        {
            if ($post['password'] === $post['confirmPassword'])
            {
                $password = password_hash($post['password'], PASSWORD_DEFAULT);
                $user = new User($post['username'], $post['email'], $password);
                $this->manager->insertUser($user);
                $this->render("create", []);
            }
            else
            {
                $this->render("create", []);
                echo "Vous devez taper deux fois le même mot de passe.";
            }
        }
        else {
        $this->render("create", []);}
    }
    
    public function editUser(array $post)
    {
        if(isset($_POST['submit-edit']))
        {
            $password = password_hash($post['password'], PASSWORD_DEFAULT);
            $user = new User($post['email'], $post['username'], $password);
            $user->setId($post['id']);
            $this->manager->editUser($user);
        }
        $this->render("edit", []);
    }
}

?>