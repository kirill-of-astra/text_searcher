# Text searcher

Библиотека для поиска текстовой строки в файле.

### Подключение библиотеки

Скачайте библиотеку и поместите в произвольную директорию, как указано ниже:

-- text_searcher/

-- ваш_файл.php


Подключите библиотеку:
```
require('text_searcher/vendor/autoload.php');
```

Передите в директорию text_searcher и выполните

```
composer install
```

## Пример использования:

Откроем текстовый файл с помощью TextSearcher
```
$file_path = __DIR__.'/my_file.txt'
$searcher = new TextSearcher();
$searcher->openFile($file_path);
```
Найдем в нем строчку *Hello world*
```
$result = $searcher->search("Hello world");
if($result !== false){
    echo "line: ". $result['line'];
    echo ", column: ". $result['column'];
}
// пример вывода 
// line: 14, column: 3
```

Закроем файл.
```
$searcher->closeFile();
```


## Requirements
php 7.2

php extensions:
*    fileinfo

