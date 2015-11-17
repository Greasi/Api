<?php
namespace app\controllers;

use Yii;
use PHPmailer;
use yii\web\Controller;
use yii\web\Session;
use app\models\Username;
use app\models\DengluForm;

header('content-type:text/html;charset=utf8');
class DengluController extends Controller
{
	
	public function actions()
	{
		return [
				'captcha' => [
						'class' => 'yii\captcha\CaptchaAction',
						'maxLength' => 5,
						'minLength' => 5,
				],
		];
	}
	
	public function actionIndex()
	{
		$model = new DengluForm();
		if($model->load(Yii::$app->request->post()) && $model->validate())
		{
			$data=$_POST['DengluForm'];
			//print_r($data);die;
			$arr = Username::find()->where(['username' => $data['username']])->one();
			if($arr) {
				if($data['password'] == $arr['password']) {
					$session = Yii::$app->session;
					$session['user'] = [
					    'id' => $arr['id'],
					    'username' => $arr['username'],
					];
					return $this->render('index');
				}
				else {
					$aa['error']=1;
					$aa['type']="<font color='red'>密码错误</font> 登录";
					return $this->render('success',array('data'=>$aa));
				}
			}
			else {
				$aa['error']=1;
				$aa['type']="<font color='red'>没有此用户</font> 登录";
				return $this->render('success',array('data'=>$aa));
			}
		}
		else 
		{	
			return $this->render('login', ['model' => $model]);		
		}
	}
	
	
	public function actionSendemail()
	{
		$mail = new PHPMailer();
		//var_dump($mail);die;
		$mail->IsSMTP(); // 启用SMTP
		$mail->Host = "smtp.163.com"; //SMTP服务器 这里以163邮箱为例子
		$mail->Port = 25;  //邮件发送端口
		$mail->SMTPAuth   = true;  //启用SMTP认证
		$mail->CharSet  = "UTF-8"; //字符集
		$mail->Encoding = "base64"; //编码方式
		$mail->Username = "18911633614@163.com";  //你的邮箱
		$mail->Password = "hqtlaaojzyokxqip";  //你的密码
		$mail->Subject = "yii测试邮箱是否发送成功"; //邮件标题
		$mail->From = "18911633614@163.com";  //发件人地址（也就是你的邮箱）
		$mail->FromName = "发件人测试姓名";  //发件人姓名
		//$address = "1411902221@qq.com";//收件人email
		$mail->AddAddress("1411902221@qq.com", "某某人");//添加收件人地址，昵称
		//  $mail->AddAttachment("test,zip","重命名附件.zip"); // 添加附件,并重命名
		$mail->IsHTML(true); //支持html格式内容
		$mail->Body = "houruidong love lx"; //邮件内容
		//发送
		if(!$mail->Send()) {
			echo "fail: " . $mail->ErrorInfo;
		} else {
			echo "ok";
		}
	}
	
	public function actionSendmessage()
	{
		if(Yii::$app->smser->send('18911633614','李雪女士,候瑞冬先生让我转告你他很爱你!'))
		{
			echo "ok";
		}
		else
		{
			echo 'fail';
		}
	}
}