<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
	<?= $form->field($model, 'username') ?>
	<?= $form->field($model, 'password')->passwordInput() ?>
	<?= $form->field($model, 'verifycode')->widget(Captcha::className(), [
					'captchaAction'=>'denglu/captcha',
                    'template' => '<div class="row"><div class="col-lg-5">{input}</div>
                    <div class="col-lg-4">{image}</div></div>',
					'imageOptions' => ['alt' => '验证码','title'=>'换一个'],
                ]) ?>
	<?= $form->field($model, 'rememberMe', [
			'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?>
   
<div class="form-group">
	<div class="col-lg-offset-1 col-lg-11">
		<?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
	</div>
</div>
<?php ActiveForm::end(); ?>