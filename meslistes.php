<?php

require_once 'templates/header.php';
require_once 'lib/pdo.php';
require_once 'lib/list.php';
require_once 'lib/category.php';


$idCategory = null;
if (isset($_SESSION['users'])) {
    if (isset($_GET['category'])) {
        $idCategory = (int)$_GET['category'];
    }
    $lists = getListsByUserId($pdo, $_SESSION['users']['idUser'], $idCategory);
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
                    <option <?=((int)$category['idCategory'] === $idCategory ? 'selected="selected"': '' )?> value="<?=$category['idCategory']?>"><?=$category['titleCategory']?></option>
                <?php } ?>

            </select>
        </form>



    </div>
    
    <div class="row">

        <?php if (isUserConnected()) {
            if ($lists) {
                foreach ($lists as $list) {  ?>
                    <div class="col-md-4 my-2">
                        <div class="card w-100" >
                            <div class="car-header d-flex align-item-center justify-content-evenly">
                                <i class="bi bi-card-checklist"></i>
                                <h3 class="card-title"><?=$list['titleList'] ?></h3> 
                            </div>
                            <div class="card-body d-flex flex-column">
                                <?php $items = getListItems($pdo, $list['idList']); ?>
                                <?php if ($items) { ?>
                                <ul class="list-group">
                                    <?php foreach ($items as $item) { ?>
                                    <li class="list-group-item"><a class="me-2" href="ajout-modification-liste.php?idList=<?=$list['idList']?>&action=updateStatusListItem&redirect=list&idItem=<?=$item['idItem'] ?>&status=<?=!$item['status'] ?>"><i class="bi bi-check-circle<?=($item['status'] ? '-fill' : '')?>"></i></a> <?=$item['titleItem'] ?> </li>
                                    <?php } ?>
                                </ul>
                                <?php } ?>
                                <div class="d-flex justify-content-between align-items-end mt-2">
                                    <a href="ajout-modification-liste.php?idList=<?=$list['idList'] ?>" class="btn btn-primary">Voir la liste</a>
                                    <span class="badge rounded-pill text-bg-primary">
                                        <i class="bi <?=$list['category_icon']?>"></i>
                                        <?=$list['category_titleCategory']?>
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
