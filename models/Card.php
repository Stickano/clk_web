<?php

class Card {

    public $checklists;
    public $comments;
    public $description;
    public $created;
    public $name;
    public $listId;

    private $board;
    private $cardId;

    public function __construct(array $board, string $cardId){
        $this->board      = $board;
        $this->cardId     = $cardId;

        $this->checklists = array();
        $this->comments   = array();

        self::setValues();
        self::getCheck();
        self::getComments();
    }

    /**
     * This will set some of the common values in a card.
     * Description and creation timestamp.
     */
    private function setValues(){
        foreach ($this->board["cards"] as $key) {
            if ($key['id'] == $this->cardId){
                $this->description = $key["description"];
                $this->created     = $key["created"];
                $this->name        = $key["name"];
                $this->listId      = $key['listId'];
            }
        }
    }

    /**
     * This will fill an array of all the associated checklists to the card.
     * @return  Sets $this->checklists
     */
    private function getCheck(){
        foreach ($this->board["checklists"] as $key) {
            if ($key["cardId"] == $this->cardId)
                $this->checklists[] = $key;
        }
    }

    /**
     * This will return all the points for a checklist.
     * @param  string $checkId The ID of the checklist to return points for
     * @return array          All the points in the checklist.
     */
    public function getPoints(string $checkId){
        $points = array();

        foreach ($this->board["points"] as $key) {
            if ($key['checklistId'] == $checkId)
                $points[] = $key;
        }

        return $points;
    }

    /**
     * This will get all the comments for the card
     * @return  Sets $this->comments
     */
    private function getComments(){
        foreach ($this->board["comments"] as $key) {
            if ($key['cardId'] == $this->cardId)
                $this->comments[] = $key;
        }
    }

    /**
     * This will confirm if the card ID is a valid card.
     * @return boolean True/False if card ID is found or not.
     */
    public function isCard(){
        foreach ($this->board['cards'] as $key) {
            if ($key['id'] == $this->cardId)
                return true;
        }

        return false;
    }

}

?>