<?php
namespace tonisormisson\jsonform;

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
    /** @var string $fieldName if no value names are specified we'll use this as default */
    public $fieldName = 'jsonForm-values';
    /** @var  boolean $isKeyed Whether the input fields are keyed or not. If not keyed, we can use dynamic adding */
    public $isKeyed;

    /** @var array|string input variables  */
    public $variables = [];

    /** @var array input values  */
    public $values = [];

    /** @var  boolean $labels whether we show labels or not*/
    public $labels = true;

    const TYPE_PASSWORD = 'password';




    public function run()
    {
        //if single string, then use name as key as well as label
        if(!is_array($this->variables)){
            $this->isKeyed = false;
            $this->variables = [$this->variables=>[
                'label'=>$this->variables,
            ]];
            $values = yii\helpers\Json::decode($this->json);
            if($values){
                $this->values = $values;
            }else{
                $this->values = $this->variables;
            }
        }else {
            $this->isKeyed = true;
            $this->values = $this->variables;
        }
        return $this->render('json-form', [
            'widget' => $this
        ]);
    }
}