<?php

namespace Demo\Ajax\Ext;

use Demo\Service\ExampleInterface;
use Jaxon\App\NodeComponent;
use Jaxon\App\Dialog\DialogTrait;

class Test extends NodeComponent
{
    use DialogTrait;

    public function __construct(private ExampleInterface $example)
    {}

    public function html(): string
    {
        $isCaps = $this->stash()->get('is_caps', false);
        return $this->example->message($isCaps);
    }

    /**
     * @inheritDoc
     */
    protected function after()
    {
        $text = $this->view()->render('test.hello', [
            'isCaps' => $this->stash()->get('is_caps', false),
        ]);
        $message = $this->view()->render('test.message', [
            'element' => 'Test',
            'attr' => 'text',
            'value' => $text,
        ]);
        $this->alert()->success($message);
    }

    public function sayHello(bool $isCaps)
    {
        $this->stash()->set('is_caps', $isCaps);
        $this->render();

        $this->cl(Buttons::class)->render();
    }

    public function setColor(string $sColor)
    {
        $sColor = $this->example->color($sColor);
        $this->node()->assign('style.color', $sColor);

        $message = $this->view()->render('test.message', [
            'element' => 'Test',
            'attr' => 'color',
            'value' => $sColor,
        ]);
        $this->alert()->success($message);
    }
}
