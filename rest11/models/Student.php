<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $user_id
 * @property int $gruppa_id
 * @property string $num_zach
 *
 * @property Gruppa $gruppa
 * @property User $user
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'gruppa_id'], 'required'],
            [['user_id', 'gruppa_id'], 'integer'],
            [['num_zach'], 'string', 'max' => 10],
            [['user_id'], 'unique'],
            [['gruppa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gruppa::className(), 'targetAttribute' => ['gruppa_id' => 'gruppa_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'gruppa_id' => 'Gruppa ID',
            'num_zach' => 'Num Zach',
        ];
    }

    /**
     * Gets query for [[Gruppa]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\GruppaQuery
     */
    public function getGruppa()
    {
        return $this->hasOne(Gruppa::className(), ['gruppa_id' => 'gruppa_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\queries\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\queries\UserQuery(get_called_class());
    }
}
