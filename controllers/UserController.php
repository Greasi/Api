<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\One_member; //用户
use app\models\One_category; //职位/行业/薪资...
use app\models\One_category_district;//地区
use app\models\One_category_major; //专业
use app\models\One_person; //简历
use app\models\One_company; //公司

/**
 * 个人用户简历信息处理控制器
 * Class UserController
 * @package app\controllers
 */

header('content-type:text/html;charset=utf8');
class UserController extends Controller
{
    public function actionIndex()
    {
        echo "@我@的模块";
    }

    //登录
    public function actionLogin()
    {
        $tel = $_GET['tel'];
        $password = $_GET['password'];
        $user = One_member::find()->where(['mem_phone' => $tel])->one();
        //print_r($user);die;
        if($user){
            if($user['mem_password'] == $password){
                $data['status'] = 200;
                $data['desc'] = '登录成功';
                $data['user_info'] = $user->attributes;
            }else{
                $data['status'] = 420;
                $data['desc'] = '密码错误';
            }
        }else{
            $data['status'] = 421;
            $data['desc'] = '没有此用户';
        }
        exit(json_encode($data)); 
    }
    
    //注册
    public function actionRegister()
    {
        $uname = $_GET['username'];
        $pwd = $_GET['password'];
        
        $username = trim($uname,' ');
        $password = trim($pwd,' ');
        $tel = $_GET['tel'];
        
        $user=new One_member;
        
        $yan = "/^\w+@\w+(\.)\w+$/";
        $val=preg_match($yan,$username);
        
        if($val){
            $user->mem_email = $username;
            
        }else{
            $user->mem_name = $username;
        }    
        $user->mem_password = $password;
        $user->mem_phone = $tel;
        if($user->save()){
            $data['status'] = 200;
            $data['desc'] = '注册成功';
        } else{
            $data['status'] = 400;
            $data['desc'] = '注册失败';
        }
        exit(json_encode($data)); 
    }
    
    //修改密码
    public function actionSave_pwd()
    {
        $id = $_REQUEST['id'];
        $pwd = $_REQUEST['password'];
        $password = trim($pwd,' ');
        
        $save_pwd=One_member::findOne($id);
        $save_pwd->mem_password = $password;
        if($save_pwd->save()){
            $data['status'] = 200;
            $data['desc'] = '修改成功';
        }else{
            $data['status'] = 400;
            $data['desc'] = '修改失败';
        }
        exit(json_encode($data)); 
    }
    
    //注册公司
    public function actionAdd_company()
    {
        $c_name     = $_REQUEST['cname'];
        $c_district = $_REQUEST['cdistrict'];
        $c_phone    = $_REQUEST['ctel'];
        $c_desc     = $_REQUEST['cdesc'];
        
        $company    =  new One_company;
        $company    -> c_name      = $c_name;
        $company    -> district_cn = $c_district;
        $company    -> c_phone     = $c_phone;
        $company    -> c_desc      = $c_desc;
        if($company -> save()){
            $data['status'] = 200;
            $data['desc'] = '注册成功';
        } else{
            $data['status'] = 400;
            $data['desc'] = '注册失败';
        }
        exit(json_encode($data)); 
    }
    
    //公司信息
    public function actionCompany_info()
    {
        $c_name = $_REQUEST['cname'];
        $company_info = One_company::find()->where(['c_name' => $c_name ])->asArray()->one();
        if($company_info){
            $data['status'] = 200;
            $data['desc'] = '成功';
            $data['company_info'] = $company_info;
        }else{
            $data['status'] = 400;
            $data['desc'] = '请求错误';
        }
        //print_r($data);die;
        exit(json_encode($data)); 
    }

    /*
        * 求职意向     
    */
    
    //工作性质
    public function actionJobs_nature()
    {
        $job_nature = One_category::find()->where(['c_alias' => 'QS_jobs_nature'])->all();
        if($job_nature){
            $data['status'] = 200;
            $data['desc'] = '成功';
            foreach ($job_nature as $model) {
                $data['result'][] = $model->attributes;
            }
        }else{
            $data['status'] = 400;
            $data['desc'] = '请求错误';
        }
        //print_r($data);die;
        exit(json_encode($data)); 
    }
    
    //期望薪资（税前）
    public function actionWage()
    {
        $job_wage = One_category::find()->where(['c_alias' => 'QS_wage'])->all();
        if($job_wage){
            $data['status'] = 200;
            $data['desc'] = '成功';
            foreach ($job_wage as $model) {
                $data['result'][] = $model->attributes;
            }
        }else{
            $data['status'] = 400;
            $data['desc'] = '请求错误';
        }
        //print_r($data);die;
        exit(json_encode($data));
    }
    
    //行业类别
    public function actionTrade()
    {
        $job_trade = One_category::find()->where(['c_alias' => 'QS_trade'])->all();
        if($job_trade){
            $data['status'] = 200;
            $data['desc'] = '成功';
            foreach ($job_trade as $model) {
                $data['result'][] = $model->attributes;
            }
        }else{
            $data['status'] = 400;
            $data['desc'] = '请求错误';
        }
        //print_r($data);die;
        exit(json_encode($data));
    }
    
    //职业类别
    public function actionZhiye()
    {
        $job_zhiye = One_category::find()->where(['c_alias' => 'QS_major'])->all();
        if($job_zhiye){
            $data['status'] = 200;
            $data['desc'] = '成功';
            foreach ($job_zhiye as $model) {
                $data['result'][] = $model->attributes;
            }
        }else{
            $data['status'] = 400;
            $data['desc'] = '请求错误';
        }
        //print_r($data);die;
        exit(json_encode($data));
    }
    
    //专业类别
    public function actionMajor()
    {
        $job_major = One_category_major::find()->all();
        if($job_major){
            $data['status'] = 200;
            $data['desc'] = '成功';
            foreach ($job_major as $model) {
                $data['result'][] = $model->attributes;
            }
        }else{
            $data['status'] = 400;
            $data['desc'] = '请求错误';
        }
        //print_r($data);die;
        exit(json_encode($data));
    }
    
    //工作地点
    public function actionDistrict()
    {
        $job_district = One_category_district::find()->all();
        if($job_district){
            $data['status'] = 200;
            $data['desc'] = '成功';
            foreach ($job_district as $model) {
                $data['result'][] = $model->attributes;
            }
        }else{
            $data['status'] = 400;
            $data['desc'] = '请求错误';
        }
        //print_r($data);die;
        exit(json_encode($data));
    }
    
    //求职状态
    public function actionCurrent()
    {
        $job_current = One_category::find()->where(['c_alias' => 'QS_current'])->all();
        if($job_current){
            $data['status'] = 200;
            $data['desc'] = '成功';
            foreach ($job_current as $model) {
                $data['result'][] = $model->attributes;
            }
        }else{
            $data['status'] = 400;
            $data['desc'] = '请求错误';
        }
        //print_r($data);die;
        exit(json_encode($data));
    }
    
    //学历/学位
    public function actionEducation()
    {
        $job_education = One_category::find()->where(['c_alias' => 'QS_education'])->all();
        if($job_education){
            $data['status'] = 200;
            $data['desc'] = '成功';
            foreach ($job_education as $model) {
                $data['result'][] = $model->attributes;
            }
        }else{
            $data['status'] = 400;
            $data['desc'] = '请求错误';
        }
        //print_r($data);die;
        exit(json_encode($data));
    }
    
    
    /**
     * 简历管理
     */
    
    //简历列表
    public function actionList_resume()
    {
        $id = $_REQUEST['id'];
        $list_resume = One_person::find()->where(['uid' => $id])->asArray()->all();
        if($list_resume){
            $data['status'] = 200;
            $data['desc'] = '成功';
            $data['result'] = $list_resume;
        }else{
            $data['status'] = 400;
            $data['desc'] = '您还没有创建简历';
        }
        //print_r($data);die;
        exit(json_encode($data));
    }
    
    //添加简历
    public function actionAdd_resume()
    {
        
    }


    //删除简历
    public function actionDel_resume(){
        $id = $_REQUEST['id'];
        $resume = One_person::find();
        if($resume->delete()){
            $data['status'] = '200';
            $data['desc'] = '成功';
        }else{
            $data['status'] = '425';
            $data['msg'] = '失败';
        }
       exit(json_encode($data));
    }
}

