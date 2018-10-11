<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ContactSearch represents the model behind the search form about `backend\models\Contact`.
 */
class ContactSearch extends Contact
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','position', 'save_mode'], 'integer'],
            [MyFunctions::attrForLangs('text'), 'safe'],
            [MyFunctions::attrForLangs('footer'), 'safe'],
            [MyFunctions::attrForLangs('address'), 'safe'],
            [['email', 'facebook', 'twitter', 'vkontakte', 'linkedin', 'digg', 'flickr', 'dribbble', 'vimeo', 'myspace', 'google', 'youtube', 'instagram', 'phone', 'mobile','phone2', 'mobile2', 'skype', 'fax', 'google_map'], 'safe'],
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
        $query = Contact::find();

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
        ]);

        $text='text_'.Yii::$app->params["defaultLanguage"];
        $footer='footer_'.Yii::$app->params["defaultLanguage"];
        $address='address_'.Yii::$app->params["defaultLanguage"];
        $query->andFilterWhere(['like', $text, $this->$text])
            ->andFilterWhere(['like', $footer, $this->$footer])
            ->andFilterWhere(['like', $address, $this->$address])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'facebook', $this->facebook])
            ->andFilterWhere(['like', 'twitter', $this->twitter])
            ->andFilterWhere(['like', 'vkontakte', $this->vkontakte])
            ->andFilterWhere(['like', 'linkedin', $this->linkedin])
            ->andFilterWhere(['like', 'digg', $this->digg])
            ->andFilterWhere(['like', 'flickr', $this->flickr])
            ->andFilterWhere(['like', 'dribbble', $this->dribbble])
            ->andFilterWhere(['like', 'vimeo', $this->vimeo])
            ->andFilterWhere(['like', 'myspace', $this->myspace])
            ->andFilterWhere(['like', 'google', $this->google])
            ->andFilterWhere(['like', 'youtube', $this->youtube])
            ->andFilterWhere(['like', 'instagram', $this->instagram])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'phone2', $this->phone2])
            ->andFilterWhere(['like', 'mobile2', $this->mobile2])
            ->andFilterWhere(['like', 'skype', $this->skype])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'google_map', $this->google_map]);

        $orderBy=[];
        if(self::$sortableStatus===true) $orderBy['position'] = self::$sortablePositionOrder;
        if(self::$sortableConditionStatus===true) $orderBy[self::$sortableConditionField]= self::$sortableConditionFieldOrder;
        $query->orderBy($orderBy);

        return $dataProvider;
    }
}
