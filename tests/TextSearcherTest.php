<?php

use kirillGru\textSearcher\TextSearcher;

class TextSearcherTest extends \Codeception\Test\Unit
{
    const INPUT_DIR = __DIR__ . '/input';

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testDefaultSearchInLocalFile()
    {
        $expected_line = 3;
        $expected_column = 1;
        $query = "Hello world!";
        $file_name = "search_me.txt";
        $searcher = new TextSearcher();
        $searcher->openFile(self::INPUT_DIR.'/'.$file_name);
        $result = $searcher->search($query);
        $this->assertNotNull($result, "String $query not found in file $file_name");
    }


}