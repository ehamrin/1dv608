# 1dv608

Project documentation
##Why should I use it?
1. Never trust your client. You should always validate every single input accquired from a user.
2. Repeating lots of HTML markup takes a toll on any developer, it's just not fun anymore.
3. Writing validation for every input and displaying a proper message takes time, and it's no fun either.
4. Save yourself some time! If you're missing any validation, add it! Take a look at the existing validator and create your own, should take less than 5 minutes!

##How do I use it?
1. See the link below for an example on how to use the controllers and inputs.
    * http://1dv608.erikhamrin.se/Project/example-usage.php
    * For a more typical integration: https://github.com/ehamrin/1dv608/blob/project/Project_4/src/view/RegistrationView.php
2. Download the directory and place it in you project
3. Make sure the FormController is included (with an autloader or require_once etc.)
4. Take a look at the Settings class and tweak it to your needs.
5. Create extra templates if you want for your inputs.
6. You should now be able to save some time by not writing hundreds of lines of HTML and input validation!



##Integration tests avaiable
Integration tests:

1. Throws exception if two input fields have the same name
2. No exception thrown if two input fields have different names
3. Submitted form without data passes if there are no validators
4. Submitted form without data fails if there are any required validators
5. Submitted form with data succeeds if there are any required validators
6. Submitted form shows error message if it is not valid
7. UNsubmitted form does not show error message if it is not valid

See tests here: https://github.com/ehamrin/1dv608/blob/project/Project/tests/FormControllerTest.php


##Unit tests
###Comparator suite
https://github.com/ehamrin/1dv608/blob/project/Project/tests/ComparatorTest.php

###Validation Suite
https://github.com/ehamrin/1dv608/blob/project/Project/tests/ValidatorTest.php

