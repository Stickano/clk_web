<?php

class Credentials {

    private $host = '';
    private $user = '';
    private $pass = '';
    private $db   = '';

    /**
     * Returns the values defined above
     * @return bool|array false if missing value(s),
     *                     array of values if set.]
     */
    public function get(){
        if (   empty($this->host)
            || empty($this->user)
            || empty($this->pass)
            || empty($this->db))
            return false;

        return array('host' => $this->host,
                     'user' => $this->user,
                     'pass' => $this->pass,
                     'db'   => $this->db);
    }
}

?>