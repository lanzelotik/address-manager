<?php

class AddressManagerCreateAction extends AddressManagerBaseAction
{
    /**
     * Creates a new model.
     */
    public function run()
    {
        $model = new Address;

        $this->performAjaxValidation($model);

        if (isset($_POST['Address'])) {
            $model->attributes = $_POST['Address'];
            if ($model->save()) {
                $this->reloadAddresses($model->model_id);
            }
        }
    }
}