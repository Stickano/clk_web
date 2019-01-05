<?php

@session_start();

require_once("models/tls.php");

final class Singleton {

    private static $instance;
    private static $tls;

    # View and Controller
    public static $page;
    public static $controller;

    public static $error;

    # Private constructor to ensure it won't be initialized
    private function __construct(){}

    /**
     * This is the initializer for this object
     * It will initialize a Connection and CRUD class
     * It will determine which View to load and its apropriate Controller
     * It will store the page you hit (nowPage), along with storing the previous page (prePage)
     * And it will initialize a couple of typical classes, like meta and time (used in footer)
     * @return object This (only) instance
     */
    public static function init() {
        if(!isset(self::$instance)){

            self::$instance = new self();

            self::$tls = new Tls();
            self::$tls->secureConnect();

            self::setView();
            self::setController();
            self::checkErrors();
        }

        return self::$instance;
    }

    /**
     * This will determine which page(view) to load
     */
    private static function setView() {

        # Fetch all documents in view/
        $pages = array();
        foreach (glob("views/*.php") as $file) {
            $page    = substr($file, 6, -4);
            $pages[] = $page;
        }

        # Set default value, if available (index)
        $search = array_intersect($pages, array_keys($_GET));
        if(in_array('index', $pages)){
            $pos        = array_keys($pages, 'index')[0];
            self::$page = $pages[$pos];
        }

        # Match them against current Query String (URL)
        if(!empty($search)){
            $search     = array_values($search);
            self::$page = $search[0];
        }
    }

    /**
     * This will load the appropriate controller
     */
    public static function setController() {
        self::$controller = null;
        if (is_file('controllers/'.self::$page.'.php')) {
            require_once('controllers/'.self::$page.'.php');
            $controller       = ucfirst(self::$page).'Controller';
            self::$controller = new $controller();
        }
    }

    /**
     * Checks if any errors, sets $error and unsets session
     * @return          Defines the $error variable
     */
    # TODO: Will change to several errors handling
    private static function checkErrors() {
        if(isset($_SESSION['error'])) {
            self::$error =  $_SESSION['error'];
            unset($_SESSION['error']);
        }
    }

    /**
     * Returns any error message
     * @return string   Error message TODO: Will change
     */
    public static function getErrors() {
        return self::$error;
    }

    /**
     * Will generate '&nbsp;'
     * @param  int    $count The amount of spaces
     * @return string        The spaces
     */
    public function spaces(int $count) {
        $spaces = '';
        for($i=0; $i<$count; $i++){
            $spaces .= '&nbsp;';
        }
        return $spaces;
    }
}

?>
