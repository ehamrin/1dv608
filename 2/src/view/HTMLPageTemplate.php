<?php


namespace view;


class HTMLPageTemplate
{
    public function Render($output){

        return <<<HTML
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>1dv608</title>
</head>

<body>
    {$output}
</body>
</html>
HTML;

    }

}