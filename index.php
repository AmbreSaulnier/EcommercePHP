<?php
include 'config.php';
include 'header.php'; ?>

    <div class="container">
        <h1>J'ai fait la Home page !</h1>
        <?php foreach(getProducts(10) as $product) {
            var_dump($product);
        } ?>
        <?php
        $current_page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $max_page = getMaxPagesProducts(10); ?>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                // Affiche toutes les pages dans la liste de la pagination
                /*for ($page = 1; $page <= $max_page; $page++) { ?>
                    <li class="<?= ($page == $_GET['page']) ? 'active' : '' ?>"><a href="<?php echo $url ?>?page=<?php echo $page ?>"><?php echo $page; ?></a></li>
                <?php }*/ ?>
                <?php for ($page = $current_page - 5; $page < $current_page; $page++) {
                    if ($page <= 0) { $page = 1; }
                    if ($current_page == 1) { break; }
                    ?>
                    <li><a href="<?php echo $url ?>?page=<?php echo $page ?>"><?php echo $page; ?></a></li>
                <?php } ?>
                <li class="active"><a href="<?php echo $url ?>?page=<?php echo $current_page ?>"><?php echo $current_page; ?></a></li>
                <?php for ($page = $current_page + 1; $page <= $current_page + 5; $page++) { ?>
                    <li><a href="<?php echo $url ?>?page=<?php echo $page ?>"><?php echo $page; ?></a></li>
                <?php } ?>
                <li>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

<?php include 'footer.php'; ?>