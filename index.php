<?php
echo'<!DOCTYPE html>';
echo'<html lang="da">';
echo'<head>';

	# Include the meta/headers
    require_once('resources/meta.php');

echo'</head>';
echo'<body>';

# Print errors & messages
if($singleton->getErrors() || $singleton->getMsg()) {

    if ($singleton->getErrors()){
        $msg = $singleton->getErrors();
        $color = "#d9534f";
    }else{
        $msg = $singleton->getMsg();
        $color = "#8C9440";
    }

    echo '<div id="errorContainer" style="background-color:'.$color.';">';
        echo $msg;
        echo '<button class="right" id="closeError">&#10006;</button>';
    echo '</div>';
}

echo'<div class="wrapper">';
    echo'<div id="navigation"> <ul>';

        # Bold font for current page in menu
        $isHome = "style='font-weight:bold;'";
        $isArg  = null;
        $isCont = null;
        $isProfile = null;

        if (isset($_GET['Argument_usage_and_examples'])){
            $isHome = null;
            $isArg = "style='font-weight:bold;'";
        }
        if (isset($_GET['Continuous_running'])){
            $isHome = null;
            $isCont = "style='font-weight:bold;'";
        }
        if (isset($_GET['Profile'])){
            $isHome = null;
            $isProfile = "style='font-weight:bold;'";
        }

        # Menu
        echo'<li '.$isHome.'><a href="index.php">Home</a></li>';
        if (isset($_SESSION['clk_uid'])) {
            echo'<li '.$isProfile.'><a href="index.php?Profile">Profile</a>';
            echo $singleton->spaces(2);
            echo'<a href="resources/logout.php" title="Log out"><i class="fas fa-sign-out-alt"></i></a>';
            echo'</li>';
        }
        echo'<li '.$isArg.'><a href="?Argument_usage_and_examples" title="Argument usage and examples" class="page">Argument usage and examples</a></li>';
        echo'<li '.$isCont.'><a href="?Continuous_running" title="Continuous running" class="page">Continuous running</a></li>';

        # Login form
        if (!isset($_SESSION['clk_uid'])){
            echo'<form method="post" action="resources/login.php" style="margin-top:80px;">';
            echo'<input type="text" name="clk_uname" placeholder="E-mail">';
            echo'<br>';
            echo'<input type="password" name="clk_upass" placeholder="Password">';
            echo'<br>';
            echo'<input type="submit" name="okLogin" value="Sign in">';
            echo $singleton->spaces(2);
            echo'<input type="submit" name="okSignUp" value="Register">';
            echo'</form>';
        }


    echo'</ul> </div>';
    echo'<div id="content">';

    # This will load the appropriate view
    require_once('views/'.$singleton::$page.'.php');

    echo '</div>';
echo'</div>';


    # Load generel/extra JS document
    echo '<script src="js/extra.js"></script>';

    # Load page specific JS document
    if (is_file('js/'.$singleton::$page.'.js'))
        echo '<script src="js/'.$singleton::$page.'.js"></script>';

echo'</body>';
echo'</html>';
?>
