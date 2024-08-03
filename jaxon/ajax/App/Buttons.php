<?php

namespace Jaxon\Demo\Ajax\App;

class Buttons extends \Jaxon\App\Component
{
    public function html(): string
    {
        return $this->view()->render('demo.buttons.app', ['test' => $this->rq(Test::class)]) . '';
    }
}
