<?php
/**
 * Created by PhpStorm.
 * User: dmytrodmytruk
 * Date: 15.06.17
 * Time: 16:46
 */

namespace ddmytruk\mailer;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Mailer
 */

class Mailer extends Component
{
    /** @var string */
    public $viewPath = '';

    /** @var string|array */
    public $sender;

    /**
     * @param string $to
     * @param string $subject
     * @param string $view
     * @param array  $params
     *
     * @return bool
     */
    protected function sendMessage($to, $subject, $view, $params = [])
    {
        /** @var \yii\mail\BaseMailer $mailer */
        $mailer = Yii::$app->mailer;
        $mailer->viewPath = $this->viewPath;
        $mailer->getView()->theme = Yii::$app->view->theme;

        if ($this->sender === null) {
            if(isset(Yii::$app->params['adminEmail'])) {
                $this->sender = Yii::$app->params['adminEmail'];
            }
            else
                throw new InvalidConfigException();
        }

        return $mailer->compose(['html' => $view, 'text' => 'text/' . $view], $params)
            ->setTo($to)
            ->setFrom($this->sender)
            ->setSubject($subject)
            ->send();
    }
}