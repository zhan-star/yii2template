<?php

namespace app\controllers;

use yii\data\ActiveDataProvider;
use app\models\LessonPlan;
use app\models\Schedule;
use Yii;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;
use yii\web\NotFoundHttpException;

class LessonPlanController extends BaseController
{
    public function actionDelete($id)
    {
        if (!Schedule::find()->where(['lesson_plan_id' => $id])->exists()){
            $lessonplan = $this->findModel($id)->delete();
            if ($lessonplan==1){
                return "message: Deleted lesson plan №$id";
            }
        }
        else{
            return "message: Schedule exists, cannot delete.";
        }
    }

    public function actionIndex()
    {
        $filter1 = $_GET['gruppa'];
        $filter2 = $_GET['user'];
        if ($filter1!=""&&$filter1!=null&&$filter2!=""&&$filter2!=null){
            return new ActiveDataProvider(['query' => LessonPlan::find()->where(['gruppa_id' => $filter1,'user_id' => $filter2])]);
        }
        else{
            return new ActiveDataProvider(['query' => LessonPlan::find()]);
        }
    }

    public function actionCreate()
    {
        $lessonplan = new LessonPlan();
        return $this->saveModel($lessonplan);
    }

    public function actionUpdate($id)
    {
        $lessonplan = $this->findModel($id);
        return $this->saveModel($lessonplan);
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    /*public function actionDelete($id)
    {
        if(Yii::app()->request->isDeleteRequest)
        {
            $lessonplan = $this->findModel($id);
            $lessonplan->mrsktd = new CDbExpression('NOW()');
            $lessonplan->save();
        }
        else throw new CHttpException(406,'Not acceptable.');
    }*/

   

    public function saveModel($lessonplan)
    {
        if ($lessonplan->loadAndSave(Yii::$app->getRequest()->getBodyParams())) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $response->getHeaders()->set('Location',
            Url::toRoute(['view', 'id' => $lessonplan->getPrimaryKey()], true));
        } 
        elseif (!$lessonplan->hasErrors()) {
            throw new
            ServerErrorHttpException(serialize($lessonplan->getErrors()));
        }  
        return $lessonplan;
    }
    public function findModel($id)
    {
        $lessonplan = LessonPlan::findOne($id);
        if ($lessonplan === null) {
            throw new NotFoundHttpException("Lesson Plan with ID $id not found");
        }
        return $lessonplan;
    }
    
}
