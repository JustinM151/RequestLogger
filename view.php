<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 11/30/18
 * Time: 2:31 PM
 */
$requests = file("log.txt", FILE_SKIP_EMPTY_LINES);
$requests = array_reverse($requests); //order it newest to oldest

if(!empty($_GET['view'])) {
    if($_GET['view']!="all") {
        $requests = array_slice($requests,0,$_GET['view']);
    }
} else {
    $requests = array_slice($requests,0,25);
}

if(!empty($_GET['file'])) {
    $fData = file_get_contents('captures/'.$_GET['file']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style type="text/css">
        .shrink {
            width: 1px;
            white-space: nowrap;
        }
    </style>
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
                    <a class="nav-link" href="view.php?view=25">Show 25 <span class="sr-only">(current)</span></a>
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
        <div class="col-md-5">
            <h3>Request Log</h3>
            <table class="table table-striped">
                <th>DATE</th>
                <th>DESCRIPTION</th>
            <?php
            foreach ($requests as $req) {
                $parts = explode(',',$req);
                $date = $parts[0];
                $type = $parts[1];
                if($type=="REQUEST") {
                    $file = str_ireplace("captures/","",$parts[2]);
                    $viewing = !empty($_GET['view']) ? '&view='.$_GET['view'] : '';
                    $link = "view.php?file=".$file.$viewing;
                    echo "<tr><td  class='shrink'>{$date}</td><td><a href='{$link}'>Request Logged</a></td></tr>";
                } else {
                    echo "<tr class='table-danger'><td  class='shrink'>{$date}</td><td>Error saving request data.</td></tr>";
                }
            }
            ?>
            </table>
        </div>

        <div class="col-md-7">
            <?php
            if(!empty($fData)) {
                ?>
            <div class="card border-primary mb-3">
                <div class="card-header"><h4 class="card-title">Request Data</h4></div>
                <div class="card-body">
                    <?php
                    echo "<pre class='well'>".htmlentities($fData)."</pre>";
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>


<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>
