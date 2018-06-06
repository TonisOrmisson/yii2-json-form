<?php

use yii\web\View;
use tonisormisson\jsonform\JsonForm;
use yii\helpers\Html;
use kartik\password\PasswordInput;
use kartik\date\DatePicker;

/* @var JsonForm $widget */
/* @var View $this */
/* @var string $id */
/* @var string $type */
/* @var string $value */
/* @var string $label */
/* @var array $options */

?>

<div class="form-group json-form-row <?=($widget->isHorizontal ? "form-horizontal" : null)?> container">
    <?php if ($widget->labels && $widget->isHorizontal): ?>
        <label class="control-label col-sm-3" for="<?= Html::encode($id) ?>"><?= Html::encode($label) ?></label>
    <?php endif; ?>

    <div id="json-form-<?=$id?>" class="col-sm-6">
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
        <?php else: ?>
            <?= Html::input('text', Html::encode($id), Html::encode($value), $options) ?>
        <?php endif; ?>
    </div>

    <?php if (!$widget->isKeyed): ?>
        <div class="col-sm-2">
            <span class="btn btn-primary <?= $widget->id; ?>-add">add</span>
            <span class="btn btn-primary <?= $widget->id; ?>-remove_field">remove</span>
        </div>
    <?php endif; ?>

</div>

