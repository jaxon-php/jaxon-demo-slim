<?php

namespace Jaxon\Demo\Ajax;

use Jaxon\App\CallableClass as JaxonClass;

class Bts extends JaxonClass
{
    public function sayHello($isCaps, $bNotify = true)
    {
        $text = $this->view()->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div2', 'innerHTML', $text);

        $message = $this->view()->render('test/message', [
            'element' => 'div2',
            'attr' => 'text',
            'value' => $text,
        ]);
        $this->response->dialog->success($message);

        return $this->response;
    }

    public function setColor($sColor, $bNotify = true)
    {
        $this->response->assign('div2', 'style.color', $sColor);

        $message = $this->view()->render('test/message', [
            'element' => 'div2',
            'attr' => 'color',
            'value' => $sColor,
        ]);
        $this->response->dialog->success($message);

        return $this->response;
    }

    public function showDialog()
    {
        $buttons = [['title' => 'Close', 'class' => 'btn', 'click' => 'close']];
        $this->response->dialog->show("Modal Dialog", "This modal dialog is powered by Twitter Bootstrap!!",
            $buttons, ['width' => 300]);

        return $this->response;
    }
}
