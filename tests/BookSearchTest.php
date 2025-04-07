<?php
use PHPUnit\Framework\TestCase;
use App\BookSearch;

class BookSearchTest extends TestCase {
    public function testSearchReturnsArrayWithItemsKey() {
        $apiKey = 'https://www.googleapis.com/books/v1/volumes?q='; // Ganti dengan key asli
        $bookSearch = new BookSearch($apiKey);

        $result = $bookSearch->search("PHP");

        $this->assertIsArray($result);
        $this->assertArrayHasKey("items", $result);
    }
}
