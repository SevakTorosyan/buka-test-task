<?php

namespace app\actions;

use app\models\Catalog;
use Exception;
use Yii;
use yii\base\Action;

/**
 * Class UpdateCatalogAction
 * @package app\actions
 */
class UpdateCatalogAction extends Action
{
    /**
     * @param $id
     * @return array
     */
    public function run($id): array
    {
        try {
            $requestData = Yii::$app->request->post();
            /** @var Catalog $catalog */
            $catalog = Catalog::find()
                ->where(['id' => $id])
                ->one();

            if (!$catalog) {
                throw new Exception('Catalog not found', 404);
            }

            // корневую папку менять нельзя
            if ($catalog->getDepth() === 0) {
                throw new Exception('Root catalog can\'t be updated', 400);
            }

            if (isset($requestData['title'])) {
                $catalog->setTitle($requestData['title']);
            }

            if (isset($requestData['parent_id']) && is_numeric($requestData['parent_id'])) {
                // нельзя быть родителем самому себе и менять родителя на того же
                if (
                    (int)$requestData['parent_id'] === $catalog->getParentId()
                    || (int)$requestData['parent_id'] === $catalog->getId()
                ) {
                    throw new Exception('This catalog can\'t be parent', 400);
                }

                $childrenIds = $this->getChildrenIds($catalog);
                if (in_array((int)$requestData['parent_id'], $childrenIds, true)) {
                    throw new Exception('Children can\'t become parent to its parent', 400);
                }

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
            }

            if (empty($catalog->getDirtyAttributes())) {
                throw new Exception('Nothing to update', 400);
            }

            $catalog->save();
            return ['message' => 'Catalog successfully updated'];
        } catch (Exception $exception) {
            Yii::$app->response->statusCode = $exception->getCode();
            return ['error' => $exception->getMessage()];
        }
    }

    /**
     * Получаем id всех детей каталога, чтобы проверить, что пользователь не пытается сделать родителя ребенком :)
     *
     * @param Catalog $catalog
     * @return array
     */
    private function getChildrenIds(Catalog $catalog): array
    {
        $childrenIds = [];
        if ($childrenCatalogs = $catalog->getCatalogs()->all()) {
            /** @var Catalog $childrenCatalog */
            foreach ($childrenCatalogs as $childrenCatalog) {
                $childrenIds[] = $childrenCatalog->getId();
                $childrenIds = array_merge($childrenIds, $this->getChildrenIds($childrenCatalog));
            }
        }

        return array_unique($childrenIds);
    }
}
