<?php

# Board Overview
if (!isset($_GET['Board'])){
    echo'<h5 style="margin-top:65px;">Available boards:</h5>';
    foreach ($controller->getBoards() as $key => $value) {
        echo '<a href="?Profile&Board='.$value['id'].'">'.$value['name'].'</a>';
        echo '<br>';
    }
}


if (isset($_GET['Board'])){
    var_dump($controller->getBoard());
}


?>