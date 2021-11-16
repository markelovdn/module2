<?php
namespace src;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder
{
    protected $pdo;
    private $queryFactory;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->queryFactory = new QueryFactory('mysql');
    }

    public function getAll ($table) {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])->from($table);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function create($table, $data) {
        $insert = $this->queryFactory->newInsert();

        $insert->into($table)
        ->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }

    public function update($table, $data, $id) {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id' )
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function getOne($table, $id) {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function delete($table, $id) {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());

    }
}