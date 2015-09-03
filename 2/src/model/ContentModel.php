<?php


namespace model;


class ContentModel
{
    public $title = '1dv608';
    public $header = 'Assignment 2';
    public $authenticated;
    public $body;

    public function __construct($body, $authenticated){
        $this->body = $body;
        $this->authenticated = $authenticated;
    }
}