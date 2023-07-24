<?php

declare(strict_types=1);

namespace App\Model;

/**
 * @package App\Model
 */
class CommentManager extends DatabaseManager {

    /* Konstanty pro práci s databází. */
    const
        TABLE_NAME = 'comments',
        COLUMN_ID = 'id';

    public function getComments(int $article_id): array {
        return $this->database->table(self::TABLE_NAME)
            ->where('article_id = ?', $article_id)
            ->order('date_add ASC')
            ->fetchAll();
    }

    public function getAllComments(): array {
        return $this->database->table(self::TABLE_NAME)
            ->order('date_add ASC')
            ->fetchAll();
    }

    public function addComment(int $article_id, array $values) {
        $values['article_id'] = $article_id;
        return $this->database->table(self::TABLE_NAME)
            ->insert($values);
    }

    public function deleteComment(int $id) {
        $this->database->table(self::TABLE_NAME)
            ->where('id = ?', $id)
            ->delete();
    }

    public function getCommentCount() {
        return $this->database->table(self::TABLE_NAME)->count('*');
    }
}