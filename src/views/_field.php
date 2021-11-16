<?php

use yii\web\View;
use tonisormisson\jsonform\JsonForm;
use yii\helpers\Html;
use kartik\password\PasswordInput;
use kartik\date\DatePicker;
use \kartik\datetime\DateTimePicker;

/* @var JsonForm $widget */
/* @var View $this */
/* @var string $id */
/* @var string $type */
/* @var string $value */
/* @var string $label */
/* @var array $options */

$buttonsWidth = 12 - $widget->contentWidth;
?>

<div class="form-group row json-form-row <?=($widget->isHorizontal ? "form-horizontal" : null)?> container">
    <?php if ($widget->labels && $widget->isHorizontal): ?>
        <label class="control-label col-sm-<?=$widget->labelsWidth?>" for="<?= Html::encode($id) ?>"><?= Html::encode($label) ?></label>
    <?php endif; ?>

    <div id="json-form-<?=$id?>" class="col-sm-<?=$widget->contentWidth?>">
        <?php if ($widget->labels && !$widget->isHorizontal): ?>
            <label class="control-label" for="<?= Html::encode($id) ?>"><?= Html::encode($label) ?></label>
        <?php endif; ?>

        <?php if ($type == JsonForm::TYPE_PASSWORD): ?>
            <?= PasswordInput::widget([
                'id' => $id,
                'name' => $id,
                'value' => $value,
                'options' => $options,
            ]); ?>
        <?php elseif ($type == JsonForm::TYPE_DATE): ?>
            <?= DatePicker::widget([
                'id' => $id,
                'name' => $id,
                'value' => $value,
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'pluginOptions' => $options,
            ]); ?>
        <?php elseif ($type == JsonForm::TYPE_DATETIME): ?>
            <?= DateTimePicker::widget([
                'id' => $id,
                'name' => $id,
                'value' => $value,
                'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                'pluginOptions' => $options,
            ]); ?>
        <?php else: ?>
            <?= Html::input('text', Html::encode($id), Html::encode($value), $options) ?>
        <?php endif; ?>
    </div>

    <?php if (!$widget->isKeyed): ?>
        <div class="col-sm-<?=$buttonsWidth?>">
            <span class="btn btn-primary <?= $widget->id; ?>-add">add</span>
            <span class="btn btn-primary <?= $widget->id; ?>-remove_field">remove</span>
        </div>
    <?php endif; ?>

    <?php if ($widget->hasExtraContent): ?>
        <div id="<?="jsonform-extra-conttent-{$widget->id}-$id"?>" class="col-sm-<?= $widget->getHasExtraContentWidth(); ?>">
            <?php if(is_string($widget->extraContent)):?>
                <?= $widget->encodeExtraContent ? Html::encode($widget->extraContent) : $widget->extraContent; ?>
            <?php endif; ?>
            <?php if($widget->extraContent instanceof Closure):?>
                <?= call_user_func($widget->extraContent, $value, $type) ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div>

