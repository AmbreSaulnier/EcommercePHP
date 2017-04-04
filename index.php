<?php
include 'config.php';
include 'header.php'; ?>

    <div class="container">
        <h1>J'ai fait la Home page !</h1>
        <?php foreach(getProducts(10) as $count => $product) { ?>
            <?php if ( $count % 3 == 0 ) { ?>
                <div class="row">
            <?php } ?>
                <div class="col-sm-4">
                    <h2><?php echo $product['name']; ?></h2>
                    <p><?php echo $product['description']; ?></p>
                </div>
            <?php if ( ($count + 1) % 3 == 0 || $count == 10 -1 ) { ?>
                </div>
            <?php } ?>
        <?php } ?>
        <?php
        $current_page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $max_page = getMaxPagesProducts(10); ?>
        <nav aria-label="Page navigation" class="text-center">
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