<?php

namespace app\actions;

use app\models\Catalog;
use Exception;
use Yii;
use yii\base\Action;

/**
 * Class DeleteCatalogAction
 * @package app\controllers
 */
class DeleteCatalogAction extends Action
{
    /**
     * @param $id
     * @return array
     * @throws \Throwable
     */
    public function run($id): array
    {
        try {
            /** @var Catalog $catalog */
            $catalog = Catalog::find()
                ->where(['id' => $id])
                ->one();

            if (!$catalog) {
                throw new Exception('Catalog not found', 404);
            }

            // нельзя удалять корневой каталог
            if ($catalog->getDepth() === 0) {
                throw new Exception('Cannot delete the root folder!', 400);
            }
            $catalog->delete();

            return ['message' => 'Catalog has been successfully deleted'];
        } catch (Exception $exception) {
            Yii::$app->response->statusCode = $exception->getCode();
            return ['error' => $exception->getMessage()];
        }
    }
}
