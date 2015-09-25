<?php
declare(strict_types=STRICT_TYPING);

namespace model;


class ContentModel
{
    public $title = '1dv608';
    public $header = 'Assignment 4';
    public $authenticated;
    public $body;

    public function __construct(\string $body, \bool $authenticated){
        $this->body = $body;
        $this->authenticated = $authenticated;
    }
}