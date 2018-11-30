### Example usage

```
<?php 
use tonisormisson\jsonform\JsonForm;

$jsonData = '{"username":"admin","password":"password"}';
$variables = [
    'username'=>[
        'label' => Yii::t('app','Username'),
    ],
    'password'=>[
        'label' => Yii::t('app','Password'),
        'type' => JsonForm::TYPE_PASSWORD,
    ],
];

echo JsonForm::widget([
    'id' => 'my-id',
    'json' => $jsonData,
    'jsonFieldId' => 'my-credentials-input-field',
    'variables' => $variables,
    'labels' => false,
]);

// the filed where the changed json will be stored
// hide this !!
echo Html::textarea('my-credentials-input-field','', ['id' => 'my-credentials-input-field']);

```
#### Output of example above:
![alt text](images/example-1.png)


### Non keyed version
```
<?php 
use tonisormisson\jsonform\JsonForm;

$jsonData = '["foo", "bar", "bazinga"]';

echo JsonForm::widget([
    'id' => 'my-id',
    'json' => $jsonData,
    'jsonFieldId' => 'my-credentials-input-field',
    'isKeyed' => false,
]);

// the filed where the changed json will be stored
// hide this !!
echo Html::textarea('my-credentials-input-field','', ['id' => 'my-credentials-input-field']);

```
![alt text](images/example-2.png)

