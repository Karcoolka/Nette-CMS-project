<?php

declare(strict_types=1);


namespace App\AdminModule\Presenters;


use Nette;

final class DashboardPresenter extends Nette\Application\UI\Presenter
{
    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function renderDefault(): void
    {
        $this->template->text = "Dashboard";
    }
}