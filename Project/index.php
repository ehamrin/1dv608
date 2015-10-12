<?php
session_start();
require_once 'src/Form/controller/FormController.php';

$form = new \Form\controller\FormController("RegistrationForm");

use \Form\model\Option;
use \Form\model\input;
use \Form\model\validation;
use \Form\model\comparator;

$form->AddInput(
    ((new input\Text("RegistrationView::Username"))
        ->SetLabel("Username")
        ->SetValidation(
            new validation\Required("You must enter a username"),
            new validation\MinLength(3, "Username must be longer than 3 characters")
        )
    ),
    ((new input\Text("RegistrationView::Firstname"))
        ->SetLabel("First name")
        ->SetValidation(
            new validation\MaxLength(25, "First name must be shorter than 25 characters")
        )
    ),
    ((new input\Text("RegistrationView::LastName"))
        ->SetLabel("Last name")
        ->SetValidation(
            new validation\MaxLength(25, "Last name must be shorter than 25 characters")
        )
    ),
    ((new input\Text("RegistrationView::PersonalIdentification"))
        ->SetLabel("Personal ID")
        ->SetValidation(
            new validation\RegEx(validation\RegEx::SWEDISH_PID, "Personal ID must match YYYYMMDD-XXXX")
        )
    ),
    ((new input\Text("RegistrationView::PostalCode"))
        ->SetLabel("Postal Code")
        ->SetValidation(
            new validation\RegEx("/^\d{3}(\s)?\d{2}$/", 'Postal code must be 5 digits')
        )
    ),
    ((new input\Password("RegistrationView::Password"))
        ->SetLabel("Password")
        ->SetValidation(
            new validation\Required("You must fill in a password"),
            new validation\MinLength(6, "Password must be longer than 6 characters")
        )
        ->SetComparator(new comparator\EqualTo("RegistrationView::PasswordRepeat", "Must match Repeat Password"))
    ),
    ((new input\Password("RegistrationView::PasswordRepeat"))
        ->SetLabel("Repeat Password")
        ->SetValidation(
            new validation\Required("You must fill in a password"),
            new validation\MinLength(6, "Password must be longer than 6 characters")
        )
        ->SetComparator(new comparator\EqualTo("RegistrationView::Password", "Must match Password"))
    ),
    ((new input\Select("RegistrationView::SelectAge"))
        ->SetLabel("Age")
        ->AddOption(
            new Option("10-17", 17),
            new Option("18-25", 25),
            new Option("25-30", 30),
            new Option("30-35", 35),
            new Option("35-40", 40),
            new Option("40-45", 45),
            new Option("45-50", 50)
        )
        ->SetValidation(new validation\LargerThanEqual(18, "You must be 18 or older to register"))
    ),
    ((new input\Textarea("RegistrationView::Bio"))
        ->SetLabel("Describe yourself")
        ->SetValidation(new validation\MaxLength(150, "You can only use 150 characters, don't write an essay!"))
    ),
    ((new input\Radio("RegistrationView::Gender"))
        ->SetLabel("Pick gender")
        ->AddOption(
            new Option("Male", '1'),
            new Option("Female", '2'),
            new Option("Other", '3')
        )
        ->SetValidation(new validation\Required("You must select a gender"))
    ),
    ((new input\Checkbox("RegistrationView::Human"))
        ->SetLabel("Are you human?")
        ->SetValidation(new validation\Required("You must check this"))
    ),
    (new input\Submit("RegistrationView::Register", "Register"))
);

$message = "";
if($form->WasSubmitted()){
    $message = "Successfully submitted the form";
}

?>

<!DOCTYPE html>
<html>
<head lang="en">
        <meta charset="UTF-8">
        <title>Form Wrapper and Validator</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="style.css" rel="stylesheet">
</head>
<body>

<h1>1DV608 Project</h1>
<p><?php echo $message; ?></p>
<?php echo $form->GetView(); ?>

</body>
</html>