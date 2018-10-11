<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SeoManual;

/**
 * SeoManualSearch represents the model behind the search form about `backend\models\SeoManual`.
 */
class SeoManualInnerSearch extends SeoManualInner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','status','parent_id'], 'integer'],
            [['link_', 'title_', 'description_', 'keywords_','page_title', 'text_top', 'text_bottom', 'sql_'], 'safe'],
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
    public function search($params,$id)
    {
        $query = SeoManualInner::find(); // ->where(['parent_id'=>$id])

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
			'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'link_', $this->link_])
            ->andFilterWhere(['like', 'title_', $this->title_])
            ->andFilterWhere(['like', 'description_', $this->description_])
            ->andFilterWhere(['like', 'keywords_', $this->keywords_])
            ->andFilterWhere(['like', 'page_title', $this->page_title])
            ->andFilterWhere(['like', 'text_top', $this->text_top])
            ->andFilterWhere(['like', 'text_bottom', $this->text_bottom])
            ->andFilterWhere(['like', 'sql_', $this->sql_]);
			
		$orderBy=['id'=>SORT_DESC];
        if(self::$sortableStatus===true) $orderBy['position'] = self::$sortablePositionOrder;
        if(self::$sortableConditionStatus===true) $orderBy[self::$sortableConditionField]= self::$sortableConditionFieldOrder;
        $query->orderBy($orderBy);

        return $dataProvider;
    }
}
