<?php

namespace app\actions;

use app\models\Catalog;
use yii\base\Action;

/**
 * Class GetCatalogsAction
 * @package app\actions
 */
class GetCatalogsAction extends Action
{
    /**
     * @return array|null
     */
    public function run(): ?array
    {
        $catalogs = Catalog::find()
            ->all();

        $catalogsData = array_map(static function ($catalog) {
            /** @var Catalog $catalog */
            return $catalog->hydrate();
        }, $catalogs);

        return $catalogsData;
    }
}
