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
        try {
            $searcher->openFile(self::INPUT_DIR . '/' . $file_name);
            $result = $searcher->search($query);
            $this->assertNotNull($result, "String $query not found in file $file_name");
            $this->assertEquals($expected_line,  $result['line'], 'Incorrect line matches '.json_encode($query));
            $this->assertEquals($expected_column, $result['column'], 'Incorrect column matches '.json_encode($query));
            $searcher->closeFile();
        } catch (\Exception $e) {
            $searcher->closeFile();
            throw $e;
        }
    }

    public function testCharsetAndCase()
    {
        $expected_line = 2;
        $expected_column = 25;
        $query = "Превратился В Страшное Насекомое";
        $file_name = "wincp.txt";
        $searcher = new TextSearcher();
        try {
            $searcher->openFile(self::INPUT_DIR . '/' . $file_name);
            $result = $searcher->search($query);
            $this->assertNotNull($result, "String $query not found in file $file_name");
            $this->assertEquals($expected_line,  $result['line'], 'Incorrect line matches '.json_encode($query));
            $this->assertEquals($expected_column, $result['column'], 'Incorrect column matches '.json_encode($query));
        } catch (\Exception $e) {
            $searcher->closeFile();
            throw $e;
        }
    }



}