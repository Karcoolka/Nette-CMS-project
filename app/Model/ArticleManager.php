<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\IRow;
use Nette\Database\Table\Selection;
use Nette\Database\Context;
use Nette\Utils\Image;

/**
 * @package App\Model
 */
class ArticleManager extends DatabaseManager {

    /** @var string */
    private $picturePath;
    const
        TABLE_NAME = 'article',
        COLUMN_ID = 'id',
        COLUMN_ON_HOMEPAGE = 'on_homepage',
        COLUMN_URL = 'url';

    public function __construct(Context $database, string $picturePath) {
        parent::__construct($database);
        $this->picturePath = $picturePath;
    }

    public function getArticle(string $url, string $columns = NULL): IRow {
        return $this->database->table(self::TABLE_NAME)
            ->select($columns ? $columns : '*')
            ->where(self::COLUMN_URL, $url)
            ->fetch();
    }

    public function getArticleFromId(int $id, string $columns = NULL): IRow {
        return $this->database->table(self::TABLE_NAME)
            ->select($columns ? $columns : '*')
            ->where(self::COLUMN_ID, $id)
            ->fetch();
    }

    public function getArticles(array $parameters): Selection {
        $articles = $this->database->table(self::TABLE_NAME);

        if (!empty($parameters['category_id']))
            $articles->where(':' . self::TABLE_NAME . '_' . CategoryManager::TABLE_NAME .
                '.' . CategoryManager::TABLE_NAME .
                '.' . CategoryManager::COLUMN_ID,
                $parameters['category_id']
            );

        return $articles;
    }

    public function getAllArticles(): Selection {
        return $this->database->table(self::TABLE_NAME)->order(self::COLUMN_ID . ' DESC');
    }

    public function saveArticle(array $values): IRow {
        $articleData = [
            'title' => $values['title'],
            'url' => $values['url'],
            'short_description' => $values['short_description'],
            'description' => $values['description'],
        ];
        if (!empty($values['picture']) && $values['picture']->isOk()) {
            $articleData['has_picture'] = true;
        }

        if (!empty($values['id'])) {
            $articleCategoryData = [
                'article_id' => $values['id'],
                'category_id' => $values['categories'],
            ];
            $article = $this->database->table('article')
                ->wherePrimary($values['id']);

            $article->update($articleData);
            $article = $article->fetch();

            $this->database->table('article_category')
                ->where('article_id = ?', $article->id)
                ->delete();
        } else {

            $article = $this->database->table('article')
                ->insert($articleData);

            $article_id = $article->id;
            $articleCategoryData = [
                'article_id' => $article_id,
                'category_id' => $values['categories'],
            ];
        }

        if (!empty($values['picture']) && $values['picture']->isOk()) {
            /** @var Image $im */
            $im = $values['picture']->toImage();
            $im->resize(900, 400, Image::EXACT);
            $im->save(sprintf('%s/%d.jpg', $this->picturePath, $article->id), 90, Image::JPEG);
        }

        if (!empty($values['categories'])) {
            $this->database->table('article_category')->insert($articleCategoryData);
        }

        return $article;
    }

    public function removeArticle(string $url) {
        $this->database->table(self::TABLE_NAME)->where(self::COLUMN_URL, $url)->delete();
    }
    public function getArticlesCount() {
        return $this->database->table(self::TABLE_NAME)->count('*');
    }
}