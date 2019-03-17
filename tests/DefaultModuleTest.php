<?php

use kirillGru\textSearcher\modules\DefaultModule;

class DefaultModuleTest extends \Codeception\Test\Unit
{
    private $queries;
    private $file_data;

    protected function _before()
    {
        $this->queries = [
            // query_string , expected: false or [line, column]
            ['Hello world!', [2,1]],
            ['Orange not is fruit', false]
        ];
        $this->file_data = "Something\r\nHello world!\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aperiam architecto, atque blanditiis consectetur corporis dolor esse excepturi harum ipsa laudantium, molestiae numquam omnis repellendus totam! Assumenda officiis sequi veniam.";

    }

    // tests
    public function testSearch()
    {
        $fileSource = $this->mockFileSource();
        $module = new DefaultModule();
        foreach ($this->queries as $query) {
            $expected = $query[1];
            if(is_array($expected)){
                $result = $module->search($fileSource, $query[0]);
                $this->assertArrayHasKey('line', $result, 'empty result');
                $this->assertArrayHasKey('column', $result, 'empty result');
                $this->assertEquals($expected[0],  $result['line'], 'Incorrect line matches '.json_encode($query));
                $this->assertEquals($expected[1], $result['column'], 'Incorrect column matches '.json_encode($query));
            }else{
                $this->assertEquals($query[1], $module->search($fileSource, $query[0]));
            }
        }
    }

    private function mockFileSource()
    {
        return $this->make('\\kirillGru\\textSearcher\\fileSources\\LocalFile', [
            'readLine' => function () {
                static $line = -1;
                $lines = explode("\r\n", $this->file_data);
                if($line+1 >= count($lines)){
                    return null;
                }else{
                    $line++;
                    return $lines[$line];
                }
            }
        ]);
    }
}