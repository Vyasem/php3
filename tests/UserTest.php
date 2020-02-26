<?php

namespace Tests;
require __DIR__.'/../vendor/autoload.php';
require __DIR__ . '/../protected/boot.php';
require __DIR__ . '/../protected/autoload.php';

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSum(){
        $user = new User();
        $this->assertSame('Иван Иванович Иванов', $user->getName('Иван', 'Иванович', 'Иванов', 'test@test.com'));
        $this->assertSame('Иван Иванов', $user->getName('Иван', '', 'Иванов', 'test@test.com'));
        $this->assertSame('test@test.com', $user->getName('', '', '', 'test@test.com'));
        $this->assertSame('test@test.com', $user->getName('Иван', 'Иванович', '', 'test@test.com'));
        $this->assertSame('test@test.com', $user->getName('', 'Иванович', 'Семенов', 'test@test.com'));
        $this->assertSame('test@test.com', $user->getName('', 'Иванович', '', 'test@test.com'));
    }
}