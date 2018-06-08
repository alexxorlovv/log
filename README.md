# Logger
##Как все работает
основано на PSR 3 спецификации


##Примеры
Инициализация
```php
use Sweetkit\Foundation\Log\Logger;
use Sweetkit\Foundation\Log\\Adapters\LoggerText;

$logger = new Logger(new LoggerText('path/file.txt'));
```
Возможные адаптеры
```php
use Sweetkit\Foundation\Log\Logger;
use Sweetkit\Foundation\Log\Adapters\{LoggerText,LoggerJson,LoggerRuntime,LoggerSerialize};

$loggerText = new Logger(new LoggerText('path/file.txt'));
$loggerSerialize = new Logger(new LoggerSerialize('path/file.serialize'));
$loggerJson = new Logger(new LoggerJson'path/file.json');
$loggerRuntime = new Logger(new LoggerRuntime);
```

####Уровни логирования
- alert
- info
- emergency
- critical
- error
- warning
- notice
- debug

Использование
```php
$logger->alert("My message {text}",["text" => "AlertMessage"]);
```



Варианты вывода
```php
use Sweetkit\Foundation\Log\Logger;
use Sweetkit\Foundation\Log\Adapters\LoggerText;
use Sweetkit\Foundation\Log\Viewers\{LoggerViewHtml,LoggerViewConsole};

$logger = new Logger(new LoggerText('path/file.txt'));
$logger->print(new LoggerViewHtml);
$logger->print(new LoggerViewConsole);
```
####Фильтрация логов
- date_in - Начальная дата
- date_out - Конечная дата
- limit - Количество доступных результатов
- level - Необходимый Уровень лога

```php
use Sweetkit\Foundation\Log\Logger;
use Sweetkit\Foundation\Log\Adapters\LoggerText;
use Sweetkit\Foundation\Log\Viewers\LoggerViewHtml;

$logger = new Logger(new LoggerText('path/file.txt'));
$filters = [
            'date_in' => '2012-12-12 12:12:12', 
            'date_out' => '2013-09-12 01:12:12', 
            'level' => 'alert', 
            'limit' => 5];
$logger->print(new LoggerViewHtml,$filters);
```

###Как можно применить на практике

```php
use Sweetkit\Foundation\Log\{Logger, LoggerAware,LoggerAdapter};
use Sweetkit\Foundation\Log\Adapters\LoggerText;
use Sweetkit\Foundation\Log\Viewers\LoggerViewHtml;

class SqlLogger extends Logger
{

}

class SqlManager extends LoggerAware
{
    public function __construct(LoggerAdapter $adapter)
    {
        $this->setLogger(new SqlLogger($adapter));
    }

    public function getLogger() : Logger
    {
        return $this->logger;
    }
}

$manager = new SqlManager(new LoggerText);
```



##На будущее 
- Возможность разделять файлы на подфайлы при достжении определенного веса
- Разделать файлы по датам создания тем самым сокращая вес файлов и ускоряя доступ к ним
- Сделать возможным функцию только для записи - тем самым ускоряя скорость работы
- Добавить в фильтры возможность поиска текста в сообщении
- Добавить в фильтры возможность получения лимита как с конца так и с начала полученного результата
- Добавить адаптеры для работы с Redis и Базами дааных
- Написать unit tests
- Документировать код