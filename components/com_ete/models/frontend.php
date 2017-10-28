<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class EteModelFrontend extends JModelItem {

    protected $message;

    public function getMsg() {
        if (!isset($this->message)) {
            $this->message = 'Lorem Ipsum';
        }

        return $this->message;
    }

}
