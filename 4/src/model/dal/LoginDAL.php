<?php
declare(strict_types=STRICT_TYPING);

namespace model\dal;


class LoginDAL extends SessionStorage
{
    private static $sessionLocation = "\\Model\\Login::Logged_In";
}