<?php


class PasswordTooShortException extends Exception{}
class PasswordMissingException extends PasswordTooShortException{}
class PasswordMismatchException extends Exception{}

class UsernameInvalidException extends Exception{}
class UsernameTooShortException extends Exception{}
class UsernameMissingException extends UsernameTooShortException{}

class DatabaseConnectionException extends Exception{}
