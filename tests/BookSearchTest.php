<?php
use PHPUnit\Framework\TestCase;

class BookSearchTest extends TestCase {
    public function testSearchBooks() {
        require 'api_books.php';
        $result = searchBooks("PHP");
        $this->assertArrayHasKey('items', $result);
    }
}
?>
