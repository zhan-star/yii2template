<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\Schedule;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;

class ScheduleController extends BaseController
{

    public function actionDelete($id)
    {
        $schedule = $this->findModel($id)->delete();
        if ($schedule==1){
            return "message: Deleted schedule №$id";
        }
        else{
            return "Error.";
        }
    }
    public function actionIndex()
    {
        $filter1 = $_GET['gruppa_id'];
        $filter2 = $_GET['user_id'];
        if ($filter1!=""&&$filter1!=null&&$filter2!=""&&$filter2!=null){
            return new ActiveDataProvider(['query' => LessonPlan::find()->where(['gruppa_id' => $filter1,'user_id' => $filter2])]);
        }
        else{
            return new ActiveDataProvider(['query' => Schedule::find()]);
        }
        
    }


    public function actionCreate()
    {
        $schedule = new Schedule();
        return $this->saveModel($schedule);
    }

    public function actionUpdate($id)
    {
        $schedule = $this->findModel($id);
        return $this->saveModel($schedule);
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    public function saveModel($schedule)
    {
        if ($schedule->loadAndSave(Yii::$app->getRequest()->getBodyParams())) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $response->getHeaders()->set('Location',
            Url::toRoute(['view', 'id' => $schedule->getPrimaryKey()], true));
        } 
        elseif (!$schedule->hasErrors()) {
            throw new
            ServerErrorHttpException(serialize($schedule->getErrors()));
        }  
        return $schedule;
    }
    public function findModel($id)
    {
        $schedule = Schedule::findOne($id);
        if ($schedule === null) {
            throw new NotFoundHttpException("Schedule with ID $id not found");
        }
        return $schedule;
    }
    
}
