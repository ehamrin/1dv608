<?php
declare(strict_types=STRICT_TYPING);

namespace view;


class ContentView
{
    public function Render(\string $output, \bool $loggedIn) : \string
    {

    return '<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>LoginView Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style/style.css" rel="stylesheet">
  </head>
  <body>

        <h1>Assignment 4</h1>
        <div id="wrapper">
            ' . $this->RenderIsLoggedIn($loggedIn) . '
            <div class="container">
                ' . $output . '
                ' . $this->RenderDate() . '
            </div>
        </div>
  </body>
</html>';

    }

    private function RenderDate() : \string
    {
        $d = new \DateTime('now');
        return "<p class='date'>{$d->format('l')}, the {$d->format('jS')} of {$d->format('F')} {$d->format('Y')}, The time is {$d->format('G')}:{$d->format('i')}:{$d->format('s')}</p>";
    }

    private function RenderIsLoggedIn(\bool $isLoggedIn) : \string
    {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        }
        else {
            return '<h2>Not logged in</h2>';
        }
    }

}