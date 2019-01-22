<?php

 if (isset($_POST['okUpdateCard']))
    $controller->updateCard();
 if (isset($_POST['okDeleteCard']))
    $controller->updateCard(true);
if (isset($_POST['okDeletePoint']))
    $controller->deletePoint();
if (isset($_POST['okDeleteChecklist']))
    $controller->deleteChecklist();
if (isset($_POST['okDeleteComment']))
    $controller->deleteComment();
if (isset($_POST['okCreateChecklist']))
    $controller->createChecklist();
if (isset($_POST['okCreateChecklistPoint']))
    $controller->createChecklistPoint();
if (isset($_POST['okCreateComment']))
    $controller->createComment();

# Board Overview
if (!isset($_GET['Board'])){
    echo'<h5>Available boards:</h5>';
    foreach ($controller->getBoards() as $key => $value) {
        echo '<a href="?Profile&Board='.$value['id'].'">'.$value['name'].'</a>';
        echo '<br>';
    }
}

# If a specific board is selected
if (isset($_GET['Board']) && !isset($_GET['Card'])){

    # Action locations for forms
    if (isset($_POST['okCreateList']))
        $controller->createList();


    # Return the user to profile, if the board wasn't found
    $board = $controller->getBoard();
    if (empty($board)){
        $_SESSION['error'] = "Board not found.";
        header("location:?Profile");
    }

    # Print out the board information
    if (!isset($_GET['Edit'])){
        echo'<a href="?Profile" title="Return to board overview"><i class="fas fa-undo"></i></a>';
        echo'<h1>'.$board["name"].' <a class="editHead" title="Edit Board" href="?Profile&Board='.$_GET['Board'].'&Edit"><i class="fas fa-edit"></i></a></h1>';
    }else{
        echo'<a href="?Profile&Board='.$_GET['Board'].'" title="Cancel edit and return"><i class="fas fa-undo"></i></a>';
        echo'<form method="post">';
        echo'<input type="text" name="name" value="'.$board['name'].'">'.$singleton->spaces(2);
        echo'<button type="submit" class="subIcon green" title="Update board" name="okUpdateBoard"><i class="fas fa-check-square"></i></button>';
        echo'<button type="submit"
                     onClick="return confirm(\'Are you sure you want to delete?\')"
                     class="subIcon red"
                     title="Delete board"
                     name="okDeleteBoard"><i class="fas fa-trash"></i></button>';
        echo'</form>';
    }

    //var_dump($board);

    # Create new list
    if (!isset($_GET['Edit'])){
        echo'<form method="post" style="margin-top:15px;">';
            echo'<input type="text" name="listName" placeholder="New list"> '.$singleton->spaces(2);
            echo'<input type="submit" name="okCreateList" value="Create">';
        echo'</form>';
    }

    echo'<h3>Available lists</h3>';
    if (empty($board["lists"]))
        echo'No lists available.';

    echo'<div class="flex-container">';
    foreach ($board["lists"] as $key) {
        echo'<form method="post">';
        echo'<input type="hidden" name="" value="">';
        echo'<input type="hidden" name="" value="">';
        echo'<div class="flex-item">';
            echo'<b>'.$key['name'].'</b>';

            if(isset($_GET['Edit']))
                echo'<button type="submit"
                     onClick="return confirm(\'Are you sure you want to delete?\')"
                     class="subIcon red"
                     title="Delete list"
                     name="okDeleteList"><i class="fas fa-trash"></i></button>';

            echo'<br>';

            foreach ($board['cards'] as $card) {
                if ($card['listId'] == $key['id']) {
                    if (isset($_GET['Edit'])){
                        echo'<button class="subIcon red"
                                     type="submit"
                                     name="okDeleteCard"
                                     onClick="return confirm(\'Are you sure you want to delete?\')"
                                     value="'.$card['id'].'"><i class="fas fa-trash"></i></button>';
                        echo'<input type="hidden" name="name" value="'.$card['name'].'"> '.$card['name'].'<br>';
                        echo'<input type="hidden" name="checklistId" value="'.$card['listId'].'">';
                    }else{
                        echo'<a href="?Profile&Board='.$_GET['Board'].'&Card='.$card['id'].'">'.$card['name'].'</a><br>';
                    }
                }
            }

        echo'</div>';
        echo'</form>';
    }
    echo'</dvi>';

}


# If a specific card is selected
if (isset($_GET['Board']) && isset($_GET['Card'])){

    $card = $controller->getCard();

    # Send back if the card was not found
    if (!$card->isCard()) {
        $_SESSION['error'] = "Card not found.";
        header("location:?Profile");
    }

    # Show card info, or give option to edit the values
    if (!isset($_GET['Edit'])){
        echo'<a href="?Profile&Board='.$_GET['Board'].'" title="Return to board"><i class="fas fa-undo"></i></a>';
        echo'<h1>'.$card->name.' <a class="editHead" title="Edit Card" href="?Profile&Board='.$_GET['Board'].'&Card='.$_GET['Card'].'&Edit"><i class="fas fa-edit"></i></a></h1>';
        echo'<p>'.$card->description.'</p>';
    }else{ # Edit
        echo'<a href="?Profile&Board='.$_GET['Board'].'&Card='.$_GET['Card'].'" title="Cancel edit and return"><i class="fas fa-undo"></i></a>';
        echo'<form method="post">';
        echo'<input type="text" name="name" value="'.$card->name.'">'.$singleton->spaces(2);
        echo'<button type="submit" class="subIcon green" title="Update card" name="okUpdateCard"><i class="fas fa-check-square"></i></button>';
        echo'<button type="submit"
                     onClick="return confirm(\'Are you sure you want to delete?\')"
                     class="subIcon red"
                     title="Delete card"
                     name="okDeleteCard"><i class="fas fa-trash"></i></button>';
        echo'<br>';
        echo'<textarea name="description" style="width:300px; height:85px; margin-top:5px;" placeholder="Card description">'.$card->description.'</textarea>';
        echo'<br>';
        echo'</form>';
        echo'<br><br>';
    }

    echo'<br>';

    # Create new checklist
    if (!isset($_GET['Edit'])){
        echo'<form method="post">';
        echo'<input type="text" name="checklist" placeholder="New checklist">'.$singleton->spaces(2);
        echo'<input type="submit" name="okCreateChecklist" value="Create">';
        echo'</form>';
        echo'<br><br>';
    }

    # Print out checklists
    foreach ($card->checklists as $key) {
        echo'<form method="post">';
        echo'<h5>'.$key['name'];
        echo'<input type="hidden" name="checkId" value="'.$key['id'].'">';
        echo'<input type="hidden" name="name" value="'.$key['name'].'">';
        if(isset($_GET['Edit']))
            echo'<button type="submit"
                     onClick="return confirm(\'Are you sure you want to delete?\')"
                     class="subIcon red"
                     title="Delete checklist"
                     name="okDeleteChecklist"><i class="fas fa-trash"></i></button>';
        echo'</h5>';
        echo'</form>';

        # Print out checklist points
        foreach ($card->getPoints($key['id']) as $point) {
            $checked = null;

            if ($point['isCheck'])
                $checked = "checked";

            echo'<form method="post">';
            if (!isset($_GET['Edit']))
                echo'<input type="checkbox" name="'.$point['id'].'" '.$checked.'> ';

            if (isset($_GET['Edit'])){
                echo'<button class="subIcon red"
                             type="submit"
                             name="okDeletePoint"
                             onClick="return confirm(\'Are you sure you want to delete?\')"
                             value="'.$point['id'].'"><i class="fas fa-trash"></i></button>';
                echo'<input type="hidden" name="name" value="'.$point['name'].'">';
                echo'<input type="hidden" name="checklistId" value="'.$point['checklistId'].'">';
            }

            echo $point['name'].'<br>';
            echo'</form>';
        }

        # New checklist point
        if (!isset($_GET['Edit'])){
            echo'<form method="post">';
            echo'<input type="hidden" name="checkId" value="'.$key['id'].'">';
            echo'<input type="text" name="point" placeholder="New checklist point">'.$singleton->spaces(2);
            echo'<input type="submit" name="okCreateChecklistPoint" value="Create">';
            echo'</form>';
        }

        echo'<br><br>';
    }

    # Create a new comment
    if (!empty($card->comments) && !isset($_GET['Edit']) || !isset($_GET['Edit']))
        echo'<h3 style="margin-top:45px;">Comments</h3>';

    if (!isset($_GET['Edit'])){
        echo'<form method="post">';
        echo'<textarea name="comment" style="width:300px; height:85px;" placeholder="New comment"></textarea>';
        echo'<br>';
        echo'<input type="submit" name="okCreateComment" value="Create">';
        echo'</form>';
    }

    # Print out all comments
    foreach ($card->comments as $key) {
        echo'<form method="post">';
        echo'<input type="hidden" name="comment" value="'.$key['comment'].'">';
        echo'<input type="hidden" name="commentId" value="'.$key['id'].'">';
        echo'<h5>'.$key['created'];
        if (isset($_GET['Edit']))
            echo'<button type="submit"
                     class="subIcon red"
                     title="Delete comment"
                     onClick="return confirm(\'Are you sure you want to delete?\')"
                     name="okDeleteComment"><i class="fas fa-trash"></i></button>';
        echo'</h5>';
        echo'<div class="frame">'.$key['comment'].'</div>';
        echo'</form>';
    }
}


?>