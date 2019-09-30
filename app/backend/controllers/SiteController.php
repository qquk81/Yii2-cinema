<?php
namespace backend\controllers;

use cinema\entities\Cinema\Price;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $price = Price::find()
            ->alias('pr')
            ->leftJoin('seances s', 'pr.seance_id = s.id')
            ->leftJoin('sectors sec', 'pr.sector_id = sec.id')
            ->leftJoin('places p', 's.hall_id = p.hall_id')
            ->andWhere('p.id = :place_id', ['place_id' => 4])
            ->andWhere('p.raw >= sec.start_raw')
            ->andWhere('p.raw <= sec.end_raw')
            ->andWhere('s.id = :seance_id', ['seance_id' => 1])
            ->all();
        

        return $this->render('index');
    }

}
