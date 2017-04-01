<?php
use yii\helpers\Html;
use yii\web\View;
use kartik\password\PasswordInput;

/* @var $widget \andmemasin\jsonform\JsonForm */

$currentData = \yii\helpers\Json::decode($widget->json);
$ids = json_encode(array_keys($widget->variables));

$this->registerJs(<<<JS
 
 var jsonFieldId = '$widget->jsonFieldId';
 var optionsArray = $ids;
 var id = '$widget->id';
 
 function setOptionsValues() {
    var results = {};
    for (i = 0; i < optionsArray.length; i++) {
        var optionId = optionsArray[i];
        var optIonValue = $("#"+optionId).val();
        results[optionId] = optIonValue;
        $("#"+jsonFieldId).val(JSON.stringify(results));
        console.log('setting:'+optionId+'='+optIonValue);
    }   
 }
 $("#"+id+' input').change(function() {
     setOptionsValues();
 });
JS
    , View::POS_READY);


?>
<div id="<?=$widget->id;?>">
<?php if(!empty($widget->variables)):?>
    <?php foreach ($widget->variables as  $id=> $variable):?>
        <div class="form-group field-survey-name required">
            <?php

                if(isset($variable['label'])){
                    $label = $variable['label'];
                }else{
                    $label = $id;
                }
                $options['id'] = $id;
                $options['class'] = 'form-control';
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
            ?>
            <label class="control-label" for="<?=Html::encode($id)?>"><?=Html::encode($label)?></label>
            <?php if($type == 'password'):?>
            <?=PasswordInput::widget([
                'id' => $id,
                'name' => $id,
                'value'=>$value,
            ]);?>
            <?php else:?>
                <?= Html::input('text',Html::encode($id),Html::encode($value),$options)?>
            <?php endif;?>

        </div>

    <?php endforeach;?>
<?php endif;?>

</div>