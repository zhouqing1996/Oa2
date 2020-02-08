<?php

namespace common\models;

use Yii;

/**
 *
 * @property int $S_id 审批表id
 * @property int $P_id 申请人id
 * @property int $T_id 申请类型id
 * @property datetime $S_time 申请时间
 * @property int $flags 申请完成标志 //未完成的审批表 0 已完成1
 * @property int $isV 申请有效性标志 //1有效0无效
 // * @property varchar $typename

 */
class OaListnew extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oa_listnew';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['S_id','P_id','T_id','flags','isV'],'required'],
            [['S_id','P_id','T_id','flags','isV'],'integer'],
             [['S_time'],'datetime'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'S_id'=>'sid',
            'T_id' =>'tid',
            'P_id' =>'pid',
            'S_time' => 'stime',
            'isV' => 'isv',
            'flags' =>'flag',
        ];
    }
}
