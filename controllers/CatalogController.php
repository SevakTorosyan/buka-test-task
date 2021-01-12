<?php

namespace app\controllers;

use app\actions\CreateCatalogAction;
use app\actions\DeleteCatalogAction;
use app\actions\GetCatalogsAction;
use app\actions\UpdateCatalogAction;
use app\models\Catalog;
use yii\rest\Controller;

/**
 * Class CatalogController
 * @package app\controllers
 */
class CatalogController extends Controller
{
    /** @var string */
    public $modelClass = Catalog::class;

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'create' => [
                'class' => CreateCatalogAction::class,
            ],
            'index' => [
                'class' => GetCatalogsAction::class,
            ],
            'delete' => [
                'class' => DeleteCatalogAction::class,
                'id' => 'id',
            ],
            'update' => [
                'class' => UpdateCatalogAction::class,
                'id' => 'id',
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
