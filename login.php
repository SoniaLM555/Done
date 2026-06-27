<?php 
    require_once __DIR__."/templates/header.php";
    require_once __DIR__."/lib/pdo.php";
    require_once __DIR__."/lib/user.php";

    $errors = [];
    
    if (isset($_POST['loginUser'])) {
        $user = verifyUserLoginPassword($pdo, $_POST['email'], $_POST['password']);

        if ($user) {
        //on connecte => session
        $_SESSION['users'] = $user;
        
        // Log de connexion en JSON (NoSQL)
        $log = [
            'date' => date('Y-m-d H:i:s'),
            'idUser' => $user['idUser'],
            'action' => 'connexion'
        ];
        $logFile = __DIR__ . '/logs/connexions.json';
        if (!is_dir(__DIR__ . '/logs')) {
            mkdir(__DIR__ . '/logs', 0777, true);
        }
        $logs = [];
        if (file_exists($logFile)) {
            $logs = json_decode(file_get_contents($logFile), true) ?? [];
        }
        $logs[] = $log;
        file_put_contents($logFile, json_encode($logs, JSON_PRETTY_PRINT));
        
        header('location: index.php');
        } else {
            //afficher une erreur
            $errors[] = "Email ou mot de passe incorrect";
        
        }

    }
?>

<div class="container col-xxl-8 px-4 py-5">
    <h1>Se connecter</h1>

    <?php
        foreach ($errors as $error) { ?>
        <div class="alert alert-danger" role="alert">
            <?=$error; ?>
        </div>
        <?php }
    ?>

    <form action="" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <input type="submit" name="loginUser" value="Connexion" class="btn btn-primary">
    </form>

</div>

<?php require_once __DIR__."/templates/footer.php";  ?>