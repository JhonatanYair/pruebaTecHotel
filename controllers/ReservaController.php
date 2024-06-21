<?php

namespace app\controllers;

use Yii;
use app\models\Reserva;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReservaController implements the CRUD actions for Reserva model.
 */
class ReservaController extends Controller
{

    public function actionGetReservas($apartamento_id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        // Obtener la fecha actual en formato Y-m-d
        $fechaActual = date('Y-m-d');
    
        // Consulta para obtener las reservas del apartamento a partir de la fecha actual
        $reservas = Reserva::find()
            ->where(['apartamento_id' => $apartamento_id])
            ->andWhere(['>=', 'fecha_inicio', $fechaActual])
            ->all();
    
        // Preparar el array de resultados
        $result = [];
        foreach ($reservas as $reserva) {
            $result[] = [
                'fecha_inicio' => $reserva->fecha_inicio,
                'fecha_fin' => $reserva->fecha_fin,
            ];
        }
    
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Reserva models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Reserva::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reserva model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Reserva model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Reserva();

        if ($model->load($this->request->post())) {
            // Verificar disponibilidad del apartamento
            $reservasExistentes = Reserva::find()
                ->where(['apartamento_id' => $model->apartamento_id])
                ->andWhere(['<', 'fecha_inicio', $model->fecha_fin])
                ->andWhere(['>', 'fecha_fin', $model->fecha_inicio])
                ->all();

            if (count($reservasExistentes) > 0) {
                Yii::$app->session->setFlash('error', 'El apartamento ya está reservado para estas fechas.');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            $model->estado = 1;
            $model->fecha_creacion = date('Y-m-d');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Reserva creada exitosamente.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Reserva model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
    
        if ($model->load(Yii::$app->request->post())) {
            // Verificar disponibilidad del apartamento para las fechas seleccionadas
            $reservasExistentes = Reserva::find()
                ->where(['apartamento_id' => $model->apartamento_id])
                ->andWhere(['<', 'fecha_fin', $model->fecha_inicio])
                ->andWhere(['>', 'fecha_inicio', $model->fecha_fin])
                ->andWhere(['not', ['id' => $model->id]]) // Excluir la reserva actual
                ->all();
    
            if (count($reservasExistentes) > 0) {
                Yii::$app->session->setFlash('error', 'El apartamento ya está reservado para estas fechas.');
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
    
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Reserva actualizada exitosamente.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reserva model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Reserva eliminada exitosamente.');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reserva model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Reserva the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reserva::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
