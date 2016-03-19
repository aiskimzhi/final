<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $date
 * @property string $usd
 * @property string $eur
 * @property string $rur
 * @property string $uan
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'usd', 'eur', 'rur', 'uan'], 'required'],
            [['date'], 'integer'],
            [['usd', 'eur', 'rur', 'uan'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'usd' => 'Usd',
            'eur' => 'Eur',
            'rur' => 'Rur',
            'uan' => 'Uan',
        ];
    }
}
