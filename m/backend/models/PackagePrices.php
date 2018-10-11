<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "package_prices".
 *
 * @property integer $id
 * @property integer $announce_limit
 * @property integer $announce_package1
 * @property integer $announce_package10
 * @property integer $announce_premium10
 * @property integer $announce_premium15
 * @property integer $announce_premium30
 * @property integer $announce_foward1
 * @property integer $announce_foward20
 * @property integer $announce_foward50
 * @property integer $announce_fb
 * @property integer $announce_share
 * @property integer $announce_search10
 * @property integer $announce_urgent
 */
class PackagePrices extends \yii\db\ActiveRecord
{
    public static $titleName='Paket qiymətləri';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=130, THUMB_IMAGE_HEIGHT=130;

    public static function tableName()
    {
        return 'package_prices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['announce_limit', 'announce_time', 'announce_package1', 'announce_package10', 'announce_package50', 'announce_premium10', 'announce_premium15', 'announce_premium30', 'announce_foward1', 'announce_foward20', 'announce_foward50', 'announce_fb', 'announce_search10', 'announce_urgent', 'realtor_premium1', 'realtor_premium3', 'realtor_premium6', 'announce_foward_time','announce_download'], 'required'],
            [['announce_limit', 'announce_time', 'announce_package1', 'announce_package10', 'announce_premium10', 'announce_premium15', 'announce_premium30', 'announce_foward1', 'announce_foward20', 'announce_foward50', 'announce_fb', 'announce_search10', 'announce_urgent', 'realtor_premium1', 'realtor_premium3', 'realtor_premium6', 'announce_foward_time', 'announce_download'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'announce_limit' => 'Aylıq elan limiti',
            'announce_time' => 'Elanın vaxtının bitmə müddəti (gün)',
            'announce_package1' => 'Elan Paket (1 ədəd)',
            'announce_package10' => 'Elan Paket (10 ədəd)',
            'announce_package50' => 'Elan Paket (50 ədəd)',
            'announce_premium10' => 'Elan Premium (10 gün)',
            'announce_premium15' => 'Elan Premium (15 gün)',
            'announce_premium30' => 'Elan Premium (30 gün)',
            'announce_foward1' => 'Elan irəli çək (1 ədəd)',
            'announce_foward20' => 'Elan irəli çək (20 ədəd)',
            'announce_foward50' => 'Elan irəli çək (50 ədəd)',
            'announce_foward_time' => 'Elan irəlidə qalma müddəti (saat)',
            'announce_download' => 'Elanın şəkillərini yükləmək üçün qiymət',
            'announce_fb' => 'Elan Fb və instaqramda paylaş',
            'announce_search10' => 'Elan axtarışda önə çıxsın',
            'announce_urgent' => 'Elan təcili etmək',
            'realtor_premium1' => 'Əmlakçılar bölməsi (1 aylıq)',
            'realtor_premium3' => 'Əmlakçılar bölməsi (3 aylıq)',
            'realtor_premium6' => 'Əmlakçılar bölməsi (6 aylıq)',
        ];
    }
}
