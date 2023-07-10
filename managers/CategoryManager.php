<?php

require_once "AbstractManager.php";

class CategoryManager extends AbstractManager {
    
    //GET ALL CATEGORIES
    public function getAllCategories() : array
    {
        $query = $this->db->prepare("SELECT * FROM categories");
        $query->execute;
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);
        return $categories;
    }
    
    //GET CATEGORY BY ID
    public function getCategoryById($id) : Category
    {
        $query = $this->db->prepare("SELECT * FROM categories WHERE categories.id = ?");
        $query->execute([$id]);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $category = new Category($fetch['name'], $fetch['description']);
        $category->setId($id);
        return $category;
    }
    
    //NEW CATEGORY IN DATABASE
    public function insertCategory(Category $category) : Category
    {
        $query = $this->db->prepare("INSERT INTO categories (name, description) VALUES (:name, :description)");
        $parameters =
        [
            'name' => $category->getName(),
            'description' => $category->getDescription()
        ];
        $query->execute($parameters);
        $query = $this->db->prepare("SELECT * FROM categories WHERE categories.name = ?");
        $query->execute([$category->getName()]);
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $category->setId($fetch['id']);
        return $category;
    }
    
    //EDIT CATEGORY
    public function editCategory(Category $category) : Category
    {
        $query = $this->db->prepare("UPDATE categories SET name = :name, description = :description WHERE id = :id");
        $parameters = 
        [
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            'id' => $category->getId()
        ];
        $query->execute($parameters);
    }
}

?>