<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $year
 * @property string|null $isbn
 * @property string|null $photo
 * @property string|null $updated_at
 * @property string|null $created_at
 *
 * @property BookAuthors[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{
    public $authors;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'integer'],
            [['updated_at', 'created_at', 'authors'], 'safe'],
            [['name', 'isbn', 'photo'], 'string', 'max' => 255],
            [['name', 'year'], 'required', 'on' => ['create']],
            [['authors'], 'required', 'on' => ['create', 'update']],
            [['isbn', 'photo'], 'file', 'extensions' => ['jpg', 'png'], 'skipOnEmpty' => true, 'on' => ['create', 'update']],
        ];
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['bookAuthors'] = 'bookAuthors';
        return $fields;
    }

    public static function getYears()
    {
        $result = [];
        for ($i = date('Y'); $i >= 1900; $i--) {
            $result[$i] = $i;
        }
        return $result;
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'value' => function () {
                    return gmdate("Y-m-d H:i:s");
                },
            ],
        ];
    }

    public function beforeSave($insert)
    {
        $dir = Yii::getAlias('@app/web/data');

        $this->photo = UploadedFile::getInstance($this, 'photo');
        if ($this->photo) {
            $filename = str_replace('.', '', uniqid('', true));
            $this->photo->saveAs($dir . '/' . $filename . '.' . $this->photo->extension);
            $this->photo = $filename . '.' . $this->photo->extension;
        } else {
            $this->photo = $this->getOldAttribute('photo');
        }

        $this->isbn = UploadedFile::getInstance($this, 'isbn');
        if ($this->isbn) {
            $filename = str_replace('.', '', uniqid('', true));
            $this->isbn->saveAs($dir . '/' . $filename . '.' . $this->isbn->extension);
            $this->isbn = $filename . '.' . $this->isbn->extension;
        } else {
            $this->isbn = $this->getOldAttribute('isbn');
        }
        return parent::beforeSave($insert);
    }

    public function getISBNImg($options = ['width' => 60, 'height' => null])
    {
        $dir = Yii::getAlias('@app/web/data') . '/' . $this->isbn;
        if (is_file($dir)) {
            return Html::img('/data/' . $this->isbn, $options);
        }
        return null;
    }

    public function getPhotoImg($options = ['width' => 60, 'height' => null])
    {
        $dir = Yii::getAlias('@app/web/data') . '/' . $this->photo;
        if (is_file($dir)) {
            return Html::img('/data/' . $this->photo, $options);
        }
        return null;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $authors = $this->authors;
        if ($authors && is_array($authors) && count($authors)) {
            $this->unlinkAll('bookAuthors', true);
            foreach ($authors as $id) {
                $author = Author::findOne($id);
                if ($author) {
                    $this->link('bookAuthors', $author);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'year' => 'Year',
            'isbn' => 'Isbn',
            'photo' => 'Photo',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getBookAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('book_authors', ['book_id' => 'id']);
    }
}