<?php
/* Ïîäêëş÷åíèå áèáëèîòåê */
require 'NotORM.php';
require 'Slim\Slim.php';

/* Èíèöèàëèçàöèÿ àâòîçàãğóç÷èêà */
\Slim\Slim::registerAutoloader();

/* Èíèöèàëèçàöèÿ ñîåäèíåíèÿ ñ ÁÄ äëÿ NotORM */
$pdo = new PDO('sqlite:rest.db');
$db = new NotORM($pdo);

/* Ñîçäàíèå ıêçåìïëÿğà êëàññà Slim */
$app = new \Slim\Slim();

/**
*	Ğîóòèíã: îïğåäåëåíèå ìåòîäîâ, ïóòåé è äåéñòâèé
*/


/* Äåéñòâèå ïî-óìîë÷àíèş */
$app->get("/", function() {
    echo "Something by default";
});

/* Âûáîğêà âñåõ êíèã */
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

/* Ïîëó÷åíèå êíèãè èñïîëüçóÿ å¸ èäåíòèôèêàòîğ */
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

/* Äîáàâëåíèå íîâîé êíèãè */
$app->post("/book/", function () use($app, $db) {
	$res = $app->response();
	$res["Content-Type"] = "application/json";
	$book = $app->books->insert($book);
	echo json_encode(["id" => $result["id"]]);
});

/* Èçìåíåíèå äàííûõ êíèãè èñïîëüçóÿ å¸ èäåíòèôèêàòîğ */
$app->put("/book/:id/", function ($id) use ($app, $db) {
	$res = $app->response();
	$res["Content-Type"] = "application/json";
	$book = $db->books()->where("id", $id);
	if ($book->fetch()){
		$post = $app->request()->put();
		$result = $book->update($post);
		echo json_encode([
			"status" => 1,
			"message" => "Book updated successfully"
			]);
	} else {
		echo json_encode([
			"status" => 0,
			"message" => "Book id $id does not exist"]);
	}
});

/* Óäàëåíèå êíèãè èñïîëüçóÿ å¸ èäåíòèôèêàòîğ */
$app->delete("/book/:id/", function ($id) use($app, $db) {
	$res = $app->response();
	$res["Content-Type"] = "application/json";
	$book = $db->books()->where("id", $id);
	if ($book->fetch()){
		$result = $book->delete();
		echo json_encode([
			"status" => 1,
			"message" => "Book deleted successfully"]);
	} else {
		echo json_encode([
			"status" => 0,
			"message" => "Book id $id does not exist"]);
	}
});

/* Çàïóñê ïğèëîæåíèÿ */
$app->run();