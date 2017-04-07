<?php
use yii\helpers\Html;
use yii\web\View;
use kartik\password\PasswordInput;

/* @var $widget \andmemasin\jsonform\JsonForm */

$currentData = \yii\helpers\Json::decode($widget->json);
$ids = json_encode(array_keys($widget->variables));
$isKeyed = json_encode($widget->isKeyed);
$fieldName = array_keys($widget->variables)[0];
$this->registerJs(<<<JS


 var jsonFieldId = '$widget->jsonFieldId';
 var optionsArray = $ids;
 var id = '$widget->id';
 var variableKey ='$fieldName'; 
 var btnid = '$widget->id-add';
 var valueName = '$widget->fieldName';

    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $("#$widget->id .container");
   
    var x = 0; //initial text box count
    
    $(wrapper).on("click",".$widget->id-add", function(e){
        console.log('add');
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            var clone = $( ".json-form-row" ).last().clone();
            clone.find('input').val('');
            clone.appendTo(wrapper);
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).closest('.row').remove(); x--;
        setOptionsValues();
    });
    
    $(wrapper).on("change",".values", function(e){
         setOptionsValues();
    });
    
 function setOptionsValues() {
    var results = {};
    var isKeyed = $isKeyed;
    if(isKeyed){
        for (i = 0; i < optionsArray.length; i++) {
            var optionId = optionsArray[i];
            var optIonValue = $("#"+optionId).val();
            results[optionId] = optIonValue;
            $("#"+jsonFieldId).val(JSON.stringify(results));
            console.log('isK'+isKeyed.toString());
        }   
    } else{
        results= [];
        $('input.values').each(function(){
            var input = $(this);
            results.push(input.val());
            $("#"+jsonFieldId).val(JSON.stringify(results));
            console.log(input.val());
            
        });
        
    }
 }
 
 $("#"+id+' input').change(function() {
     setOptionsValues();
 });
 
 $("#"+btnid).click(function() {
 });
 
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
            <div class="form-group field-survey-name required col-md-<?= ($widget->isKeyed ? '12':'8')?>">
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
                    <span class="btn btn-primary <?=$widget->id;?>-add" >add</span> <span class="btn btn-primary remove_field" id="<?=$widget->id;?>-remove">remove</span>
                <?php endif;?>
            </div>

        </div>

    <?php endforeach;?>
    </div>
<?php endif;?>

</div>