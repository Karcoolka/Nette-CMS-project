<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use Nette;


final class HomepagePresenter extends BaseFrontPresenter {

    public function renderDefault(): void {
        $this->template->article = $this->cmsManager->getHomePage();
    }

}
