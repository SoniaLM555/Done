<?php 

function getListsByUserId(PDO $pdo, int $userId): array
{
    $query = $pdo->prepare("SELECT `list`.*, category.titleCategory,
                            category.icon FROM `list`
                            JOIN category ON category.idCategory = `list`.idCategory
                            WHERE idUser = :idUser");
    $query->bindValue(':idUser', $userId, PDO::PARAM_INT);
    $query->execute();
    $lists = $query->fetchAll(PDO::FETCH_ASSOC);

    return $lists;
}

function saveList(PDO $pdo, string $titleList, int $idUser, int $idCategory, int $idList=null):int|bool
{
    if ($idList) {
        // UPDATE
    } else {
        // insert
        $query = $pdo->prepare("INSERT INTO 'list' (titleList, idCategory, idUser)
                                VALUES (:titleList,  :idCategory, :idUser)");
    }
    $query->bindValue(':titleList', $titleList, PDO::PARAM_STR);
    $query->bindValue(':idCategory', $idCategory, PDO::PARAM_INT);
    $query->bindValue(':idUser',  $idUser, PDO::PARAM_INT);

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
