<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\product;

/**
 * ProductSearch represents the model behind the search form of `app\models\product`.
 */
class ProductSearch extends product
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category', 'manufacturer_id', 'is_new'], 'integer'],
            [['name', 'preview', 'manufacturer_id'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = product::find();

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
            'category' => $this->category,
            'manufacturer_id' => $this->manufacturer_id,
            'is_new' => $this->is_new,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'preview', $this->preview])
            ->andFilterWhere(['like', 'descriptionShort', $this->descriptionShort])
            ->andFilterWhere(['like', 'descriptionMore', $this->descriptionMore]);

        return $dataProvider;
    }
}
