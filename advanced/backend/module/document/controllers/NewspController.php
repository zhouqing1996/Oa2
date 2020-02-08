<?php
namespace backend\module\document\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Request;
use yii\data\Pagination;
use yii\db\Query;
use common\models\OaListnew;//新建申请表列表
use common\models\OaListnewstype;//新建申请表中的问题的类型
use common\models\OaProcnew;//新建的申请表（包含问题）
use common\models\OaListtype;//新建申请表类型表
use common\models\OaList;//申请表
use common\models\OaProcnewsp;//新建的申请表的审批人列表



class NewspController extends Controller
{
    public function actionIndex()
    {
        return array("data" =>"5","msg"=>"新建审批表");
    }
    public function actionGetlisttype()
    {
    	// 申请表类型
        $query = (new Query())
                ->select('*')
                ->from('oa_listtype')
                ->all();
        return array("data" =>$query,"msg" => "申请表类型查找成功");

    }
    public function actionCreatenew()
    {
    	// 新建审批表
    	// 需要新的审批表的id和申请人的id
    	$request = \Yii::$app->request;
    	// $sid = $request->post('sid');
    	$id = (new Query())
            ->select('*')
            ->from('oa_listnew')
            ->max('S_id');
        $sid = $id+1;
    	$pid = $request->post('pid');
    	// 申请类型id、标题、时间
    	$tid = $request->post('tid');
    	$stitle = $request->post('stitle');
    	$stime = $request->post('stime');
    	// $lid = (new Query())
     //        ->select('*')
     //        ->from('oa_list')
     //        ->max('listid');
     //    $listid = $lid +1;
            //申请表列表,新创建的表不放在模板表中
        // $resultlist = \Yii::$app->db->createCommand()->insert('oa_list',array(
        // 	'no'=>$listid,
        // 	'listid'=>$listid,
        // 	'listname'=>$stitle,
        // 	'typeid'=>$tid)
        // )->execute();
    	// 在新建申请表中写下
    	$resultlistnew = \Yii::$app->db->createCommand()->insert('oa_listnew',array(
            'S_id' => $sid,
            'P_id' =>$pid,
            'T_id' => $tid,
            'S_time' =>$stime,
            'flags' => 0,
            'isV' => 1)
        )->execute();
        //在审批流程表中写下
        $resultproc = \Yii::$app->db->createCommand()->insert('oa_procnew',array(
        	'S_id'=>$sid,
        	'S_title'=>$stitle
        ))->execute();
        if($resultlistnew==1&&$resultproc==1)
        	return array("data"=>[$resultlistnew,$resultproc],"msg"=>"创建申请表成功！");
        else
        	return array("data"=>"111","msg"=>"创建申请表失败！");
    }

}