<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


class HomePresenter extends Nette\Application\UI\Presenter
{
    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function renderDefault(): void
    {
        $this->template->articles = $this->database->table('article')
            ->order('date_add DESC')
            ->limit(5);
    }
}
