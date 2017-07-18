<?php

namespace common\models;

use Yii;
use \yii\db\ActiveRecord;

class Journal extends ActiveRecord
{	
    public static function tableName()
    {
        return 'journal';
    }

    public function rules()
    {
        return [
            [['title', 'date', 'description'], 'required'],
            [['date'], 'safe'],
            [['title'], 'string', 'max' => 64],
            [['description'], 'string', 'max' => 512],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'title' => 'Title',
            'description' => 'Description',
            'date' => 'Date',
        ];
    }

    public function getImages()
    {
        return $this->hasMany(Image::className(), ['journal_id' => 'id']);
    }

    /*public function getJournalAuthors()
    {
        return $this->hasMany(JournalAuthor::className(), ['journal_id' => 'id']);
    }*/
    
    public function getAuthors()
    {
         return $this->hasMany(Author::className(), ['id' => 'author_id'])
            ->viaTable('journal_author', ['journal_id' => 'id']);
    }
    
    public function listAuthors(){
        foreach($this->authors as $item){
            $str.=$item['surname'].' '.$item['name'].', ';
        }
        $str = trim($str, ', ');
        return $str;
    }
}