<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "announces_deleted".
 *
 * @property integer $id
 * @property string $email
 * @property string $mobile
 * @property string $name
 * @property double $price
 * @property string $cover
 * @property string $images
 * @property string $logo_images
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
 * @property integer $view_count
 * @property integer $announcer
 * @property integer $status
 * @property integer $insert_type
 * @property integer $urgently
 * @property integer $sort_search
 * @property integer $sort_foward
 * @property integer $sort_package
 * @property integer $sort_premium
 * @property integer $announce_date
 * @property integer $visitors_count
 * @property integer $create_time
 */
class AnnouncesDeleted extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'announces_deleted';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'room_count', 'rent_type', 'property_type', 'announce_type', 'country', 'city', 'region', 'settlement', 'metro', 'floor_count', 'current_floor', 'repair', 'document', 'view_count', 'announcer', 'status', 'insert_type', 'urgently', 'sort_search', 'sort_foward', 'sort_package', 'sort_premium', 'announce_date', 'visitors_count', 'create_time'], 'integer'],
            [['price', 'space'], 'number'],
            [['images', 'logo_images', 'text'], 'required'],
            [['images', 'logo_images', 'text'], 'string'],
            [['email', 'mobile', 'cover', 'mark', 'address'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'mobile' => 'Mobile',
            'name' => 'Name',
            'price' => 'Price',
            'cover' => 'Cover',
            'images' => 'Images',
            'logo_images' => 'Logo Images',
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
            'view_count' => 'View Count',
            'announcer' => 'Announcer',
            'status' => 'Status',
            'insert_type' => 'Insert Type',
            'urgently' => 'Urgently',
            'sort_search' => 'Sort Search',
            'sort_foward' => 'Sort Foward',
            'sort_package' => 'Sort Package',
            'sort_premium' => 'Sort Premium',
            'announce_date' => 'Announce Date',
            'visitors_count' => 'Visitors Count',
            'create_time' => 'Create Time',
        ];
    }
}
