<?php

if(isset($_GET['route']))
    {
    if ($_GET['route'] === "users")
    {
        $userController->usersIndex();
    }
    else if ($_GET['route'] === "user-create")
    {
        $userController->createUser($_POST);
    }
    else if ($_GET['route'] === "user-edit")
    {
        $userController->editUser($_POST);
    }
    else if ($_GET['route'] === "expenses")
    {
        $expenseController->expensesIndex();
    }
    else if ($_GET['route'] === "user-expenses" && isset($_SESSION['user']))
    {
        $userController->userExpensesIndex();
    }
}
else
{
    $userController->usersIndex();
}

?>