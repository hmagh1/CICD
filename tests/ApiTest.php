<?php
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase {
    private $baseUrl = 'http://php:8000';
    private $authHeader;

    protected function setUp(): void {
        $credentials = base64_encode('admin:1234');
        $this->authHeader = 'Authorization: Basic ' . $credentials;

        // Clean up users
        $ch = curl_init("{$this->baseUrl}/users");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [$this->authHeader]);
        curl_exec($ch);
        curl_close($ch);
    }

    public function testUserCrudFlow() {
        // Create user
        $data = json_encode(["name" => "Eve", "email" => "eve@example.com"]);
        $ch = curl_init("{$this->baseUrl}/users");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            $this->authHeader
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $this->assertStringContainsString('success', $result);

        // List users
        $ch = curl_init("{$this->baseUrl}/users");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [$this->authHeader]);
        $output = curl_exec($ch);
        curl_close($ch);
        $users = json_decode($output, true);
        $this->assertIsArray($users);
        $this->assertCount(1, $users);
    }
}
