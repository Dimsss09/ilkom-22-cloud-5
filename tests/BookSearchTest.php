<?php
use PHPUnit\Framework\TestCase;

class BookSearchTest extends TestCase {
    public function testSearchBooks() {
        require 'books-api.php';
        $result = searchBooks("PHP");
        $this->assertArrayHasKey('items', $result);
    }
}
?>
