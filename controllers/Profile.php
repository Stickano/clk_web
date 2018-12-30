<?php

include_once('models/curl.php');

class ProfileController{

    private $uid;
    private $mail;
    private $pw;
    private $uname;
    private $profile;
    private $curl;

    public function __construct(){
        self::validateUser();
        $this->curl = new Curl();
        $this->curl->showError(true);
    }

    /**
     * Validate the user, or send him on his merry way, if not logged in.
     * @return    Sets $this->uid
     */
    private function validateUser(){
        if(!isset($_SESSION['clk_uid'])){
            $_SESSION['error'] = "Ah ah ah";
            header("location:index.php");
        }

        $this->uid   = $_SESSION['clk_uid']['id'];
        $this->mail  = $_SESSION['clk_uid']['email'];
        $this->pw    = $_SESSION['clk_uid']['passw'];
        $this->uname = $_SESSION['clk_uid']['uname'];

        $this->profile = ['id' => $this->uid, 'email' => $this->mail, 'password' => $this->pw];

    }

    public function getBoards(){
        $this->curl->post($this->profile);
        return $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/getall");
    }

    public function getBoard(){
        $bid = $_GET['Board'];
        $this->curl->post($this->profile);
        return $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/get/".$bid);
    }

}

?>