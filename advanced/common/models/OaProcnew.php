<?php

namespace common\models;

use Yii;

/**
 *
 * @property int $S_id 审批表id
 * @property varchar $S_title 申请表名称
 * @property int $S_qid 申请问题id
 * @property int $S_qtype 申请问题的类型，信息类、上传文件类
 * @property varchar $S_qname 申请问题
 * @property varchar $S_qans 申请问题的回答，用于回答问题
 // * @property varchar $typename

 */
class OaProcnew extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oa_procnew';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['S_id','S_title'],'required'],
            [['S_id','S_qid','S_qtype'],'integer'],
            [['S_title','S_qname','S_qans'],'string','max'=>255],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'S_id'=>'sid',
            'S_qid'=>'sqid',
            'S_qtype'=>'sqtype',
            'S_title'=>'stitle',
            'S_qname'=>'sqname',
            'S_qans'=>'sqans'
        ];
    }
}
