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
    'jsonFieldId'=>'collector-credentials',
    'variables' => $model->getOptionVars(),
]); ?>
```
#### Example outputs:
![alt text](images/example-1.png)
