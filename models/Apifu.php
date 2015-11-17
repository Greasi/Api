<?php
namespace app\models;
use yii\db\ActiveRecord;
use yii\base\ModelEvent;
class Apifu extends ActiveRecord  
{	
	//职位列表
	public function select_api($num){
		$sql = "select * from one_position limit ".intval($num);
		$result = \Yii::$app->db->createCommand($sql);
		$rows = $result->queryAll();
		foreach($rows as $k=>$v){
			$rows[$k]['fresh_time'] = date("Y-m-d",$v['fresh_time']	);
		}
		return $rows;
	}

	//��ѯ��������������
	public function select_area(){
		$sql = "select id, parentid, categoryname from one_category_district";
		$result = \Yii::$app->db->createCommand($sql);
		$rows = $result->queryAll();
		$result = array();
		foreach( $rows as $k=>$v ){
			if($v['parentid'] == 0){
				$result[] = $v;
			}
		}

		foreach ( $result as $kk => $vv ){
			foreach ($rows as $k => $v ){
				if( $vv['id'] == $v['parentid'] ){
					$result[$kk]["child"][] = $v;
				}
			}
		}
		return $result;
	}


	//��ѯְλ����
	public function select_position($id){
		$sql = "select po_name, po_position, po_people, po_disc, po_money, po_sex, po_education, po_suffer, po_desc, is_status, add_time, fresh_time, out_time, contact, telephone, address, po_tag, email, c_man, c_phone from one_position as p join one_company as c on p.c_id = c.c_id where po_id = ".intval($id);
		$result = \Yii::$app->db->createCommand($sql);
		$row = $result->queryOne();
		$row['po_tag'] = explode(',',$row['po_tag']);
		return $row;
	}


	//��ѯ��˾���� �Լ� ��˾��Ƹ������ְλ
	public function select_company($id){
		$sql = "select c_name, c_nature, trade_cn, district_cn, c_man, c_phone, c_memail, c_desc, c_logo, c_biaozhu, c_integral, c_scale, c_scale, mem_id, c_website, x, y, zoom from one_company where c_id = " . intval($id);
		$result = \Yii::$app->db->createCommand($sql);
		$rows = $result->queryOne();
		$rows['positions'] = $this->company_position($id);
		return $rows;
	}
	//��ѯ��˾��Ƹ��ְλ
	public function company_position($id){
		
		$sql = "select po_name, po_position, po_people, po_disc, po_money, po_sex, po_education, po_suffer, po_desc, is_status, add_time, fresh_time, out_time, contact, telephone, address, po_tag, email from one_position where c_id = " . intval($id);
		$result = \Yii::$app->db->createCommand($sql);
		$rows = $result->queryAll();
		return $rows;
	}

	//��ѯ��ҵһ��  one_category_major
	public function select_one_major(){
		$sql = "select id, categoryname from one_category_major where parentid != 0";
		$result = \Yii::$app->db->createCommand($sql);
		return $rows = $result->queryAll();

	}

	//��ѯְ�ܶ��� 
	public function select_two_job(){
		$sql = "select id, parentid, categoryname from one_category_jobs";
		$result = \Yii::$app->db->createCommand($sql);
		$rows = $result->queryAll();
		$results = array();
		foreach($rows as $k=>$v){
			if($v['parentid'] == 0){
				unset($v['parentid']);
				$results[] =$v;
			}
		}
		$two_job = array();
		foreach($results as $kk=>$vv){
			foreach($rows as $key=>$value){
				if($value['parentid'] == $vv['id']){
					foreach($rows as $ke=>$va){
						if($value['id'] == $va['parentid']){
							$results[$kk]['child'][]=$va;
						}
					}
				}
			}
		}

		foreach($results as $k=>$v){
			$results[$k]['parent'] = array(
				'id' => $results[$k]['id'],
				'categoryname' => $results[$k]['categoryname']
			);
			unset($results[$k]['id']);
			unset($results[$k]['categoryname']);
			foreach($v['child'] as $kk=>$vv){
				unset($results[$k]['child'][$kk]['parentid']);
			}
		}
		return $results;
	}

	//搜索 one_position
	public function search_position($where){
		if(empty($where['area']) && empty($where['cate']) && empty($where['job']))
		{
			return "条件不能全部为空";
		}
		$condition = "where 1=1 ";

		if(isset($where['area']) && $where['area'] != ""){
			$condition .= " and po_disc like '" . htmlspecialchars($where['area']) . "'";
		}
		if(isset($where['cate']) && $where['cate'] != ""){
			$condition .= " and po_position like '" . htmlspecialchars($where['cate']) . "'";
		}
		if(isset($where['job']) && $where['job'] != ""){
			$condition .= " and po_name like '" . htmlspecialchars($where['job']) . "'";
		}
		$sql = "select po_name, po_position, po_people, po_disc, po_money, po_sex, po_education, po_suffer, po_desc, is_status, add_time, fresh_time, out_time, contact, telephone, address, po_tag, email from one_position " . $condition ;
		$result = \Yii::$app->db->createCommand($sql);
		$rows = $result->queryAll();
		foreach($rows as $k=>$v){
			$rows[$k]['fresh_time'] = date("Y-m-d",$v['fresh_time']	);
		}
		return $rows;
	}
}
