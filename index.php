<?php
/* Подключение библиотек */
require 'NotORM.php';
require 'Slim\Slim.php';

/* Инициализация автозагрузчика */
\Slim\Slim::registerAutoloader();

/* Инициализация соединения с БД для NotORM */
$pdo = new PDO('sqlite:rest.db');
$db = new NotORM($pdo);

/* Создание экземпляра класса Slim */
$app = new \Slim\Slim();

/**
*	Роутинг: определение методов, путей и действий
*/


/* Действие по-умолчанию */
$app->get("/", function() {
    echo "Something by default";
});

/* Выборка всех книг */
$app->get("/books/", function() use ($app, $db) {
foreach ($db->books() as $book) {
	$books[] = [
	"id" => $book["id"],
"title" => $book["title"],
"author" => $book["author"],
"summary" => $book["summary"]
	];
}
$res = $app->response();
$res["Content-Type"] = "application/json";
echo json_encode($books);
});

/* Получение книги используя её идентификатор */
$app->get("/book/:id/", function ($id) use ($app, $db) {
$res = $app->response();
$res["Content-Type"] = "application/json";
$book = $db->books()->where("id", $id);
if ($data = $book->fetch()) {
	echo json_encode([
		"id" => $data["id"],
		"title" => $data["title"],
		"author" => $data["author"],
		"summary" => $data["summary"]
		]);
} else {
	echo json_encode([
		"staus" => 1,
		"message" => "Book ID $id does not exist"
		]);
}
});

/* Добавление новой книги */
$app->post("/book/", function () use($app, $db) {

});

/* Изменение данных книги используя её идентификатор */
$app->put("/book/:id/", function ($id) use ($app, $db) {

});

/* Удаление книги используя её идентификатор */
$app->delete("/book/:id/", function ($id) use($app, $db) {

});

/* Запуск приложения */
