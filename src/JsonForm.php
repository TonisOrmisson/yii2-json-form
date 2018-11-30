<?php
namespace tonisormisson\jsonform;

use yii;
use yii\base\Widget;

/**
 * Class JsonForm
 * @property boolean $isHorizontal
 *
 * @package tonisormisson\jsonform
 * @author Tõnis Ormisson <tonis@andmemasin.eu>
 */
class JsonForm extends Widget
{
    public $json;
    public $jsonFieldId;
    public $id = 'form-json-fields';
    /** @var string $fieldName if no value names are specified we'll use this as default */
    public $fieldName = 'jsonForm-values';
    /** @var  boolean $isKeyed Whether the input fields are keyed or not. If not keyed, we can use dynamic adding */
    public $isKeyed = true;

    /** @var array|string input variables  */
    public $variables = [];

    /** @var array input values  */
    public $values = [];

    /** @var  boolean $labels whether we show labels or not*/
    public $labels = true;

    /** @var  boolean $labels whether we show labels or not*/
    public $layout;


    const TYPE_PASSWORD = 'password';

    const TYPE_DATE = 'date';
    const TYPE_DATETIME = 'datetime';

    const LAYOUT_HORIZONTAL = 'horizontal';



    public function run()
    {
        if (!$this->isKeyed && !empty($this->json)) {
            $this->variables = yii\helpers\Json::decode($this->json);
        }
        if (!$this->isKeyed) {
            $this->labels = false;
        }

        $this->values = $this->variables;
        //if single string, then use name as key as well as label
        if(!is_array($this->variables)){
            $this->isKeyed = false;
            $this->variables = [$this->variables=>[
                'label'=>$this->variables,
            ]];
            $values = yii\helpers\Json::decode($this->json);
            if($values) {
                $this->values = $values;
            }
        }
        return $this->render('json-form', [
            'widget' => $this
        ]);
    }

    /**
     * @return bool
     */
    public function getIsHorizontal()
    {
        return $this->layout === self::LAYOUT_HORIZONTAL;
    }
}