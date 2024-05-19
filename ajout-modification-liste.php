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
               $messagesList[] = 'La liste à bien été mise à jour';
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

if (isset($_POST['saveItem'])) {
    if (!empty($_POST['titleItem'])) {
        //sauvegarder
        $res = saveListItem($pdo, $_POST['titleItem'], (int)$_GET['idItem'], false);
    } else {
        //erreur
        $errorsListItem[] = "Le nom de la tâche est obligatoire";
    }
}




$editMode = false;
if (isset($_GET['idList'])){
    $list = getListById($pdo, (int)$_GET['idList']);
    $editMode = true;

    $items = getListItems($pdo, (int)$_GET['idItem']);
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
                <button class="accordion-button <?=($editMode) ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
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
        Après avoir enregistré, vous pourrez ajouter des items.
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
            <input type="submit" name="saveItem" class="btn btn-primary" value="Enregistrer" >

        </form>
    <?php } ?>
</div>


</div>

<?php require_once __DIR__."/templates/footer.php";  ?>