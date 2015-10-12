<?php


namespace Form;


class Settings
{
    public static $UseFormAutoLoader = TRUE;
    public static $UsePRG = TRUE;
    /*
     * If false, the checkbox index will not be populated when exported from the FormHandler if it is not checked, if it is, it will export "on"
     * If true, the index will always be populated with true or false
     */
    public static $PopulateCheckboxIndex = TRUE;
}