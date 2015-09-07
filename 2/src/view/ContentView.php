<?php
declare(strict_types=STRICT_TYPING);

namespace view;


class ContentView
{
    public function Render(\model\ContentModel $output) : \string
    {

    return '<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>LoginView Example</title>
  </head>
  <body>
    <h1>' . $output->header . '</h1>
    ' . $this->RenderIsLoggedIn($output->authenticated) . '
    <div class="container">
    ' . $output->body . '
        ' . $this->RenderDate() . '
    </div>
  </body>
</html>';

    }

    private function RenderDate() : \string
    {
        $d = new \DateTime('now');
        return "<p>{$d->format('l')}, the {$d->format('jS')} of {$d->format('F')} {$d->format('Y')}, The time is {$d->format('G')}:{$d->format('i')}:{$d->format('s')}</p>";
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