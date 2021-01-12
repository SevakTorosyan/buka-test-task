<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "catalogs".
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $parent_id
 *
 * @property Catalog $parent
 * @property Catalog[] $catalogs
 */
class Catalog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'catalogs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'depth'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [
                ['parent_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Catalog::class,
                'targetAttribute' => ['parent_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'parent_id' => 'Parent ID',
            'depth' => 'Depth',
        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Catalog::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[Catalogs]].
     *
     * @return ActiveQuery
     */
    public function getCatalogs()
    {
        return $this->hasMany(Catalog::class, ['parent_id' => 'id']);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return self
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    /**
     * @param int|null $parent_id
     * @return self
     */
    public function setParentId(?int $parent_id): self
    {
        $this->parent_id = $parent_id;

        return $this;
    }

    /**
     * Рекурсивно высчитывает уровень каталога
     *
     * @return int
     */
    public function getDepth(): int
    {
        /** @var Catalog $parent */
        $parent = $this->getParent()->one();

        if (!$parent) {
            return 0;
        } else {
            $parentDepth = $parent->getDepth();
            return ++$parentDepth;
        }
    }

    /**
     * @return array
     */
    public function hydrate(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'depth' => $this->getDepth(),
        ];
    }
}
