<?php
session_start();
require_once 'src/Form/controller/FormController.php';

$form = new \Form\controller\FormController("RegistrationForm");

$form->AddInput(
    ((new \Form\model\input\Text("RegistrationView::Username"))
        ->SetLabel("Username")
        ->SetValidation(
            new \Form\model\validation\Required("You must enter a username"),
            new \Form\model\validation\MinLength(3, "Username must be longer than 3 characters")
        )
    ),
    ((new \Form\model\input\Text("RegistrationView::Firstname"))
        ->SetLabel("First name")
        ->SetValidation(
            new \Form\model\validation\MaxLength(25, "First name must be shorter than 25 characters")
        )
    ),
    ((new \Form\model\input\Text("RegistrationView::LastName"))
        ->SetLabel("Last name")
        ->SetValidation(
            new \Form\model\validation\MaxLength(25, "Last name must be shorter than 25 characters")
        )
    ),
    ((new \Form\model\input\Text("RegistrationView::PersonalIdentification"))
        ->SetLabel("Personal ID")
        ->SetValidation(
            new \Form\model\validation\RegEx("/^(19|20)?[0-9]{6}(-)?[0-9pPtTfF][0-9]{3}$/", "Personal ID must match YYYYMMDD-XXXX")
        )
    ),
    ((new \Form\model\input\Password("RegistrationView::Password"))
        ->SetLabel("Password")
        ->SetValidation(
            new \Form\model\validation\Required("You must fill in a password"),
            new \Form\model\validation\MinLength(6, "Password must be longer than 6 characters")
        )
    ),
    ((new \Form\model\input\Password("RegistrationView::PasswordRepeat"))
        ->SetLabel("Repeat Password")
        ->SetValidation(
            new \Form\model\validation\Required("You must fill in a password"),
            new \Form\model\validation\MinLength(6, "Password must be longer than 6 characters")
        )
        ->SetComparator(new \Form\model\comparator\EqualTo("RegistrationView::Password", "Must match Password"))
    ),
    (new \Form\model\input\Submit("RegistrationView::Register", "Register"))
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