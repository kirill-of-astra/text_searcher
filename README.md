#Text searcher

Библиотека для поиска текстовой строки в файле.

Подключение библиотеки
```
require();
```

Пример использования:

Откроем наш файл с помщью TextSearcher
```$file_path = __DIR__.'/my_file.txt'
$searcher = new TextSearcher();
$searcher->openFile($file_path);
```
Найдем в нем строчку *Hello world*
```
$result = $searcher->search("Hello world");
if($result !== false){
    echo "line: ". $result->line ;
    echo ", column: ". $result->column;
}
// пример вывода 
// line: 14, column: 3
```











