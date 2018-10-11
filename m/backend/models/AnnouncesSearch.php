<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Announces;

/**
 * AnnouncesSearch represents the model behind the search form about `backend\models\Announces`.
 */
class AnnouncesSearch extends Announces
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'room_count', 'rent_type', 'property_type', 'announce_type', 'country', 'city', 'region', 'settlement', 'metro', 'floor_count', 'current_floor', 'repair', 'document', 'view_count', 'announcer', 'insert_type', 'urgently', 'sort_search', 'sort_foward', 'sort_package', 'sort_premium'], 'integer'],
            [['email', 'mobile', 'name', 'cover', 'mark', 'address', 'google_map', 'text',], 'safe'],
            [['price', 'space'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$status)
    {
        $query = Announces::find();
        if($status>0 && $status<=4) $query->where(['status'=>$status]);
		elseif($status==5) $query->where('sort_foward>0');
		elseif($status==6) $query->where('urgently>0');
		elseif($status==7) $query->where('sort_premium>0');
		elseif($status==8) $query->where('sort_search>0');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'room_count' => $this->room_count,
            'rent_type' => $this->rent_type,
            'property_type' => $this->property_type,
            'announce_type' => $this->announce_type,
            'country' => $this->country,
            'city' => $this->city,
            'region' => $this->region,
            'settlement' => $this->settlement,
            'metro' => $this->metro,
            'floor_count' => $this->floor_count,
            'current_floor' => $this->current_floor,
            'space' => $this->space,
            'repair' => $this->repair,
            'document' => $this->document,
            'view_count' => $this->view_count,
            'announcer' => $this->announcer,
            'insert_type' => $this->insert_type,
            'urgently' => $this->urgently,
            'sort_search' => $this->sort_search,
            'sort_foward' => $this->sort_foward,
            'sort_package' => $this->sort_package,
            'sort_premium' => $this->sort_premium,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'mark', $this->mark])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'google_map', $this->google_map])
            ->andFilterWhere(['like', 'text', $this->text]);

        $orderBy=[];
        if(self::$sortableStatus===true) $orderBy['position'] = self::$sortablePositionOrder;
        if(self::$sortableConditionStatus===true) $orderBy[self::$sortableConditionField]= self::$sortableConditionFieldOrder;
		if(count($orderBy)==0) $orderBy=['announce_date'=>SORT_DESC];
        $query->orderBy($orderBy);

        return $dataProvider;
    }
}
