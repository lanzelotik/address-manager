<?php

class AddressManagerDeleteAction extends AddressManagerBaseAction
{
    /**
     * Delete a particular model.
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     */
    public function run($id)
    {
        $model = $this->loadModel($id);
        $model->delete();

        $this->reloadAddresses($model->model_id);
    }
}