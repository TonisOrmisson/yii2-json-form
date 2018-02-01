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
    'id' => 'my-id'
    'json' => $jsonData,
    'jsonFieldId' => 'my-credentials',
    'variables' => $variables,
    'labels' => false,
]); 

```
#### Output of example above:
![alt text](images/example-1.png)
