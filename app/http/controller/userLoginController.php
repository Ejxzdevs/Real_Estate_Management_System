<?php 
require_once '../../model/userLogin.php';
// user Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'] ?? '', ENT_QUOTES, 'UTF-8');

    $userFactory = new UserFactory();
    $user = $userFactory->findUser($username);
    if ($user && $user['user_password']->authenticate($password)) {
        $_SESSION['user_type'] = $user['user_type'];
        if ($user['user_type'] == "admin") {
            header("Location: ../../../admin.php");
            exit();
        } elseif($user['user_type'] == "regular"){
            header("Location: ../../../index.php");
            exit();
        }else{
            $_SESSION['user_type'] = null;
            header("Location: ../../../index.php");
            exit();
        }
    } else {
        echo "Authentication failed!";
    }
} else {
    echo "Please submit your login credentials.";
}
