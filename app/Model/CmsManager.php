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
class CmsManager extends DatabaseManager {

    /** @var string */
    private $picturePath;

    const
        TABLE_NAME = 'cms',
        COLUMN_ID = 'id',
        COLUMN_ON_HOMEPAGE = 'on_homepage',
        COLUMN_URL = 'url';

    public function __construct(Context $database, string $picturePath) {
        parent::__construct($database);
        $this->picturePath = $picturePath;
    }

    public function getCmsPage(string $url, string $columns = NULL): IRow {
        return $this->database->table(self::TABLE_NAME)
            ->select($columns ? $columns : '*')
            ->where(self::COLUMN_URL, $url)
            ->fetch();
    }

    public function getCmsPageFromId(int $id, string $columns = NULL): IRow {
        return $this->database->table(self::TABLE_NAME)
            ->select($columns ? $columns : '*')
            ->where(self::COLUMN_ID, $id)
            ->fetch();
    }

    public function getAllCmsPages(): Selection {
        return $this->database->table(self::TABLE_NAME)->order(self::COLUMN_ID . ' DESC');
    }

    public function getMenuItems(): Selection {
        return $this->database->table(self::TABLE_NAME)->where(self::COLUMN_ON_HOMEPAGE, 0)->order(self::COLUMN_ID . ' ASC');
    }

    public function getHomePage(): ActiveRow {
        return $this->database->table(self::TABLE_NAME)->where(self::COLUMN_ON_HOMEPAGE, 1)->fetch();
    }
    public function saveCmsPage(array $values): IRow {
        //parse values
        $cmsData = [
            'title' => $values['title'],
            'url' => $values['url'],
            'description' => $values['description'],
        ];
        //control if img upload
        if (!empty($values['picture']) && $values['picture']->isOk()) {
            $cmsData['has_picture'] = true;
        }

        //conroll if url with same id does not exists

        if (!empty($values['id'])) {
            $cms = $this->database->table('cms')
                ->wherePrimary($values['id']);

            $cms->update($cmsData);
            $cms = $cms->fetch();
        } else {
            $cms = $this->database->table('cms')
                ->insert($cmsData);
        }

        if (!empty($values['picture']) && $values['picture']->isOk()) {
            /** @var Image $im */
            $im = $values['picture']->toImage();
            $im->resize(900, 400, Image::EXACT);
            $im->save(sprintf('%s/%d.jpg', $this->picturePath, $cms->id), 90, Image::JPEG);
        }

        return $cms;
    }

    public function removeCmsPage(string $url) {
        $this->database->table(self::TABLE_NAME)->where(self::COLUMN_URL, $url)->delete();
    }
}