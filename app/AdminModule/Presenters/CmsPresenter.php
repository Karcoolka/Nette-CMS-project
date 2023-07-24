<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Model\CmsManager;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use Tomaj\Form\Renderer\BootstrapVerticalRenderer;

class CmsPresenter extends BaseAdminPresenter {

    /** @var CmsManager Model */
    private $cmsManager;


    /**
     * @param CmsManager $cmsManager
     */
    public function __construct(CmsManager $cmsManager) {
        parent::__construct();
        $this->cmsManager = $cmsManager;
    }

    public function renderList() {
        $this->template->pages = $this->cmsManager->getAllCmsPages();
    }

    public function actionRemove(string $url = null) {
        $this->cmsManager->removeCmsPage($url);
        $this->flashMessage('Stránka byla úspěšně odstraněna.');
        $this->redirect('Cms:list');
    }

    public function actionEditor(string $url = null) {
        if ($url) {
            if (!($page = $this->cmsManager->getCmsPage($url))) {
                $this->flashMessage('Stránka nebyla nalezena.');
            } else {
                $this['editorForm']->setDefaults($page);
            }
        }
    }

    protected function createComponentEditorForm(): Form {
        $form = new Form;
        $form->setRenderer(new BootstrapVerticalRenderer);
        $form->addHidden('id');
        $form->addText('title', 'Titulek')->setRequired();
        $form->addText('url', 'URL')->setRequired();
        $form->addUpload('picture', 'Obrázek:')
            ->setRequired(false)
            ->addCondition(Form::FILLED)
            ->addRule(Form::IMAGE);
        $form->addTextArea('description', 'Obsah');
        $form->addSubmit('save', 'Uložit článek');
        $form->onSuccess[] = function (Form $form, Array $values) {
            try {
                $this->cmsManager->saveCmsPage($values);
                $this->flashMessage('Stránka byla úspěšně uložena.');
                $this->redirect('Cms:list');
            } catch (UniqueConstraintViolationException $e) {
                $this->flashMessage('Stránka s touto URL adresou již existuje.');
            }
        };
        return $form;
    }
}