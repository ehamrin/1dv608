<?php


namespace view;


class HTMLPageTemplate
{
    public function Render($output){

        $d = new \DateTime('now');

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
    {$d->format('l')}, the {$d->format('j')}th of {$d->format('F')} {$d->format('Y')}. The time is {$d->format('G')}:{$d->format('i')}:{$d->format('s')}
</body>
</html>
HTML;

    }

}