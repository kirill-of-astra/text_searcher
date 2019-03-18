<?php

use kirillGru\textSearcher\fileSources\LocalFile;

class LocalFileTest extends \Codeception\Test\Unit
{
    const INPUT_DIR = __DIR__ . '/input';

    // tests
    public function testMimeType()
    {
        $file_list = [
            'phpfile.php' => ['text/x-php', 'text/php', 'application/php'],
            'sample_image.jpg' => 'image/jpeg'
        ];
        foreach ($file_list as $file_name => $expected_mime_type) {
            $file = new LocalFile(self::INPUT_DIR . '/' . $file_name);
            $mime_type = $file->getMimeType();
            if (is_array($expected_mime_type)) {
                $this->assertTrue(in_array($mime_type, $expected_mime_type), "The MIME-type '$mime_type' is not expected for $file_name'");
            } else {
                $this->assertEquals($expected_mime_type, $mime_type, "The MIME-type '$mime_type' is not expected for $file_name'");
            }
        }
    }

    public function testReadLine()
    {
        $file_name = "text_file.txt";
        $file = new LocalFile(self::INPUT_DIR . '/' . $file_name);

        try {
            $file->openFile();
            $expected_lines = [
                "Lorem ipsum\r\n",
                "Dolor sit amet\r\n",
                "-------------\r\n",
                "WOW!\r\n",
                ""
            ];

            $line_num = 0;
            do {
                $line = $file->readLine();
                $this->assertEquals($expected_lines[$line_num], $line, "Incorrect reading file $file_name on line $line_num");
                $line_num++;
            } while ($line !== null);
            $file->closeFile();
        } catch (\Exception $e) {
            //  close file descriptor anyway and rethrown exception
            $file->closeFile();
            throw $e;
        }
    }

    public function testReadContent()
    {
        $expected = "lorem ipsum\r\ndolor sit amet";
        $file_name = "text_file2.txt";
        $file = new LocalFile(self::INPUT_DIR . '/' . $file_name);
        try {
            $file->openFile();
            $content = $file->getContent();
            $this->assertEquals($expected, $content, "Expected content of file $file_name is different");
            $file->closeFile();
        } catch (\Exception $e) {
            $file->closeFile();
            throw $e;
        }
    }

    public function testGetSize()
    {
        $file_name = "text_file.txt";
        $file = new LocalFile(self::INPUT_DIR . '/' . $file_name);
        $expected = 50; //bytes
        $size = $file->getSize();
        $this->assertEquals($expected, $size);
    }
}