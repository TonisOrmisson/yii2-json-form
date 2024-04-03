<?php

use tonisormisson\jsonform\JsonForm;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\View;

/** @var JsonForm $widget */
/** @var View $this */

$currentData = Json::decode($widget->json);
$ids = json_encode(array_keys($widget->variables));
$isKeyed = json_encode($widget->isKeyed);
$fieldName = array_keys($widget->variables)[0];
$fName = Inflector::id2camel($widget->id);

$this->registerJs(<<<JS

    function init$fName(jsonFieldId) {

        let optionsArray = $ids;
        let id = '$widget->id';
        let rowClass = '.json-form-row';
        let isKeyed =  $isKeyed;

        
        let max_fields      = $widget->maxFieldsCount; //maximum input boxes allowed
        let wrapper         = $('#$widget->id');
        
        let x = $('#'+id+' ' + rowClass).length; //initial text box count
        setOptionsValues('$widget->id',jsonFieldId, optionsArray, isKeyed);
      
        $(wrapper).on("click",".$widget->id-add", function(e){
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                let clone = $(this).closest(rowClass).clone();
                clone.find('input').val('');
                clone.appendTo(wrapper);
            }
        });
    
        $(wrapper).on("click",".$widget->id-remove_field", function(){
            $(this).closest(rowClass).remove();
            x--;
            setOptionsValues('$widget->id',jsonFieldId,optionsArray,isKeyed);
        });
        
        $(wrapper).on("change",".values", function(e){
            setOptionsValues('$widget->id',jsonFieldId,optionsArray,isKeyed);
        });
        
        $(wrapper).on("keyup",".values", function(e){
            setOptionsValues('$widget->id',jsonFieldId,optionsArray,isKeyed);
        });
        
        $('body').on("click", function(e){
            setOptionsValues('$widget->id',jsonFieldId,optionsArray,isKeyed);
        });
     

    }
    
    function setOptionsValues(id,jsonFieldId,optionsArray, isKeyed) {
        let results = {};
        if(isKeyed){
            for (i = 0; i < optionsArray.length; i++) {
                let optionId = optionsArray[i];
                let optIonValue = $("#"+optionId).val();
                results[optionId] = optIonValue;
                $("#"+jsonFieldId).val(JSON.stringify(results));
                $("#"+jsonFieldId).val(JSON.stringify(results));
            }   
        } else{
            results= [];
            $('#'+id+' .values').each(function(){
                let input = $(this);
                results.push(input.val());
                $("#"+jsonFieldId).val(JSON.stringify(results));
                
            });
            
        }
        $("#"+jsonFieldId).trigger('change');
    }

     init$fName('$widget->jsonFieldId');

JS
    , View::POS_READY);


?>
<div id="<?= $widget->id;?>">
    <?php if (!empty($widget->variables)): ?>
        <?php foreach ($widget->variables as $id => $variable): ?>
            <?php
            $label = (isset($variable['label']) ? $label = $variable['label'] : $id);

            if (!$widget->isKeyed) {
                $label = "";
            }
            $select = $variable['select'] ?? [];

            $pluginOptions = $variable['pluginOptions'] ?? [];

            $inputOptions = [
                'id' => $id,
                'class' =>"form-control values"
            ];
            if(isset($variable['options']) && isset( $variable['options']['class'])) {
                // append, must keep ours
                $variable['options']['class'] = $inputOptions['class']. " ". $variable['options']['class'];
                unset($variable['options']['class']);
            }
            if(!empty($variable['options']) && is_array($variable['options'])) {
                $inputOptions = array_merge($inputOptions, $variable['options']);
            }

            if(empty($inputOptions)) {
                $pluginOptions['id'] = $id;
                // old config
                if (isset($variable['options'])) {
                    $pluginOptions = array_merge($pluginOptions, $variable['options']);
                }
                $pluginOptions['class'] = "form-control values";
            }


            $value = (isset($currentData[$id]) ? $currentData[$id] : null);
            $type = (isset($variable['type']) ? $variable['type'] : null);

            if (!$widget->isKeyed) {
                $id = $widget->nonKeyedId($id);
            }

            ?>

            <?= $this->render('_field', [
                'widget' => $widget,
                'type' => $type,
                'id' => $id,
                'label' => $label,
                'value' => $value,
                'inputOptions' => $inputOptions,
                'select' => $select,
                'pluginOptions' => $pluginOptions,
            ]); ?>

        <?php endforeach; ?>
    <?php endif; ?>

</div>