<?php 

function getListsByUserId(PDO $pdo, int $userId, int $idCategory=null): array
{
    $sql = "SELECT `list`.*, category.titleCategory as category_titleCategory, 
    category.icon as category_icon 
    FROM `list`
    JOIN category ON category.idCategory = `list`.idCategory
    WHERE idUser = :idUser";

    if ($idCategory) {
        $sql .= " AND `list`.idCategory = :idCategory";
    }

    $query = $pdo->prepare($sql);
    $query->bindValue(':idUser', $userId, PDO::PARAM_INT);
    if ($idCategory) {
        $query->bindValue(':idCategory', $idCategory, PDO::PARAM_INT);
    }
    $query->execute();
    $lists = $query->fetchAll(PDO::FETCH_ASSOC);

    return $lists;
}


function getListById(PDO $pdo, int $idList):array|bool
{
    $query = $pdo->prepare('SELECT * FROM list WHERE idList = :idList');
    $query->bindValue(':idList', $idList, PDO::PARAM_INT);
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC);
}

function saveList(PDO $pdo, string $titleList, int $userId, int $idCategory, int $idList=null):int|bool
{
    if ($idList) {
        // UPDATE
        $query = $pdo->prepare("UPDATE 'list' SET titleList = :titleList, idCategory = :idCategory,
                                                               idUser = :idUser
                                WHERE idList = :idList");
        $query->bindValue(':idList', $idList, PDO::PARAM_INT);
    } else {
        // insert
        $query = $pdo->prepare("INSERT INTO list (titleList, idCategory, idUser)
                                VALUES (:titleList,  :idCategory, :idUser)");
    }
    $query->bindValue(':titleList', $titleList, PDO::PARAM_STR);
    $query->bindValue(':idCategory', $idCategory, PDO::PARAM_INT);
    $query->bindValue(':idUser',  $userId, PDO::PARAM_INT);

    $res = $query->execute();
    if ($res) {
        if ($idList) {
            return $idList;
        } else {
            return $pdo->lastInsertId();
        } 
    } else {
        return false;
    }
}

function saveListItem(PDO $pdo, string $titleItem, int $idList, bool $status = false, int $idItem=null):bool
{
    if ($idItem) {
        // UPDATE
        $query = $pdo->prepare("UPDATE item SET titleItem = :titleItem, idList = :idList,
                                                        status = :status
                                WHERE idItem = :idItem");
        $query->bindValue(':idItem', $idItem, PDO::PARAM_INT);
    } else {
        // INSERT
        $query = $pdo->prepare("INSERT INTO item (titleItem, idList, status)
                                VALUES  (:titleItem, :idList, :status)");
    }
    $query->bindValue(':titleItem', $titleItem, PDO::PARAM_STR);
    $query->bindValue(':idList', $idList, PDO::PARAM_INT);
    $query->bindValue(':status', $status, PDO::PARAM_BOOL);

    return $query->execute();
    
}

function getListItems(PDO $pdo, int $idList):array
{
    $query = $pdo->prepare("SELECT * FROM item WHERE idList= :idList");
    $query->bindValue(':idList', $idList, PDO::PARAM_INT);
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function deleteListItemById(PDO $pdo, int $idItem):bool
{
    $query = $pdo->prepare("DELETE FROM item WHERE idItem = :idItem");
    $query->bindValue(':idItem', $idItem, PDO::PARAM_INT);
    
    return $query->execute();
}

function updateListItemStatus(PDO $pdo, int $idItem, bool $status):bool
{
    $query = $pdo->prepare("UPDATE item SET status = :status WHERE idItem = :idItem ");
    $query->bindValue(':idItem', $idItem, PDO::PARAM_INT);
    $query->bindValue(':status', $status, PDO::PARAM_BOOL);

    return $query->execute();
}

