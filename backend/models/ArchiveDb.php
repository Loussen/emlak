<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "archive_db".
 *
 * @property integer $id
 * @property string $from_
 * @property string $to_
 * @property string $operation
 * @property string $mobiles
 * @property integer $insert_type
 * @property string $time_count
 * @property double $price
 * @property integer $announce_id
 * @property string $note
 * @property string $profil_information
 * @property integer $create_time
 */
class ArchiveDb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'archive_db';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['insert_type', 'announce_id', 'create_time'], 'integer'],
            [['price'], 'number'],
            [['profil_information'], 'string'],
            [['from_', 'to_', 'operation', 'mobiles', 'time_count', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_' => 'From',
            'to_' => 'To',
            'operation' => 'Operation',
            'mobiles' => 'Mobiles',
            'insert_type' => 'Insert Type',
            'time_count' => 'Time Count',
            'price' => 'Price',
            'announce_id' => 'Announce ID',
            'note' => 'Note',
            'profil_information' => 'Profil Information',
            'create_time' => 'Create Time',
        ];
    }
}
