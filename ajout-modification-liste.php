<?php 

require_once __DIR__."/templates/header.php";
require_once __DIR__."/lib/pdo.php";
require_once __DIR__."/lib/list.php"; 
require_once __DIR__."/lib/category.php";

if (!isUserConnected()) {
    header('Location: login.php');
}

$categories = getCategories($pdo);

$errorsList = [];
$errorsListItem = [];
$messagesList = [];

$list = [
    'titleList' => '',
    'idCategory' => ''
];



// Pour voir si le formulaire d'ajout et ou modif a été envoyé

if(isset($_POST['saveList'])){
    if(!empty($_POST['titleList'])){
        $idList = null;
        if (isset($_GET['idList'])) {
            $idList = $_GET['idList'];
        }
       $res = saveList($pdo, $_POST['titleList'], (int)$_SESSION['users']['idList'], $_POST['idCategory'], $idList);
       if ($res) {
           if ($idList) {
               $messagesList[] = "La liste à bien été mise à jour";
           } else {
            header('location: ajout-modification-liste.php?idList=' . $res );
           }
       } else {
            // erreur
            $errorsList[] = "La liste n'a pas été enregistrée";
       }
    } else {
        //erreur
        $errorsList[] = "Le titre est obligatoire";
    }

}

if (isset($_POST['saveListItem'])) {
    if (!empty($_POST['titleItem'])) {
        //sauvegarder
        $idItem= (isset($_POST['idItem']) ? $_POST['idItem'] : null);
        $res = saveListItem($pdo, $_POST['titleItem'], (int)$_GET['idList'], false, $idItem);
    } else {
        //erreur
        $errorsListItem[] = "Le nom de la tâche est obligatoire";
    }
}

if (isset($_GET['action']) && isset($_GET['idItem'])) {
    if ($_GET['action'] === 'deleteListItem') {
        $res = deleteListItemById($pdo, (int)$_GET['idItem']);
        header('Location: ajout-modification-liste.php?idList=' . $_GET['idList']);
    }
    if ($_GET['action'] === 'updateStatusListItem') {
        $res = updateListItemStatus($pdo, (int)$_GET['idItem'], (bool)$_GET['status']);
        if (isset($_GET['redirect']) && $_GET['redirect'] === 'list') {
            header('Location: mes-listes.php');
        } else {
            header('Location: ajout-modification-liste.php?idList=' . $_GET['idList']);
        }
    }

}


$editMode = false;
if (isset($_GET['idList'])){
    $list = getListById($pdo, (int)$_GET['idList']);
    $editMode = true;

    $items = getListItems($pdo, (int)$_GET['idList']);
}




?>


<div class="container col-xxl-8">
    <h1> Liste </h1>

    <?php foreach ($errorsList as $error) { ?>
        <div class="alert alert-danger">
            <?=$error; ?>
        </div>
    <?php } ?>
    <?php foreach ($messagesList as $message) { ?>
        <div class="alert alert-success">
            <?=$message; ?>
        </div>
    <?php } ?>

    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button <?=($editMode) ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="<?= ($editMode) ? 'false' : 'true' ?>" aria-controls="collapseOne">
                    <?=($editMode) ? $list['titleList'] : 'Ajouter une liste' ?>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse <?=($editMode) ? '' : 'show' ?> " data-bs-parent="#accordionExample">
                <div class="accordion-body">
                   <form action="" method="post">
                        <div class="mb-3">
                            <label for="titleList" class="form-label">Titre</label>
                            <input type="text" value="<?= $list['titleList']; ?>" name="titleList" id="titleList" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="idCategory" class="form-label">Catégorie</label>
                            <select name="idCategory"  id="idCategory" class="form-control">
                                <?php foreach ($categories as $category) { ?>
                                    <option
                                        <?=($category['idCategory'] === $list['idCategory']) ? 'selected="selected"' : '' ?>
                                        value="<?=$category['idCategory'] ?>"><?=$category['titleCategory'] ?></option>
                                <?php } ?>
                                </select>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Enregistrer" name="savelist" class="btn btn-primary">
                        </div>



                   </form>
                </div>
            </div>
        </div>
    </div>
<div class="row mt-3">
    <?php if (!$editMode) { ?>
    <div class="alert alert-warning">
        Après avoir enregistré, vous pourrez ajouter les tâches.
    </div>
    <?php } else { ?>
        <h2 class="border-top pt-3"> Tâches</h2>
        <?php foreach ($errorsListItem as $error) { ?>
            <div class="alert alert-danger">
                <?= $error; ?>
            </div>
        <?php } ?>

        <form method="post" class="d-flex">
            <input type="checkbox" name="status" id="status">
            <input type="text" name="titleItem" id="titleItem" placeholder="Ajouter une tâche" class="form-control mx-2">
            <input type="submit" name="saveListItem" class="btn btn-primary" value="Enregistrer" >
        </form>
        <div class="row m-4 border rounded p-2 ">
            <?php foreach($items as $item) { ?>
                <div class="accordion mb-2">
                    <div class="accordion-item" id="accordion-parent-<?$item['idItem']?>">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-item-<?=$item['idItem']?>" aria-expanded="false" aria-controls="collapseOne">
                            <a class="me-2" href="?id=<?=$_GET['idList']?>&action=updateStatusListItem&item_idList=<?=$item['idItem'] ?>&status=<?=!$item['status'] ?>"><i class="bi bi-check-circle<?=($item['status'] ? '-fill' : '')?>"></i></a>
                            <?= $item['titleItem'] ?>
                            </button>
                        </h2>
                        <div id="collapse-item-<?=$item['idItem']?>" class="accordion-collapse collapse " data-bs-parent="#accordion-parent-<?$item['idItem']?>">
                            <div class="accordion-body">
                                <form action="" method="post">
                                        <div class="mb-3 d-flex">
                                            <input type="text" value="<?= $item['titleItem']; ?>" name="titleItem" class="form-control">
                                            <input type="hidden" name="itemId" value="<?= $item['idItem']; ?>">
                                            <input type="submit" value="Enregistrer" name="saveListItem" class="btn btn-primary">
                                        </div>
                                </form>
                                <a class="btn btn-outline-primary" href="?id=<?=$_GET['idList']?>&action=deleteListItem&idList=<?=$item['idItem'] ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer cette tâche ?')"><i class="bi bi-trash3-fill"></i> Supprimer</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>


</div>

<?php require_once __DIR__."/templates/footer.php";  ?>