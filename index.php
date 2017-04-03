<?php
include 'config.php';
include 'header.php'; ?>

    <div class="container">
        <h1>J'ai fait la Home page !</h1>
        <?php foreach(getProducts() as $product) {
            var_dump($product);
        } ?>
    </div>

<?php include 'footer.php'; ?>