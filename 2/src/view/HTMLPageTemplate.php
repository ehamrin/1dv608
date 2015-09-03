<?php


namespace view;


class HTMLPageTemplate
{
    public function Render(\model\HTMLPage $output){

    echo '<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Example</title>
  </head>
  <body>
    <h1>' . $output->header . '</h1>
    ' . $this->renderIsLoggedIn($output->authenticated) . '
    <div class="container">
    ' . $output->body . '
        ' . $this->renderDate() . '
    </div>
  </body>
</html>';

    }

    private function renderDate(){
        $d = new \DateTime('now');
        return "<p>{$d->format('l')}, the {$d->format('jS')} of {$d->format('F')} {$d->format('Y')}, The time is {$d->format('G')}:{$d->format('i')}:{$d->format('s')}</p>";
    }

    private function renderIsLoggedIn($isLoggedIn) {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        }
        else {
            return '<h2>Not logged in</h2>';
        }
    }

}