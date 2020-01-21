<?php

namespace common\actions;
use Yii;
use yii\rest\Action;
use yii\web\ServerErrorHttpException;

class DeleteAction extends Action
{
    /**
     * Deletes a model.
     * @param mixed $id id of the model to be deleted.
     * @throws ServerErrorHttpException on failure.
     */
    public function run($id)
    {
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }
        if(in_array('status', $this->modelClass::attributes())) {
            if ($this->modelClass::SOFT_DELETE === 0) {
                if ($model->delete() === false) {
                    throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
                }
            }
            else {
                $model->status = 0;
                if ($model->save() === false) {
                    throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
                }
            }
        }
        else {
            if ($model->delete() === false) {
                throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
            }
        }

        Yii::$app->getResponse()->setStatusCode(204);
    }
}