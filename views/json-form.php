<?php
use yii\helpers\Html;
use yii\web\View;

/* @var $widget \andmemasin\jsonform\JsonForm */

$currentData = \yii\helpers\Json::decode($widget->json);
$ids = json_encode(array_keys($widget->variables));

$this->registerJs(<<<JS
 
 var jsonFieldId = '$widget->jsonFieldId';
 var optionsArray = $ids;
 var id = '$widget->id';
 
 var optionId = 'sid';

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
    <?php foreach ($widget->variables as $id=> $variable):?>
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
            ?>
            <label class="control-label" for="<?=$id?>"><?=$label?></label>
            <?= Html::input('text',$id,$value,$options)?>
        </div>

    <?php endforeach;?>
<?php endif;?>

</div>
