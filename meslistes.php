<?php

    require_once 'templates/header.php';
    require_once 'lib/pdo.php';
    require_once 'lib/list.php';
    require_once 'lib/category.php';


    $categoryId = null;
    if (isset($_SESSION['users'])) {
        if (isset($_GET['category'])) {
            $categoryId = (int)$_GET['category'];
        }
        $lists = getListsByUserId($pdo, $_SESSION['users']['idUser']);
    }

    $categories = getCategories($pdo);

?>


<div class= "container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Mes listes</h1>
        <?php if (isUserConnected()) { ?>
            <a href="ajout-modification-liste.php" class="btn btn-primary">Ajouter une liste</a>
        <?php } ?>
        
        <form method="get">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="">Toutes</option>
                <?php foreach($categories as $category) { ?>
                    <option <?=((int)$category['idCategory'] === $categoryId ? 'selected="selected"': '' )?> value="<?=$category['idCategory']?>"><?=$category['titleCategory']?></option>
                <?php } ?>

            </select>
        </form>



    </div>
    
    <div class="row">

        <?php if (isUserConnected()) {
            if ($lists) {
                foreach ($lists as $list) {  ?>
                    <div class="col">
                        <div class="card" >
                            <div class="car-header d-flex align-item-center justify-content-evenly">
                                <
                                
                                <h3 class="m-3 display-10 "><?=$list['titleList'] ?></h3> 
                            </div>
                            <div class="card-body d-flex justify-content-between align-items-end">
                                 <a href="ajout-modification-liste.php?idList=<?=$list['idList'] ?>" class="btn btn-primary">Voir la liste</a>
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
