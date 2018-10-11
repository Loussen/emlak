<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "announces_edited".
 *
 * @property integer $id
 * @property integer $announce_id
 * @property string $email
 * @property string $mobile
 * @property string $name
 * @property double $price
 * @property string $images
 * @property integer $room_count
 * @property integer $rent_type
 * @property integer $property_type
 * @property integer $announce_type
 * @property integer $country
 * @property integer $city
 * @property integer $region
 * @property integer $settlement
 * @property integer $metro
 * @property string $mark
 * @property string $address
 * @property string $google_map
 * @property integer $floor_count
 * @property integer $current_floor
 * @property double $space
 * @property integer $repair
 * @property integer $document
 * @property string $text
 * @property integer $announcer
 * @property integer $create_time
 * @property integer $view_count
 * @property string $panarama
 */
class AnnouncesEdited extends \yii\db\ActiveRecord
{
    public static $titleName='Elan düzəlişləri';

    public static function tableName()
    {
        return 'announces_edited';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['announce_id', 'email', 'mobile', 'name', 'price', 'images', 'room_count', 'rent_type', 'property_type', 'announce_type', 'country', 'city', 'region', 'settlement', 'metro', 'mark', 'address', 'google_map', 'floor_count', 'current_floor', 'space', 'repair', 'document', 'text', 'announcer', 'create_time'], 'required'],
            [['announce_id', 'room_count', 'rent_type', 'property_type', 'announce_type', 'country', 'city', 'region', 'settlement', 'metro', 'floor_count', 'current_floor', 'repair', 'document', 'announcer', 'create_time', 'view_count'], 'integer'],
            [['price', 'space'], 'number'],
            [['images', 'text', 'panarama'], 'string'],
            [['email', 'mobile', 'mark', 'address', 'panarama'], 'string', 'max' => 255],
            [['name', 'google_map'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'announce_id' => 'Announce ID',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'name' => 'Name',
            'price' => 'Price',
            'images' => 'Images',
            'room_count' => 'Room Count',
            'rent_type' => 'Rent Type',
            'property_type' => 'Property Type',
            'announce_type' => 'Announce Type',
            'country' => 'Country',
            'city' => 'City',
            'region' => 'Region',
            'settlement' => 'Settlement',
            'metro' => 'Metro',
            'mark' => 'Mark',
            'address' => 'Address',
            'google_map' => 'Google Map',
            'floor_count' => 'Floor Count',
            'current_floor' => 'Current Floor',
            'space' => 'Space',
            'repair' => 'Repair',
            'document' => 'Document',
            'text' => 'Text',
            'announcer' => 'Announcer',
            'create_time' => 'Create Time',
            'panarama' => 'Panarama (360)',
            'view_count' => 'Baxış sayı'
        ];
    }
}
