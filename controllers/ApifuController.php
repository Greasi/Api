<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Apifu;

header('content-type:text/html;charset=utf8');


/* 职位接口
 * 2015年11月16日 09:55:22
 * author FSG
 */
 class ApifuController extends Controller
{
	public function actionIndex()
    {
		//$result = \Yii::$app->db->createCommand($sql);
		echo "这是接口页面";
	}
	
	//获取二级地区
	public function actionArea()
	{
		$query = new Apifu;
		$list = $query -> select_area();
		echo $this->actionJson($list);
	}

	//获取职位列表
	public function actionPosition_list()
	{
		$num = isset($_GET['num']) ? intval($_GET['num']) : 4;
		if($num == 0){
			die("职位列表默认为四条");
		}
		$query = new Apifu;
		$list = $query->select_api($num);
		echo $this->actionJson($list);
	}
	
	//查询公司详情
	public function actionCompany(){
		$id = isset($_GET['company']) ? intval($_GET['company']) : 0;
		if($id == 0){
			die("公司的ID不正确");
		}
		$query = new Apifu;
		$company = $query -> select_company($id);
		echo $this->actionJson($company);
	}

	//获取职位详情
	public function actionPosition(){
		$id = isset($_GET['position']) ? intval($_GET['position']) : 0;
		if($id == 0){
			die("职位的ID不正确");
		}
		$query = new Apifu;
		$position = $query -> select_position($id);
		echo $this->actionJson($position);
	}

	//活动一级行业列表
	public function actionMajor(){
		$query = new Apifu;
		$major = $query -> select_one_major();
		echo $this->actionJson($major);
	}

	//二级职能
	public function actionJob(){
		$query = new Apifu;
		$job = $query -> select_two_job();
		echo $this->actionJson($job);
	}

	//搜索职位
	public function actionSearch(){
		$query = new Apifu;

		//地区、行业、职业类型
		$where['area'] = isset($_GET['area']) ? $_GET['area'] : "" ;
		$where['cate'] = isset($_GET['cate']) ? $_GET['cate'] : "" ;
		$where['job']  = isset($_GET['job']) ? $_GET['job']  : "" ;
		if( empty($where['area']) && empty($where['cate']) && empty($where['job']) ){
			die("我感觉条件全部为空，就没必要查了吧，你说呢？");
		}
		$job = $query -> search_position($where);
		echo $this->actionJson($job);
	}
	
	//将数据转换为json格式
	public function actionJson($data){
		if(empty($data)){
			$result['code'] = 200;
			$result['data'] =  "数据库暂无数据";
		}else{
			$result['code'] = 200;
			$result['data'] = $data;
		}
		return json_encode($result);
	}


}	