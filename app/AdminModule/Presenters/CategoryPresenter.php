<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Model\CategoryManager;
use Nette\Application\AbortException;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use Tomaj\Form\Renderer\BootstrapVerticalRenderer;

/**
 * @package App\AdminModule\Presenters
 */
class CategoryPresenter extends BaseAdminPresenter {

    /** @var CategoryManager */
    private $categoryManager;

    /**
     * @param CategoryManager $categoryManager
     */
    public function __construct(CategoryManager $categoryManager) {
        parent::__construct();
        $this->categoryManager = $categoryManager;
    }

    public function renderList() {
        $this->template->categories = $this->categoryManager->getCategories();
    }

    public function actionRemove(string $url = null) {
        $this->categoryManager->removeCategory($url);
        $this->flashMessage('Kategorie byla úspěšně odstraněna.');
        $this->redirect('Category:list');
    }

    public function actionEditor(string $url = null) {
        if ($url) {
            if (!($category = $this->categoryManager->getCategory($url))) {
                $this->flashMessage('Kategorie nebyla nalezena.');
            } else {
                $this['editorForm']->setDefaults($category);
            }
        }
    }
    protected function createComponentEditorForm(): Form {
        $form = new Form;
        $form->setRenderer(new BootstrapVerticalRenderer);
        $form->addHidden('id');
        $form->addText('name', 'Název')->setRequired();
        $form->addText('url', 'URL')->setRequired();
        $form->addSubmit('save', 'Uložit kategorii');
        $form->onSuccess[] = function (Form $form, Array $values) {
            try {
                $this->categoryManager->saveCategory($values);
                $this->flashMessage('Kategorie byla úspěšně uložena.');
                $this->redirect('Category:list');
            } catch (UniqueConstraintViolationException $e) {
                $this->flashMessage('Kategorie s touto URL adresou již existuje.');
            }
        };
        return $form;
    }
}