<?php

include_once('models/curl.php');
include_once('models/client.php');
include_once('models/time.php');

class ProfileController{

    private $uid;
    private $mail;
    private $pw;
    private $uname;
    private $profile;
    private $curl;
    private $client;
    private $time;

    public function __construct(){
        self::validateUser();

        $this->client = new Client();
        $this->time   = new Time(null, 'd.m.Y H:i');
        $this->curl   = new Curl();
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

    /**
     * This will get all the boards from the REST interface
     * @return Array Boards
     */
    public function getBoards(){
        $this->curl->post($this->profile);
        return $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/getall");
    }

    /**
     * This will receive a specific board from the REST interface
     * @return Array Board values
     */
    public function getBoard(){
        $bid = $_GET['Board'];
        $this->curl->post($this->profile);
        return $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/get/".$bid);
    }

    /**
     * This will create a new list via the Profile view.
     * @return  Retuns to current page
     */
    public function createList(){
        $list = $_POST['listName'];

        # If the value is empty, set error and return
        if (empty($list)){
            $_SESSION['error'] = "Empty list value";
            header("location:".$this->client->getUrl());
        }

        $data = ["name" => $list, "boardId" => $_GET['Board'], "created" => $this->time->timestamp(), "id" => uniqid()];

        $this->curl->post($data);
        $response = $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/createlist/".$this->uid);

        if ($response == 1)
            $_SESSION['message'] = "A new list was created.";
        else
            $_SESSION['error'] = "Something went wrong. Try again later.";

        header("location:".$this->client->getUrl());
    }

}

?>