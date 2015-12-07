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

});

/* ��������� ����� ��������� � ������������� */
$app->get("/book/:id/", function ($id) use ($app, $db) {

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
