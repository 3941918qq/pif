<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "code_list".
 *
 * @property int $id
 * @property string $type 业务种类1级
 * @property int $code 业务编号
 * @property string $name 业务名称2级
 * @property int $num 名称编号
 */
class CodeList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'code_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'num'], 'integer'],
            [['type', 'name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'code' => 'Code',
            'name' => 'Name',
            'num' => 'Num',
        ];
    }
}
