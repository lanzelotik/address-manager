<div class="address-manager-module">

    <div id="addresses-list">
        <?= $this->render('_items', array(
            'addresses' => $addresses,
            'baseUrl' => $baseUrl,
        )); ?>
    </div>

    <h4>Add new:</h4>

    <div class="form">
        <div id="locationField">
            <input id="autocomplete" placeholder="Enter address" onFocus="geolocate()" type="text"/>
        </div>

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'address-form',
            'enableAjaxValidation' => true,
            'action' => CHtml::normalizeUrl(array($baseUrl . 'create')),
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'validateOnChange' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError){
                        $.ajax({
                            "type":"POST",
                            "url":"' . CHtml::normalizeUrl(array($baseUrl . 'create')) . '",
                            "data":form.serialize(),
                            "success":function(data){$("#addresses-list").html(data); resetForm();},
                            });
                        }
                    }'
            ),
        )); ?>

        <?= $form->hiddenField($model, 'model_id'); ?>

        <table class="address">
            <tr>
                <td class="label">Street address</td>
                <td class="slimField">
                    <div class="row">
                        <?= $form->textField($model, 'street_number', array('disabled' => true)); ?>
                        <?= $form->error($model, 'street_number'); ?>
                    </div>
                </td>
                <td class="wideField" colspan="2">
                    <div class="row">
                        <?= $form->textField($model, 'route', array('disabled' => true)); ?>
                        <?= $form->error($model, 'route'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label">City</td>
                <td class="wideField" colspan="3">
                    <div class="row">
                        <?= $form->textField($model, 'city', array('disabled' => true)); ?>
                        <?= $form->error($model, 'city'); ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label">State</td>
                <td class="slimField">
                    <div class="row">
                        <?= $form->textField($model, 'state', array('disabled' => true)); ?>
                        <?= $form->error($model, 'state'); ?>
                    </div>
                </td>
                <td class="label">Zip code</td>
                <td class="wideField">
                    <div class="row">
                        <?= $form->textField($model, 'zip', array('disabled' => true)); ?>
                        <?= $form->error($model, 'zip'); ?>
                    </div>
                </td>
            </tr>
        </table>

        <div class="row buttons">
            <?= CHtml::submitButton('Add'); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>