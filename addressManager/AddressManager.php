<?php
Yii::setPathOfAlias('addressManager', dirname(__FILE__));
Yii::import('addressManager.actions.*');

class AddressManager extends CWidget
{
    /**
     * @var string API Google Place url
     */
    protected $apiUrl = 'https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete';

    /**
     * @var mixed the CSS file used for the widget. Defaults to null, meaning
     * using the default CSS file included together with the widget.
     * If false, no CSS file will be used. Otherwise, the specified CSS file
     * will be included when using this widget.
     */
    public $cssFile;

    /**
     * @var string language. Google Places localization
     */
    public $language = 'en';

    /**
     * @var integer the id of User model
     */
    public $model_id;

    public static function actions()
    {
        return array(
            'create' => 'AddressManagerCreateAction',
            'delete' => 'AddressManagerDeleteAction',
            'makeDefault' => 'AddressManagerMakeDefaultAction',
        );
    }

    public function run()
    {
        $this->registerClientScript();

        $addresses = Address::getByModelId($this->model_id);
        $model = new Address();
        $model->model_id = $this->model_id;

        $baseUrl = $this->getController()->createUrl('address.');
        $this->render('addressManager', [
            'addresses' => $addresses,
            'model' => $model,
            'baseUrl' => $baseUrl,
        ]);
    }

    protected function registerClientScript()
    {
        $cs = Yii::app()->getClientScript();

        if ($this->cssFile === null)
            $cs->registerCssFile(
                Yii::app()->assetManager->publish(
                    Yii::getPathOfAlias('addressManager.assets') . '/addressManager.css'
                )
            );
        elseif ($this->cssFile !== false)
            $cs->registerCssFile($this->cssFile);

        $cs->registerCssFile('https://fonts.googleapis.com/css?family=Roboto:300,400,500');

        if (isset(Yii::app()->params['GooglePlaceApiKey'])) {
            Yii::app()->clientScript->registerScriptFile(
                Yii::app()->assetManager->publish(
                    Yii::getPathOfAlias('addressManager.assets') . '/addressManager.js'
                ),
                CClientScript::POS_END
            );

            $this->apiUrl .= '&language=' . $this->language;
            $this->apiUrl .= '&key=' . Yii::app()->params['GooglePlaceApiKey'];
            $cs->registerScriptFile($this->apiUrl, CClientScript::POS_END);
        } else {
            $cs->registerScript('addressManagerError', 'console.log("Set GooglePlaceApiKey!");');
        }
    }
}