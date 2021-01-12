<?php

namespace app\actions;

use app\models\Catalog;
use Exception;
use Yii;
use yii\base\Action;

/**
 * Class CreateCatalogAction
 * @package app\actions
 */
class CreateCatalogAction extends Action
{
    /**
     * @return array
     */
    public function run(): array
    {
        try {
            $requestData = Yii::$app->request->post();
            $catalog = new Catalog();

            if (!isset($requestData['title'])) {
                throw new Exception('Title is required field', 400);
            }

            if (isset($requestData['parent_id']) && is_numeric($requestData['parent_id'])) {
                /** @var Catalog $catalogParent */
                if (
                    $catalogParent = Catalog::find()
                        ->where(['id' => (int)$requestData['parent_id']])
                        ->one()
                ) {
                    $catalog->setTitle($requestData['title'])
                        ->setParentId($catalogParent->getId());
                } else {
                    throw new Exception('Parent catalog doesn\'t exist', 404);
                }
            } else {
                throw new Exception('Parent ID is required and must be integer', 400);
            }

            $catalog->save();
            return ['message' => 'Catalog succesfully created'];
        } catch (Exception $exception) {
            Yii::$app->response->statusCode = $exception->getCode();
            return ['error' => $exception->getMessage()];
        }
    }
}
