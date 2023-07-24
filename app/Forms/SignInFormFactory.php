<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model;
use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;

final class SignInFormFactory
{
    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    /** @var User */
    private $user;


    public function __construct(FormFactory $factory, User $user)
    {
        $this->factory = $factory;
        $this->user = $user;
    }


    public function create(callable $onSuccess): Form
    {
        $form = $this->factory->create();
        $form->addEmail('email', 'Email:')
            ->setRequired('Zadejte prosím Váš email.');
        $form->addPassword('password', 'Password:')
            ->setRequired('Zadejte prosím Vaše heslo.');
        $form->addSubmit('send', 'Přihlásit');
        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {
            try {
                $this->user->login($values->email, $values->password);
            } catch (Nette\Security\AuthenticationException $e) {
                $form->addError('Je nutné zadat správné přihlašovací údaje.');
                return;
            }
            $onSuccess();
        };

        return $form;
    }
}