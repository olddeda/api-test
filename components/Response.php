<?php

namespace app\components;

class Response extends \yii\web\Response
{
    /**
     * @inheritdoc
     */
    protected function prepare()
    {
        if (is_object($this->data) || is_array($this->data)) {
            $this->format = self::FORMAT_JSON;
        }
        return parent::prepare();
    }
}