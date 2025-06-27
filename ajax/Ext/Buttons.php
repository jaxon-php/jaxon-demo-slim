<?php

namespace Demo\Ajax\Ext;

use Jaxon\App\NodeComponent;
use Stringable;

/**
 * @exclude
 */
class Buttons extends NodeComponent
{
    public function html(): Stringable
    {
        return $this->view()->render('demo.buttons.ext', [
            'test' => $this->rq(Test::class),
        ]);
    }
}
