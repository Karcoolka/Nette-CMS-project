<?php

declare(strict_types=1);

namespace App\Components;

use App\Model\CommentManager;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class Comments extends Control {

    /** @var CommentManager */
    private $commentManager;

    /** @var int */
    private $article_id;

    /** @var array */
    private $comments = null;

    public function __construct(CommentManager $commentManager, int $article_id) {

        $this->commentManager = $commentManager;
        $this->article_id = $article_id;
    }

    public function getComments(): array {
        if ($this->comments === null) {
            $this->comments = $this->commentManager->getComments($this->article_id);
        }
        return $this->comments;
    }

    public function handleDelete(int $id) {
        $this->commentManager->deleteComment($id);
        $this->flashMessage('Komentář byl odstraněn.', 'success');
        $this->getPresenter()->postGet('this');
        $this->getPresenter()->sendPayload();
    }

    public function render() {
        $this->template->comments = $this->getComments();
        $this->template->setFile(__DIR__ . '/templates/comments.latte');
        $this->template->render();
    }

    public function doAddComment(Form $form, array $values) {
        $comment = $this->commentManager->addComment($this->article_id, $values);
        $this->flashMessage('Komentář byl přidán.', 'success');
        $this->getPresenter()->postGet('this');
        $this->redrawControl('list');
        $this->comments = [$comment];
    }

    public function createComponentCommentForm(): Form {
        $form = new Form();
        $form->addText('author_name', 'Vaše jméno:')
            ->setRequired(true);
        $form->addEmail('author_email', 'Váš email:')
            ->setRequired(true);
        $form->addTextArea('content', 'Komentář:')
            ->setRequired(true);
        $form->addSubmit('add', 'Přidat');
        $form->onSuccess[] = [$this, 'doAddComment'];
        return $form;
    }
}