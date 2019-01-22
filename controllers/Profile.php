<?php

include_once('models/curl.php');
include_once('models/client.php');
include_once('models/time.php');
include_once('models/Card.php');

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
            $_SESSION['error'] = "Empty list value.";
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

    /**
     * This creates and returns a new card model for the view -
     * It holds all the viable info for a card.
     * It holds names, description, checklists and points, and comments.
     * @return Card A card mmodel
     */
    public function getCard() {
        return new Card(self::getBoard(), $_GET["Card"]);
    }

    /**
     * This will update an card. It will be invoked from the view.
     * @param  int    $delete Pass along a true value, to indicate the deletion of the card.
     * @return          Returns the client to the current URL
     */
    public function updateCard(bool $delete = false){
        if (empty($_POST['name'])){
            $_SESSION['error'] = "Empty card name.";
            header("location:".$this->client->getUrl());
        }

        $active = true;
        if ($delete)
            $active = false;

        $card = self::getCard();
        $data = ["name" => $_POST['name'], "description" => $_POST['description'], "active" => $active, "id" => $_GET['Card'], "listId" => $card->listId];

        $this->curl->post($data);
        $response = $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/updatecard/".$this->uid);

        if ($response == 1)
            $_SESSION['message'] = "The card was updated.";
        else
            $_SESSION['error'] = "Something went wrong. Try again later.";

        $head = "&Card=".$_GET['Card'];
        if ($delete)
            $head = null;

        header("location:?Profile&Board=".$_GET['Board'].$head);
    }

    /**
     * Creates a new checklist. Invoked from the view.
     * @return  Returns to the current URl
     */
    public function createChecklist() {
        $check = $_POST['checklist'];
        $card  = self::getCard();

        # If the value is empty, set error and return
        if (empty($check)){
            $_SESSION['error'] = "Empty checklist value.";
            header("location:".$this->client->getUrl());
        }

        # Validate the card
        if(!$card->isCard()){
            $_SESSION['error'] = "Card not found.";
            header("location:".$this->client->getUrl());
        }

        $data = ["name" => $check, "cardId" => $_GET['Card'], "created" => $this->time->timestamp(), "id" => uniqid()];

        $this->curl->post($data);
        $response = $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/createchecklist/".$this->uid);

        if ($response == 1)
            $_SESSION['message'] = "A new checklist was created.";
        else
            $_SESSION['error'] = "Something went wrong. Try again later.";

        header("location:".$this->client->getUrl());
    }

    /**
     * Creates a new checklist point. Invoked from the view.
     * @return  Returns to the current URL.
     */
    public function createChecklistPoint(){
        $point = $_POST['point'];
        $card  = self::getCard();

        # If the value is empty, set error and return
        if (empty($point)){
            $_SESSION['error'] = "Empty checklist point value.";
            header("location:".$this->client->getUrl());
        }

        # Validate the card
        if(!$card->isCard()){
            $_SESSION['error'] = "Card not found.";
            header("location:".$this->client->getUrl());
        }

        $data = ["name" => $point, "checklistId" => $_POST['checkId'], "created" => $this->time->timestamp(), "id" => uniqid()];

        $this->curl->post($data);
        $response = $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/createpoint/".$this->uid);

        if ($response == 1)
            $_SESSION['message'] = "A new checklist point was created.";
        else
            $_SESSION['error'] = "Something went wrong. Try again later.";

        header("location:".$this->client->getUrl());
    }

    /**
     * This will create a comment for a card. This is invoked by the view.
     * @return  Returns the client to the current URL.
     */
    public function createComment(){
        $comment = $_POST['comment'];
        $card    = self::getCard();

        # If the value is empty, set error and return
        if (empty($comment)){
            $_SESSION['error'] = "Empty comment value.";
            header("location:".$this->client->getUrl());
        }

        # Validate the card
        if(!$card->isCard()){
            $_SESSION['error'] = "Card not found.";
            header("location:".$this->client->getUrl());
        }

        $data = ["comment" => $comment, "cardId" => $_GET['Card'], "created" => $this->time->timestamp(), "id" => uniqid()];

        $this->curl->post($data);
        $response = $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/createcomment/".$this->uid);

        if ($response == 1)
            $_SESSION['message'] = "A new comment was created.";
        else
            $_SESSION['error'] = "Something went wrong. Try again later.";

        header("location:".$this->client->getUrl());
    }

    /**
     * This will remove a checklist point. This is invoked from the view.
     * @return  Returns the client to the current URL.
     */
    public function deletePoint(){
        $point = $_POST['okDeletePoint'];
        $card    = self::getCard();

        # Validate the card
        if(!$card->isCard()){
            $_SESSION['error'] = "Card not found.";
            header("location:".$this->client->getUrl());
        }

        $data = ["name" => $_POST['name'], "checklistId" => $_POST['checklistId'], "id" => $point, "active" => false];

        $this->curl->post($data);
        $response = $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/updatepoint/".$this->uid);

        if ($response == 1)
            $_SESSION['message'] = "The checklist point was deleted.";
        else
            $_SESSION['error'] = "Something went wrong. Try again later.";

        header("location:".$this->client->getUrl());
    }

    /**
     * This will delete a checklist. This is invoked from the view.
     * @return  This will return the client to the current URL.
     */
    public function deleteChecklist(){
        $check = $_POST['checkId'];
        $card    = self::getCard();

        # Validate the card
        if(!$card->isCard()){
            $_SESSION['error'] = "Card not found.";
            header("location:".$this->client->getUrl());
        }

        $data = ["name" => $_POST['name'], "cardId" => $_GET['Card'], "id" => $_POST['checkId'], "active" => false];

        $this->curl->post($data);
        $response = $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/updatechecklist/".$this->uid);

        if ($response == 1)
            $_SESSION['message'] = "The checklist point was deleted.";
        else
            $_SESSION['error'] = "Something went wrong. Try again later.";

        header("location:".$this->client->getUrl());
    }

    /**
     * This will delete a comment. This is invoked by the view.
     * @return  Returns the client to the current URL.
     */
    public function deleteComment(){
        $comment = $_POST['commentId'];
        $card    = self::getCard();

        # Validate the card
        if(!$card->isCard()){
            $_SESSION['error'] = "Card not found.";
            header("location:".$this->client->getUrl());
        }

        $data = ["comment" => $_POST['comment'], "cardId" => $_GET['Card'], "id" => $_POST['commentId'], "active" => false];

        $this->curl->post($data);
        $response = $this->curl->curl("http://easj-final.azurewebsites.net/Service1.svc/board/updatecomment/".$this->uid);

        if ($response == 1)
            $_SESSION['message'] = "The comment was deleted.";
        else
            $_SESSION['error'] = "Something went wrong. Try again later.";

        header("location:".$this->client->getUrl());
    }



}

?>