<?php
/*
* Ce fichier sert juste au développeur pour ajouter rapidement X produits dans la bdd.
*/
include 'config.php';

// Je supprime tous les produits de ma table avant de regénérer des produits de manière aléatoire
$db->query('DELETE FROM product');

// Je prépare ma requête pour ajouter des produits dans la BDD
$query = $db->prepare('INSERT INTO product(name, description, image, price, quantity) VALUES(:name, :description, :image, :price, :quantity)');

// J'instancie la classe Faker afin de pouvoir générer des données aléatoires
$faker = Faker\Factory::create();

// J'ajoute autant de produits que besoin
for ($i = 0; $i < 1000; $i++) {
    $query->bindValue(':name', $faker->name, PDO::PARAM_STR);
    $query->bindValue(':description', $faker->text, PDO::PARAM_STR);
    $query->bindValue(':image', $faker->imageUrl('640', '480', 'cats'), PDO::PARAM_STR);
    $query->bindValue(':price', $faker->randomFloat(2, 1, 30));
    $query->bindValue(':quantity', $faker->randomDigit, PDO::PARAM_INT);
    $query->execute();
}

echo "1000 produits ajoutés en base de données.";