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
    'titleList' =>'',
    'idCategory' =>''
];


// Pour voir si le formulaire d'ajout et ou modif a été envoyé

if(isset($_POST['saveList'])){
    if(!empty($_POST['titleList'])){
        $id =null;
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
       $res = saveList($pdo, $_POST['titleList'], (int)$_SESSION['users']['idUser'], $_POST['idCategory'], $id);
       if ($res) {
           if ($id) {
               $messagesList[] = 'La liste à bien été mise à jour';
           } else {
            header('location: ajout-modification-liste.php?id=' . $res );
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

if (isset($_GET['action']) && isset($_GET['item_id'])) {
    if ($_GET['action'] === 'deleteListItem') {
        $res = deleteListItemById($pdo, (int)$_GET['item_id']);
        header('Location: ajout-modification-liste.php?id=' . $_GET['id']);
    }
    if ($_GET['action'] === 'updateStatusListItem') {
        $res = updateListItemStatus($pdo, (int)$_GET['item_id'], (bool)$_GET['status']);
        if (isset($_GET['redirect']) && $_GET['redirect'] === 'list') {
            header('Location: mes-listes.php');
        } else {
            header('Location: ajout-modification-liste.php?id=' . $_GET['id']);
        }
    }

}



$editMode = false;
if (isset($_GET['id'])) {
    $list = getListById($pdo, (int)$_GET['id']);
    $editMode = true;

    $items = getListItems($pdo, (int)$_GET['id']);
}



?>


<div class="container col-xxl-8">
    <h1> Liste </h1>

    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <?php if (isset($_GET['idUser'])) { ?>
                         Modifier la liste
                    <?php } else { ?>
                         Ajouter une liste
                    <?php } ?>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                   <form action="" method="post">
                        <div class="mb-3">
                            <label for="titleList" class="form-label">Titre</label>
                            <input type="text" name="titleList" id="titleList" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="idCategory" class="form-label">Catégorie</label>
                            <select name="idCategory"  id="idCategory" class="form-control">
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?=$category["idCategory"] ?>"><?=$category['titleCategory'] ?></option>
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
</div>

<?php require_once __DIR__."/templates/footer.php";  ?>
