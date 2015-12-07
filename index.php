<?php
/* ����������� ��������� */
require 'NotORM.php';
require 'Slim\Slim.php';

/* ������������� �������������� */
\Slim\Slim::registerAutoloader();

/* ������������� ���������� � �� ��� NotORM */
$pdo = new PDO('sqlite:rest.db');
$db = new NotORM($pdo);

/* �������� ���������� ������ Slim */
$app = new \Slim\Slim();

/**
*	�������: ����������� �������, ����� � ��������
*/


/* �������� ��-��������� */
$app->get("/", function() {
    echo "Something by default";
});

/* ������� ���� ���� */
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

/* ��������� ����� ��������� � ������������� */
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

/* ���������� ����� ����� */
$app->post("/book/", function () use($app, $db) {

});

/* ��������� ������ ����� ��������� � ������������� */
$app->put("/book/:id/", function ($id) use ($app, $db) {

});

/* �������� ����� ��������� � ������������� */
$app->delete("/book/:id/", function ($id) use($app, $db) {

});

/* ������ ���������� */
