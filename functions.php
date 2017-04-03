<?php

function getProducts() {
    global $db;
    $query = $db->query('SELECT * FROM product');
    return $query->fetchAll();
}
