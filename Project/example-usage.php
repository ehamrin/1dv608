<?php
$start_time = microtime(TRUE);
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
    ((new input\Text("RegistrationView::Email", "", "email"))
        ->SetLabel("Email")
        ->SetValidation(
            new validation\Required("You must enter an email"),
            new validation\Email("Email is not valid")
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
        ->SetAttributes(
            new Option("data-id", 3),
            new Option("onchange", "alert('I have an extra attribute defined, but you should NOT use inline JavaScript, it is not pretty, but it lets you know what is available')")
        )
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
    ((new input\Checkbox("RegistrationView::Template"))
        ->SetLabel("Using custom template")
        ->SetTemplateName("Left")
    ),
    ((new input\Checkbox("test[employee][3]"))
        ->SetLabel("Using array naming")
    ),
    ((new input\Checkbox("test[employee][4]"))
        ->SetLabel("Using array naming2")
    ),
    (new input\Submit("RegistrationView::Register", "Register"))
);


if($form->WasSubmitted()){
    $data = $form->GetData();
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
<p class="info center">
    This form required ~115 lines of code. <br/>
    The HTML you'd have to write is about the same, and that is without <strong>any</strong> validation.<br/>
    <small>Execution time: <?php echo round(microtime(TRUE) - $start_time, 4); ?>s</small>
</p>
<p class="warning center">
    For a more complex example, see <a href="https://github.com/ehamrin/1dv608/tree/master/Project_4" target="_blank">Assignment 4 for course 1DV608</a> with the Form Handler integrated.<br/>
    The form is used in <a href="https://github.com/ehamrin/1dv608/blob/project/Project_4/src/view/RegistrationView.php" target="_blank"><code>src/view/RegistrationView</code></a> and <a href="https://github.com/ehamrin/1dv608/blob/project/Project_4/src/view/LoginView.php" target="_blank"><code>src/view/LoginView</code></a><br/>
    The application can be tested live <a href="http://1dv608.erikhamrin.se/Project_4/" target="_blank">here</a>

</p>
<pre class="result"><?php if(isset($data)) var_dump($data); ?></pre>
<?php echo $form->GetView(); ?>

<div class="gist">
    <h2>Source code</h2>
    <span><em>(<a href="http://gist-it.appspot.com/">http://gist-it.appspot.com/</a>)</em></span>
    <script src="http://gist-it.appspot.com/https://github.com/ehamrin/1dv608/blob/master/Project/example-usage.php?footer=0"></script>
</div>

<div class="source-code"><a href="https://github.com/ehamrin/1dv608/tree/master/Project" target="_blank">See it on GitHub!</a></div>

</body>
</html>