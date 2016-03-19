<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Advert;

/**
 * SearchAdvert represents the model behind the search form about `app\models\Advert`.
 */
class SearchAdvert extends Advert
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'region_id', 'city_id', 'category_id', 'subcategory_id', 'created_at', 'updated_at', 'views'], 'integer'],
            [['title', 'text', 'currency', 'avatar'], 'safe'],
            [['price', 'u_price'], 'number'],
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
        $query = Advert::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'region_id' => $this->region_id,
            'city_id' => $this->city_id,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'price' => $this->price,
            'u_price' => $this->u_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'views' => $this->views,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'currency', $this->currency])
            ->andFilterWhere(['like', 'avatar', $this->avatar]);

        return $dataProvider;
    }
}