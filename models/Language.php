<?php
namespace app\models;

use yii\db\ActiveRecord;

class Language extends ActiveRecord
{
    public static function tableName()
    {
        return 'allinonemedia.languages';
    }

    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['language_id' => 'id']);
    }
}