### Example usage

```
use tonisormisson\jsonform\JsonForm;

$jsonData = '{"username":"admin","password":"password"}';
$varibles = [
    'username'=>[
        'label' => Yii::t('app','Username'),
    ],
    'password'=>[
        'label' => Yii::t('app','Password'),
        'type' => 'password',
    ],
];

<?= JsonForm::widget([
    'json'=>$jsonData,
    'jsonFieldId'=>'credentials',
    'variables' => $model->getOptionVars(),
]); ?>
```
#### Output of example above:
![alt text](images/example-1.png)
