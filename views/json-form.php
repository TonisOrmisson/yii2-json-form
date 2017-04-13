<?php
use yii\helpers\Html;
use yii\web\View;
use kartik\password\PasswordInput;

/* @var $widget \andmemasin\jsonform\JsonForm */

$currentData = \yii\helpers\Json::decode($widget->json);
$ids = json_encode(array_keys($widget->variables));
$isKeyed = json_encode($widget->isKeyed);
$fieldName = array_keys($widget->variables)[0];
$fName = \yii\helpers\Inflector::id2camel($widget->id);

$this->registerJs(<<<JS

    function init$fName(jsonFieldId) {
        var optionsArray = $ids;
        var id = '$widget->id';

        var variableKey ='$fieldName'; 
        var valueName = '$widget->fieldName';
        
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $('#$widget->id .container');
        
        var x = 0; //initial text box count
      
        $(wrapper).on("click",".$widget->id-add", function(e){
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                var clone = $(this).closest('.row').clone();
                clone.find('input').val('');
                clone.appendTo(wrapper);
            }
        });
    
        $(wrapper).on("click",".$widget->id-remove_field", function(){
            $(this).closest('.row').remove();
            x--;
            setOptionsValues('$widget->id',jsonFieldId);
        });
        
        $(wrapper).on("change",".values", function(e){
            setOptionsValues('$widget->id',jsonFieldId);
        });
        
     

    }
    
    function setOptionsValues(id,jsonFieldId) {
        var results = {};
        var isKeyed = $isKeyed;
        if(isKeyed){
            for (i = 0; i < optionsArray.length; i++) {
                var optionId = optionsArray[i];
                var optIonValue = $("#"+optionId).val();
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
<div id="<?=$widget->id;?>">
<?php if(!empty($widget->variables)):?>
    <div class="container">
    <?php foreach ($widget->values as  $id=> $variable):?>
        <div class="row json-form-row">

            <?php

                if(isset($variable['label'])){
                    $label = $variable['label'];
                }else{
                    $label = $id;
                }
                if(!$widget->isKeyed){
                    $label = array_values($widget->variables)[0]['label'].' '.(intval($id)+1);
                }

                $options['id'] = $id;
                //$options['name'] = $widget->fieldName;

                if(isset($variable['options'])){
                    $options = array_merge($options,$variable['options']);
                }

                if(isset($currentData[$id])){
                    $value = $currentData[$id];
                }else{
                    $value = null;
                }
                if(isset($variable['type'])){
                    $type = $variable['type'];
                }else{
                    $type = null;
                }
                if(!$widget->isKeyed){
                    $id = $id."[0]";
                }
                $options['class'] = "form-control values";
            ?>
            <div class="form-group field-survey-name required col-md-4">
            <?php if($widget->labels):?>
                <label class="control-label" for="<?=Html::encode($id)?>"><?=Html::encode($label)?></label>
            <?php endif;?>
        <?php if($type == 'password'):?>
            <?=PasswordInput::widget([
                'id' => $id,
                'name' => $id,
                'value'=>$value,
            ]);?>
            <?php else:?>
                <?= \yii\bootstrap\Html::input('text',Html::encode($id),Html::encode($value),$options)?>
            <?php endif;?>
            </div>
            <div class="col-md-4">
                <?php if(!$widget->isKeyed):?>
                    <span class="btn btn-primary <?=$widget->id;?>-add" >add</span>
                    <span class="btn btn-primary <?=$widget->id;?>-remove_field" >remove</span>
                <?php endif;?>
            </div>

        </div>

    <?php endforeach;?>
    </div>
<?php endif;?>

</div>