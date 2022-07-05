<?php
namespace app\modules\v1;

use Yii;
use yii\base\BootstrapInterface;

/**
 * @package app\modules\v1
 */
class Bootstrap implements BootstrapInterface
{
    /**
	 * @inheritdoc
	 */
    public function bootstrap($app) {

		/** @var Module $module */
		if ($app->hasModule('v1') && ($module = $app->getModule('v1')) instanceof Module) {
			Yii::setAlias('@app/modules/v1', __DIR__);

			if ($app->has('i18n')) {
				$app->i18n->translations['v1*'] = [
					'class' => 'yii\i18n\PhpMessageSource',
					'sourceLanguage' => 'en',
					'basePath' => '@app/modules/v1/messages',
				];
			}
		}
    }
}
