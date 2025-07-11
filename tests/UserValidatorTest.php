<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/UserValidator.php';

class UserValidatorTest extends TestCase {
    public function testValidEmail() {
        $this->assertTrue(UserValidator::isValidEmail('test@example.com'));
        $this->assertFalse(UserValidator::isValidEmail('invalid-email'));
    }
}
