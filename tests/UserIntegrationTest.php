<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/User.php';

class UserIntegrationTest extends TestCase {
    protected function setUp(): void {
        User::deleteAll();
    }

    public function testCreateUser() {
        $result = User::create('Alice', 'alice@example.com');
        $this->assertTrue($result);

        $users = User::all();
        $this->assertCount(1, $users);
        $this->assertEquals('Alice', $users[0]['name']);
    }
}
