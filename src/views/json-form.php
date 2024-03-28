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

        let variableKey ='$fieldName'; 
        let valueName = '$widget->fieldName';
        
        let max_fields      = $widget->maxFieldsCount; //maximum input boxes allowed
        let wrapper         = $('#$widget->id');
        
        let x = $('#'+id+' ' + rowClass).length; //initial text box count
        setOptionsValues('$widget->id',jsonFieldId, optionsArray);
      
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
            setOptionsValues('$widget->id',jsonFieldId,optionsArray);
        });
        
        $(wrapper).on("change",".values", function(e){
            setOptionsValues('$widget->id',jsonFieldId,optionsArray);
        });
        
        $(wrapper).on("keyup",".values", function(e){
            setOptionsValues('$widget->id',jsonFieldId,optionsArray);
        });
        
        $('body').on("click", function(e){
            setOptionsValues('$widget->id',jsonFieldId,optionsArray);
        });
     

    }
    
    function setOptionsValues(id,jsonFieldId,optionsArray) {
        let results = {};
        let isKeyed = $isKeyed;
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
                var input = $(this);
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
            $options = $variable['options'] ?? [];


            if(empty($pluginOptions)) {
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
                'options' => $options,
                'select' => $select,
                'pluginOptions' => $pluginOptions,
            ]); ?>

        <?php endforeach; ?>
    <?php endif; ?>

</div>