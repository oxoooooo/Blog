<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use skeeks\yii2\ckeditor\CKEditorWidget;
use skeeks\yii2\ckeditor\CKEditorPresets;
use kartik\date\DatePicker;
use app\models\Categories;


/* @var $this yii\web\View */
/* @var $model app\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'text')->widget(CKEditorWidget::className(), [
	'options' => ['rows' => 6],
	'preset' => CKEditorPresets::FULL
]) ?>

    <?= $form->field($model, 'keywords')->textInput() ?>

    <?= $form->field($model, 'description')->textInput() ?>

	<?php
	

//$date_added =  date('Y-m-d H:i:s'); ?>
	
    <?= $form->field($model, 'created_date')->textInput([ 'value'=>$date_added ]) ?>
	
<?php /*	echo '<label>Check Issue Date</label>';
echo DatePicker::widget([
	'name' => 'check_issue_date', 
	'value' => date('d-M-Y', strtotime('+2 days')),
	'options' => ['placeholder' => 'Select issue date ...'],
	'pluginOptions' => [
		'format' => 'dd-M-yyyy',
		'todayHighlight' => true
	]
]); */?>

		<?php // выпадающий список города
						$categories = Categories::find()->all();
						$cat = ArrayHelper::map($categories,'id','title');
						$params = ['prompt' => 'select category'
						]; ?>
    <?= $form->field($model, 'category')->textInput()->dropDownList($cat,$params)->label('select category') ?>

    <?= $form->field($model, 'alias')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
