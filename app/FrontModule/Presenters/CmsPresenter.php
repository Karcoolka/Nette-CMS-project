<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

/**
 * @package App\FrontModule\Presenters
 */
class CmsPresenter extends BaseFrontPresenter {

    public function renderDefault(string $url) {
        try {
            $this->template->page = $this->cmsManager->getCmsPage($url);
        } catch (\Exception $e) {
            $this->error('Stránka nebyla nalezena.');
        }
    }
}