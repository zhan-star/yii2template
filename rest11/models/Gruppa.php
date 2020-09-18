<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gruppa".
 *
 * @property int $gruppa_id
 * @property string $name
 * @property int $special_id
 * @property string $date_begin
 * @property string|null $date_end
 *
 * @property Special $special
 * @property Student[] $students
 */
class Gruppa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gruppa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['special_id', 'date_begin'], 'required'],
            [['special_id'], 'integer'],
            [['date_begin', 'date_end'], 'safe'],
            [['name'], 'string', 'max' => 10],
            [['special_id'], 'exist', 'skipOnError' => true, 'targetClass' => Special::className(), 'targetAttribute' => ['special_id' => 'special_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'gruppa_id' => 'Gruppa ID',
            'name' => 'Name',
            'special_id' => 'Special ID',
            'date_begin' => 'Date Begin',
            'date_end' => 'Date End',
        ];
    }

    /**
     * Gets query for [[Special]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\SpecialQuery
     */
    public function getSpecial()
    {
        return $this->hasOne(Special::className(), ['special_id' => 'special_id']);
    }

    /**
     * Gets query for [[Students]].
     *
     * @return \yii\db\ActiveQuery|\app\models\queries\StudentQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['gruppa_id' => 'gruppa_id']);
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
