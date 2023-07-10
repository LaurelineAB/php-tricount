<?php

require_once "AbstractManager.php";

class UserManager extends AbstractManager {
    
    public function getAllUsers() : array
    {
        $query = $this->db->prepare("SELECT * FROM users;");
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    
    public function getUserById(int $id) : User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE users.id = :id");
        $parameters = ['id' => $id];
        $query->execute($parameters);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $user = new User ($fetch['email'], $fetch['username'], $fetch['password']);
        $user['id'] = setId($id);
        return $user;
    }
    
    public function getUserByEmail(string $email) : User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE users.email = :email");
        $parameters = ['email' => $email];
        $query->execute($parameters);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $user = new User ($fetch['email'], $fetch['username'], $fetch['password']);
        $user['id'] = setId($id);
        return $user;
    }
    
    public function insertUser(User $user) : User
    {
        $query = $this->db->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
        $parameters =
        [
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword()
        ];
        $query->execute($parameters);
        $query = $this->db->prepare("SELECT * FROM users WHERE users.email = :email");
        $parameters = ['email' => $user->getEmail()];
        $query->execute($parameters);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $user->setId($fetch['id']);
        return $user;
    }
    
    public function editUser(User $user) : void
    {
        $query = $this->db->prepare("UPDATE users SET email = :email, username = :username, password = :password WHERE users.id = :id");
        $parameters =
        [
            'email' => $user->getEmail(),
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'id' => $user->getId()
        ];
        $query->execute($parameters);
    }
}

?>