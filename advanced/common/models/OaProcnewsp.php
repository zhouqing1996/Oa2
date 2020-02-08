<?php

namespace common\models;

use Yii;

/**
审批人的数据库
 * @property int $S_id 审批表id
 * @property int $S_spid 审批人的id
 * @property int $S_spflags 审批人的意见
 * @property int $S_spn 审批人的位次
 */
class OaProcnew extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oa_procnewsp';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['S_id'],'required'],
            [['S_id','S_spid','S_spflags','S_spn'],'integer'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'S_id'=>'sid',
            'S_spid'=>'sspid',
            'S_spflags'=>'sspflags',
            'S_spn'=>'sspn'
    }
}
