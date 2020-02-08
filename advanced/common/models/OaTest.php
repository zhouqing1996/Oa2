<?php

namespace common\models;

use Yii;
class OaTest extends \yii\db\ActiveRecord
{
	public static function tableName()
    {
        return 'oa_test';
    }
     public function rules()
    {
        return [
            [['content'],'string','max'=>255],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'content'=>'content'
        ];
    }
}