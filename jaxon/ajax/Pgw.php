<?php

namespace Jaxon\Demo\Ajax;

use Jaxon\App\CallableClass as JaxonClass;
use Jaxon\Demo\Service\ExampleInterface;

class Pgw extends JaxonClass
{
    /**
     * @di('attr' => 'example', 'class' => 'App\Service\ExampleInterface')
     */
    public function sayHello($isCaps)
    {
        $text = $this->example->message($isCaps);
        $this->response->assign('div1', 'innerHTML', $text);

        $message = $this->view()->render('test/message', [
            'element' => 'div1',
            'attr' => 'text',
            'value' => $text,
        ]);
        $this->response->dialog->success($message);

        return $this->response;
    }

    /**
     * @di('attr' => 'example', 'class' => 'App\Service\ExampleInterface')
     */
    public function setColor($sColor)
    {
        $sColor = $this->example->color($sColor);
        $this->response->assign('div1', 'style.color', $sColor);

        $message = $this->view()->render('test/message', [
            'element' => 'div1',
            'attr' => 'color',
            'value' => $sColor,
        ]);
        $this->response->dialog->success($message);

        return $this->response;
    }

    public function showDialog()
    {
        $buttons = [['title' => 'Close', 'class' => 'btn', 'click' => 'close']];
        $this->response->dialog->with('pgwjs')
            ->show("Modal Dialog", "This modal dialog is powered by PgwModal!!", $buttons, ['maxWidth' => 400]);

        return $this->response;
    }
}
