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

    /** @var int $maxFieldsCount Maximum number fo fields */
    public $maxFieldsCount = 10;

    /** @var int $contentWidth bootstrap col width for row content */
    public $contentWidth = 6;

    /** @var int $labelsWidth bootstrap col width for row labels if horizontal layout*/
    public $labelsWidth = 3;

    public $hasExtraContent = false;

    private $extraContentWidth = 0;

    /** @var string[] */
    public $extraContent = [];

    public $encodeExtraContent = true;


    const TYPE_PASSWORD = 'password';

    const TYPE_DATE = 'date';
    const TYPE_DATETIME = 'datetime';

    const LAYOUT_HORIZONTAL = 'horizontal';

    const NON_KEYED_ID_SUFFIX = "[0]";



    public function run()
    {

        if (!$this->isKeyed && !empty($this->json)) {
            $this->variables = yii\helpers\Json::decode($this->json);
        }
        if (!$this->isKeyed) {
            $this->labels = false;
        }

        if (!$this->isKeyed) {
            $this->contentWidth = 8;
        }

        if ($this->hasExtraContent) {
            $this->extraContentWidth = 8 - $this->contentWidth;
            if ($this->labels) {
                $this->extraContentWidth -= $this->labelsWidth;
            }
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

    public function getHasExtraContentWidth() {
        return $this->extraContentWidth;
    }

    public function nonKeyedId($id) {
        return $id . self::NON_KEYED_ID_SUFFIX;
    }
}