<?php

class AddressManagerBaseAction extends CAction
{
    /**
     * Performs the AJAX validation.
     * @param Address $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'address-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Return address list
     * @param $modelId
     */
    protected function reloadAddresses($modelId)
    {
        $baseUrl = $this->getController()->createUrl('address.');
        $addresses = Address::getByModelId($modelId);
        Yii::app()->controller->renderPartial('addressManager.views._items', array(
            'addresses' => $addresses,
            'baseUrl' => $baseUrl,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Address the loaded model
     * @throws CHttpException
     */
    protected function loadModel($id)
    {
        $model = Address::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}