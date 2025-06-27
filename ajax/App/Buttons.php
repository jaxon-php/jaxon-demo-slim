<?php

namespace Demo\Ajax\App;

use Jaxon\App\NodeComponent;
use Stringable;

/**
 * @exclude
 */
class Buttons extends NodeComponent
{
    public function html(): Stringable
    {
        return $this->view()->render('demo.buttons.app', [
            'test' => $this->rq(Test::class),
        ]);
    }
}
