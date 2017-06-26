<?php

class AddressManagerMakeDefaultAction extends AddressManagerBaseAction
{
    /**
     * Delete an address
     * @param $id integer address model id
     * @throws CHttpException
     */
    public function run($id)
    {
        $model = $this->loadModel($id);

        $criteria = new CDbCriteria();
        $criteria->condition = 'model_id=:modelId';
        $criteria->params = array(
            ':modelId' => $model->model_id
        );

        Address::model()->updateAll(array(
            'default' => Address::IS_NOT_DEFAULT,
        ), $criteria);

        $model->default = Address::IS_DEFAULT;
        $model->save(false);

        $this->reloadAddresses($model->model_id);
    }
}