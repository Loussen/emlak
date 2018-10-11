<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "mobile_package".
 *
 * @property integer $id
 * @property string $mobile
 * @property integer $balance
 */
class MobilePackage extends \yii\db\ActiveRecord
{
    public static $titleName='Mobil paketlər';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;
	
	
    public static function tableName()
    {
        return 'mobile_package';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'balance'], 'required'],
            [['balance, create_time'], 'integer'],
            [['mobile'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Mobil',
            'balance' => 'Balans',
            'create_time' => 'Tarix',
        ];
    }
}
