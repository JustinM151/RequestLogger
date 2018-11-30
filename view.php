<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 11/30/18
 * Time: 2:31 PM
 */
$requests = file("log.txt", FILE_SKIP_EMPTY_LINES);
$requests = array_reverse($requests); //order it newest to oldest
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Request Logger</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="view.php?view=10">Show 10 <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view.php?view=50">Show 50</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="view.php?view=all">Show All</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Request Log</h3>
            <table class="table table-striped">
            <?php
            foreach ($requests as $req) {
                $pos = strpos($req,"captures/");
                if($pos !== false) {
                    $getFrom = ((strlen($req)-$pos)*-1);
                    echo "
                    <!-- Position: ".$getFrom." -->
                    ";
                    $file = substr($req,$getFrom);
                    echo "
                    <!-- File: ".$file." -->
                    ";
                    $parts = explode(' ',$file);
                    $viewing = !empty($_GET['view']) ? '&view='.$_GET['view'] : '';
                    $link = "view.php?file=".$parts[1].$viewing;
                } else {
                    $link = '#';
                }
                echo "<tr><td><a href='{$link}'>".$req."</a></td></tr>";
            }
            ?>
            </table>
        </div>

        <div class="col-md-6">
            <h3>Request Data</h3>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
