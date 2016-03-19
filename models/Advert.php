<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "advert".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $region_id
 * @property integer $city_id
 * @property integer $category_id
 * @property integer $subcategory_id
 * @property string $title
 * @property string $text
 * @property string $price
 * @property string $currency
 * @property string $u_price
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $views
 * @property string $avatar
 *
 * @property User $user
 * @property Region $region
 * @property City $city
 * @property Category $category
 * @property Subcategory $subcategory
 * @property Bookmark[] $bookmarks
 * @property Views[] $views0
 */
class Advert extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advert';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'price', 'currency'], 'required'],
            [['user_id', 'region_id', 'city_id', 'category_id', 'subcategory_id', 'created_at', 'updated_at', 'views'], 'integer'],
            [['text'], 'string'],
            [['price', 'u_price'], 'number'],
            [['title', 'avatar'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
            ['region_id', 'required', 'message' => 'Region cannot be blank'],
            ['city_id', 'required', 'message' => 'City cannot be blank'],
            ['category_id', 'required', 'message' => 'Category cannot be blank'],
            ['subcategory_id', 'required', 'message' => 'Subcategory cannot be blank'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'region_id' => 'Region ID',
            'city_id' => 'City ID',
            'category_id' => 'Category ID',
            'subcategory_id' => 'Subcategory ID',
            'title' => 'Title',
            'text' => 'Text',
            'price' => 'Price',
            'currency' => 'Currency',
            'u_price' => 'U Price',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'views' => 'Views',
            'avatar' => 'Avatar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::className(), ['id' => 'subcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookmarks()
    {
        return $this->hasMany(Bookmark::className(), ['advert_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getViews0()
    {
        return $this->hasMany(Views::className(), ['advert_id' => 'id']);
    }

    /**
     * Creates new advert
     *
     * @return Advert|null
     */
    public function createAdvert()
    {
        $currency = Currency::find()->where(['date' => 0])->asArray()->one();
        if ($this->validate()) {
            $advert = new Advert;
            $advert->user_id = Yii::$app->user->identity->getId();
            $advert->category_id = $this->category_id;
            $advert->subcategory_id = $this->subcategory_id;
            $advert->region_id = $this->region_id;
            $advert->city_id = $this->city_id;
            $advert->title = $this->title;
            $advert->text = $this->text;
            $advert->price = $this->price;
            $advert->currency = $this->currency;
            $advert->u_price = $this->price * $currency[$this->currency];
            $advert->created_at = time();
            $advert->updated_at = time();
            $advert->views = 0;
            if ($advert->save()) {
                return $advert;
            }
        }
        return null;
    }

    /**
     * @param $userId
     * @param $myId
     * @return mixed
     */
    public function getContacts($userId, $myId)
    {
        $user = User::findOne(['id' =>$userId]);
        $notSet = '<span class="not-set">not set</span>';

        if ($userId == $myId) {
            $contacts['Phone'] = empty($user->phone) ? $notSet : $user->phone;
            $contacts['Skype'] = empty($user->skype) ? $notSet : $user->skype;
        } else {
            $contacts['Phone'] = empty($user->phone) ? '' : $user->phone;
            $contacts['Skype'] = empty($user->skype) ? '' : $user->skype;
        }

        return $contacts;
    }

    /**
     * @param $userId
     * @param $myId
     * @return string
     */
    public function contact($userId, $myId)
    {
        $user = User::findOne(['id' =>$userId]);

        if ($userId == $myId) {
            $contact = '<p class="contact">My contacts: </p>';
            $contact .= '<p><strong>E-mail: </strong>' . $user->email . '</p>';
        } else {
            $contact = '<p class="contact">Contact the author: </p>';
            $contact .= '<p><a href="create"><strong>Write an e-mail</strong></a></p>';
        }

        return $contact;
    }
}
