<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Chatbot;

class ChatbotTest extends TestCase
{
    private $chatbot;
    
    protected function setUp(): void
    {
        $apiKey = 'AIzaSyBW1cOKo7xcuVoEWWtYGzpRlBOMoKJEY7c';
        $this->chatbot = new Chatbot($apiKey);
    }

    public function testChatbotResponse()
    {
        $response = $this->chatbot->getReply("Halo");
        $this->assertNotEmpty($response);
        $this->assertIsString($response);
    }

    public function testSystemInformationResponse()
    {
        $response = $this->chatbot->getReply("Bagaimana cara login ke sistem?");
        $this->assertStringContainsString("login", strtolower($response));
    }

    public function testEmptyInput()
    {
        $response = $this->chatbot->getReply("");
        $this->assertEquals("Tidak ada respon.", $response);
    }
}