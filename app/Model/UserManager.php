<?php
declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Security\Passwords;
use Nette\Database\Table\Selection;
use Nette\SmartObject;
use Nette\Security\IAuthenticator;
use Nette\Security\IIdentity;
use Nette\Security\Identity;
use Nette\Security\AuthenticationException;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Database\Context;

/**
 * Users management.
 */
final class UserManager implements IAuthenticator
{
    use SmartObject;

    private const
        TABLE_NAME = 'user',
        COLUMN_ID = 'id',
        COLUMN_PASSWORD_HASH = 'password',
        COLUMN_EMAIL = 'email',
        COLUMN_FIRSTNAME = 'firstname',
        COLUMN_LASTNAME = 'lastname',
        COLUMN_ROLE = 'role';

    /** @var Context */
    private $database;

    /** @var Passwords */
    private $passwords;

    public function __construct(Context $database, Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }

    /**
     * Performs an authentication.
     * @throws AuthenticationException
     */
    public function authenticate(array $credentials): IIdentity
    {
        [$email, $password] = $credentials;
        $row = $this->database->table(self::TABLE_NAME)
            ->where(self::COLUMN_EMAIL, $email)
            ->fetch();

        if (!$row) {
            throw new AuthenticationException('Zadali jste nesprávný email.', self::IDENTITY_NOT_FOUND);
        } elseif (!$this->passwords->verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
            throw new AuthenticationException('Vaše heslo není správné.', self::INVALID_CREDENTIAL);
        } elseif ($this->passwords->needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
            $row->update([
                self::COLUMN_PASSWORD_HASH => $this->passwords->hash($password),
            ]);
        }

        $arr = $row->toArray();
        unset($arr[self::COLUMN_PASSWORD_HASH]);
        return new Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
    }
}