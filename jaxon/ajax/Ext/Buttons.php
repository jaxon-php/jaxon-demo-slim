<?php

namespace Jaxon\Demo\Ajax\Ext;

class Buttons extends \Jaxon\App\Component
{
    public function html(): string
    {
        return $this->view()->render('demo.buttons.ext', ['test' => $this->rq(Test::class)]) . '';
    }
}
