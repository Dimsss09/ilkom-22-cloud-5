<?php
use PHPUnit\Framework\TestCase;

class BookSearchTest extends TestCase {
    public function testSearchBooks() {
        require __DIR__ . 'C:\xampp\htdocs\PerpustakaanBrida\ilkom-22-cloud-5\books-api.php'; // Adjust the path accordingly
        $result = searchBooks("PHP");
        $this->assertArrayHasKey('items', $result);
    }
}
?>
