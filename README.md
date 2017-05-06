# RYLAI
PHP's document support library. Provide an application to build a complete and full featured document generator app. 
### Installation
```bash
composer require haodt/rylai
```
### Usage
- Take a look at `rylai.php`, that script is used to build this library document
- Clone the script to your project, change paths to suit your need. Each path represent a repository.
- Path's key should be your root namespace defined in composer.json . Take a look at this library's composer.json file for detail
```
require_once __DIR__ . "/vendor/autoload.php";

use Rylai\Analyzers\Docblock;
use Rylai\Runner\AbstractRunner;
use Rylai\Stores\Local;

class Runner extends AbstractRunner
{
    public function getPaths()
    {
        return [
            "Rylai" => __DIR__ . "/src/",
        ];
    }

    public function getAnalyzers()
    {
        return [
            new Docblock,
        ];
    }

    public function getStores()
    {
        return [
            new Local([
                "views" => __DIR__ . "/views",
                "store" => __DIR__ . "/docs",
            ]),
        ];
    }
}

$runner = new Runner();
$runner->run();
```
### How it works?
- Analyzer will read file and provide back a report for that file
- Store will collect reports then save it to backend (html,nosql,sql ... )
### Notes
- In order to parse your files, rylai must be able to load all files and execute it. This will result in extension class might have some issues
- This library is tested under psr 4 standard files and folders, if you use other coding standards, please write more tests for it.
- There are issues with resolving Types alias like Rylai\Fixtures\Items\Courier for Courier inside tags so you have to compare it with namespaces aliases
- Constants wont be able to have docblock so far
- Local store will use key - value paths as in key is your root namespace, in this project case you can see composer.json load Rylai\\ point to src folder
### Todo
- Elasticstore will be implemeted in near future
- Replace `?` mark as value of properties because there is some issues around private properties that blocking parser to read the value
- Add few more analyzers

### Development
- Run tests
```bash
php vendor/phpunit/phpunit/phpunit
```
- Pull requests are welcome :)
