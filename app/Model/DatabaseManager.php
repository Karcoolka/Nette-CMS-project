<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Context;
use Nette\SmartObject;

/**
 * Database Manager
 */
abstract class DatabaseManager {

    use SmartObject;

    /** @var Context */
    protected $database;

    public function __construct(Context $database) {
        $this->database = $database;
    }
}