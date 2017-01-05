<?php
namespace andmemasin\jsonform;

use yii;
use yii\base\Widget;
/**
 * Created by PhpStorm.
 */
class JsonForm extends Widget
{
    public $json;
    public $jsonFieldId;
    public $id = 'form-json-fields';

    public $variables = [];

    public function run()
    {
        return $this->render('json-form', [
            'widget' => $this
        ]);
    }
}