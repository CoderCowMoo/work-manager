<?php
$heading = '404 Not Found';
require 'partials/header.php';
require 'partials/nav.php';
?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>The page you are looking for does not exist.
                <?php print ($_SERVER["REQUEST_URI"]); ?>
                </p>
            </div>
        </div>
    </div>
<?php require 'partials/footer.php'; ?>