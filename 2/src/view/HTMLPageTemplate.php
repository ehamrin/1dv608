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

  <title>{$output->title}</title>
</head>

<body>
    {$output->header}
    {$output->body}
</body>
</html>
HTML;

    }

}