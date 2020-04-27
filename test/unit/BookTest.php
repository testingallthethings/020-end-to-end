<?php

namespace Braddle;

use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testJsonSerialize()
    {
        $book = new Book(
          "234567891",
          "Writing all the tests",
          "Mark Bradley",
          9999
        );

        $expectedJson = [
            "isbn" => "234567891",
            "title" => "Writing all the tests",
            "author" => "Mark Bradley",
            "number_of_pages" => 9999,
        ];

        $actualJson = $book->jsonSerialize();

        $this->assertEquals($expectedJson, $actualJson);
    }


}