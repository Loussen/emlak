<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AuthorsSearch represents the model behind the search form about `backend\models\Authors`.
 */
class AuthorsSearch extends Authors
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'post_count', 'last_post_time', 'create_time', 'status'], 'integer'],
            [MyFunctions::attrForLangs('about'), 'safe'],
            [['name', 'image', 'slug'], 'safe'],
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
    public function search($params)
    {
        $query = Authors::find();

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
            'post_count' => $this->post_count,
            'last_post_time' => $this->last_post_time,
            'create_time' => $this->create_time,
            'status' => $this->status,
        ]);

        $about='about_'.Yii::$app->params["defaultLanguage"];
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', $about, $this->$about])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'slug', $this->slug]);
			
		$orderBy=[];
        if(self::$sortableStatus===true) $orderBy['position'] = self::$sortablePositionOrder;
        if(self::$sortableConditionStatus===true) $orderBy[self::$sortableConditionField]= self::$sortableConditionFieldOrder;
        $query->orderBy($orderBy);

        return $dataProvider;
    }
}
