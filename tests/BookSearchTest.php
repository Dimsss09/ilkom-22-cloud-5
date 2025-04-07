<?php
use PHPUnit\Framework\TestCase;

class BookSearchTest extends TestCase {
    public function testSearchBooks() {
        // Go up one directory from tests folder and include books-api.php
        require __DIR__ . '/../books-api.php';
        
        $result = searchBooks("PHP");
        $this->assertArrayHasKey('items', $result);
    }
}
?>
