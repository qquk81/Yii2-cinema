//поднимает все докер контейнеры и запустить миграции
make init
docker-compose run --rm app-php-cli php yii migrate up

http://localhost:8080/
http://localhost:8080/admin
http://localhost:8080/cinema/api


//сформировать документацию
docker-compose run --rm app-php-cli php yii doc/build

//ссылка на док
http://localhost:8080/cinema/api/docs/index.html

user - admin
password - 111111

        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=app-mysql;port=3306;dbname=demo-db',
            'username' => 'app',
            'password' => '123',
            'charset' => 'utf8',
        ],
