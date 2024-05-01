<?php

function verifyUserLoginPassword(PDO $pdo, string $email, string $password):bool|array
{
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    //fetch() permet de récupérer une seule ligne
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        //verif ok
        return $user;
    } else {
        //email ou mdp incorrect : retourne false
        return false;
    }


}