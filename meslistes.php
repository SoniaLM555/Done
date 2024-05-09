<?php

    require_once 'templates/header.php';
    require_once 'lib/pdo.php';
    require_once 'lib/list.php';

    if (isset($_SESSION['users'])) {
        $lists = getListsByUserId($pdo, $_SESSION['users']['idUser']);


    }

?>


<div class= "container">
    <h1>Mes listes</h1>
    <div class="row">

        <?php if (isset($_SESSION['users'])) {
            if ($lists) {
                foreach ($lists as $list) {  ?>
                    <div class="col">
                        <div class="card" >
                            <div class="car-header d-flex align-item-center justify-content-evenly">
                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                    <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
                                </svg>
                                <h3 class="m-3 display-10 "><?=$list['titleList'] ?></h3> 
                            </div>
                            <div class="card-body d-flex justify-content-between align-items-end">
                                 <a href="#" class="btn btn-primary">Voir la liste</a>
                                <div>
                                    <span class="badge rounded-pill text-bg-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-<?=$list['icon']?>" viewBox="0 0 16 16">
                                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                                        </svg>
                                        <?=$list['titleCategory']?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>Aucune Liste</p>

            <?php } ?>


        <?php } else { ?>
            <p>Connecte-toi pour avoir accès à tes liste </p>
            <a href="login.php" class="btn btn-outline-primary me-2" >Se connecter</a>
        <?php } ?>
    </div>

</div>



<?php require_once __DIR__."/templates/footer.php";  ?>
