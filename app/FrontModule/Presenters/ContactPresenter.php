<?php

namespace App\FrontModule\Presenters;

use Nette\Application\UI\Form;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Mail\SendException;
use Nette\Utils\ArrayHash;
use App\Model\ContactManager;
use Tomaj\Form\Renderer\BootstrapVerticalRenderer;

/**
 * @package App\FrontModule\Presenters
 */
class ContactPresenter extends BaseFrontPresenter {

    /** @var string */
    private $contactEmail;

    /** @var IMailer */
    private $mailer;

    /** @var ContactManager */
    private $contactManager;

    /**
     * @param string  $contactEmail
     * @param IMailer $mailer
     * @param ContactManager $contactManager
     */
    public function __construct(string $contactEmail, IMailer $mailer, ContactManager $contactManager) {
        parent::__construct();
        $this->contactEmail = $contactEmail;
        $this->mailer = $mailer;
        $this->contactManager = $contactManager;
    }

    public function renderDefault() {
        $this->template->contact = $this->contactManager->getContact();
    }

    protected function createComponentContactForm(): Form {
        $form = new Form;
        $form->setRenderer(new BootstrapVerticalRenderer);
        $form->getElementPrototype()->setAttribute('novalidate', true);
        $form->addEmail('email', 'Vaše emailová adresa')->setRequired();
        $form->addText('y', 'Zadejte aktuální rok')->setOmitted()->setRequired()
            ->addRule(Form::EQUAL, 'Chybně vyplněný antispam.', date("Y"));
        $form->addTextArea('message', 'Zpráva')->setRequired()
            ->addRule(Form::MIN_LENGTH, 'Zpráva musí mít minimálně %d znaků.', 10);
        $form->addSubmit('send', 'Odeslat');

        $form->onSuccess[] = function (Form $form, ArrayHash $values) {
            try {
                $mail = new Message;
                $mail->setFrom($values->email)
                    ->addTo($this->contactEmail)
                    ->setSubject('Email z webu')
                    ->setBody($values->message);
                $this->mailer->send($mail);
                $this->flashMessage('Email byl úspěšně odeslán.');
                $this->redirect('this');
            } catch (SendException $e) {
                $this->flashMessage('Email se nepodařilo odeslat.');
            }
        };

        return $form;
    }

}