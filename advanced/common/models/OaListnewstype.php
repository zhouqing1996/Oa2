<?php

namespace common\models;

use Yii;

/**
 *
 * @property int $S_typeid 审批表中类型id
 * @property varchar $S_typename 申请人类型名称 信息类、文件类、单选问题、多选问题

 */
class OaListnew extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        // 申请表中的申请问题的类型
        return 'oa_listnewstype';
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['S_typeid','S_typename'],'required'],
            [['S_typeid'],'integer'],
            [['S_typename'],'string','max' =>255],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'S_typeid'=>'stypeid',
            'S_typename'=>'stypename'
        ];
    }
}
