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

    # Action locations for forms
    if (isset($_POST['okCreateList']))
        $controller->createList();


    # Return the user to profile, if the board wasn't found
    $board = $controller->getBoard();
    if (empty($board)){
        $_SESSION['error'] = "Board not found.";
        //header("location:?Profile");
    }

    # Print out the board information
    echo'<h1>'.$board["name"].'</h1>';

    # Create new list
    echo'<form method="post" style="margin-top:15px;">';
        echo'<input type="text" name="listName" placeholder="New list"> '.$singleton->spaces(2);
        echo'<input type="submit" name="okCreateList" value="Create">';
    echo'</form>';

    echo'<h3>Available lists</h3>';
    if (empty($board["lists"]))
        echo'No lists available.';

    echo'<div class="">';
    foreach ($board["lists"] as $key) {
        echo'';
    }
    echo'</dvi>';

    var_dump($board);
}


?>