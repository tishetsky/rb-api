<?php

function db(): \PDO
{
    return \App\DBFactory::getDbInstance();
}

function pdo_st(string $sql, array $params): \PDOStatement
{
    $st = db()->prepare($sql);
    $st->execute($params);

    return $st;
}

function encrypted(string $password)
{
    return hash_hmac('sha256', $password, 's3cr3t');
}
