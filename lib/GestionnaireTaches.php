<?php

class Tache
{
    private int $idItem;
    private string $titleItem;
    private bool $status;
    private int $idList;

    public function __construct(string $titleItem, int $idList, bool $status = false, int $idItem = 0)
    {
        $this->titleItem = $titleItem;
        $this->idList = $idList;
        $this->status = $status;
        $this->idItem = $idItem;
    }

    public function getIdItem(): int { return $this->idItem; }
    public function getTitleItem(): string { return $this->titleItem; }
    public function getStatus(): bool { return $this->status; }
    public function getIdList(): int { return $this->idList; }
    public function setTitleItem(string $titleItem): void { $this->titleItem = $titleItem; }
    public function setStatus(bool $status): void { $this->status = $status; }
}

class GestionnaireTaches
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTachesByList(int $idList): array
    {
        $query = $this->pdo->prepare("SELECT * FROM item WHERE idList = :idList");
        $query->bindValue(':idList', $idList, PDO::PARAM_INT);
        $query->execute();
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        $taches = [];
        foreach ($rows as $row) {
            $taches[] = new Tache($row['titleItem'], $row['idList'], (bool)$row['status'], $row['idItem']);
        }
        return $taches;
    }

    public function saveTache(Tache $tache, ?int $idItem = null): bool
    {
        if ($idItem) {
            $query = $this->pdo->prepare("UPDATE item SET titleItem = :titleItem, status = :status WHERE idItem = :idItem");
            $query->bindValue(':idItem', $idItem, PDO::PARAM_INT);
        } else {
            $query = $this->pdo->prepare("INSERT INTO item (titleItem, idList, status) VALUES (:titleItem, :idList, :status)");
            $query->bindValue(':idList', $tache->getIdList(), PDO::PARAM_INT);
        }
        $query->bindValue(':titleItem', $tache->getTitleItem(), PDO::PARAM_STR);
        $query->bindValue(':status', $tache->getStatus(), PDO::PARAM_BOOL);
        return $query->execute();
    }

    public function deleteTache(int $idItem): bool
    {
        $query = $this->pdo->prepare("DELETE FROM item WHERE idItem = :idItem");
        $query->bindValue(':idItem', $idItem, PDO::PARAM_INT);
        return $query->execute();
    }

    public function updateStatut(int $idItem, bool $status): bool
    {
        $query = $this->pdo->prepare("UPDATE item SET status = :status WHERE idItem = :idItem");
        $query->bindValue(':idItem', $idItem, PDO::PARAM_INT);
        $query->bindValue(':status', $status, PDO::PARAM_BOOL);
        return $query->execute();
    }
}