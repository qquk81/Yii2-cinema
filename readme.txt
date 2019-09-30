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
