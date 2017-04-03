<?php
include 'config.php';
include 'header.php'; ?>

    <div class="container">
        <h1>J'ai fait la Home page !</h1>
        <?php
            $faker = Faker\Factory::create(); // equivaut à new Faker() ou new PDO()
            for ($i = 0; $i < 10; $i++) {
                echo $faker->address . '<br />';
            }
        ?>
        <?php foreach(getProducts() as $product) {
            var_dump($product);
        } ?>
        
    </div>

<?php include 'footer.php'; ?>