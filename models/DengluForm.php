<?php

namespace app\models;

use Yii;
use yii\base\Model;

class DengluForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $verifycode;
    private $_user = false;
    
    public function rules()
    {
    	return [
    			[['username'], 'required','message'=>'用户名不能为空'],
    			[[ 'password'], 'required','message'=>'密码不能为空'],
    			// rememberMe must be a boolean value
    			['rememberMe', 'boolean'],
    			// verifyCode needs to be entered correctly
    			['verifycode', 'required','message'=>'验证码不能为空'],
    			['verifycode', 'captcha','message'=>'验证码不正确'],	 
    	];
    }
}
