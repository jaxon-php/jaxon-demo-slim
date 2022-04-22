<?php

namespace Jaxon\Demo\Ajax;

use Jaxon\App\CallableClass as JaxonClass;

class Pgw extends JaxonClass
{
    public function sayHello($isCaps)
    {
        $text = $this->view()->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div1', 'innerHTML', $text);

        $message = $this->view()->render('test/message', [
            'element' => 'div1',
            'attr' => 'text',
            'value' => $text,
        ]);
        $this->response->dialog->success($message);

        return $this->response;
    }

    public function setColor($sColor)
    {
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
