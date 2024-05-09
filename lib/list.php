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
