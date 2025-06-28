<?php

require "src/conn.php";
$connection = conn();

function bookList() {
    global $connection;
    $list = [];

    $query = $connection->query("SELECT * FROM books");

    if ($query) {
        while ($book = $query->fetch_assoc()) {
            $list[] = $book;
        }
    }

    return $list;

    $connection->close();
}

function CreateBook($title) {
    global $connection;

    $title = $connection->real_escape_string($title);
    $query = $connection->query("INSERT INTO books (title) VALUES ('$title')");

    if ($query) {
        return true;
    } else {
        return false;
    }

    $connection->close();
}

function DeleteBook($id_book) {
    global $connection;

    $id_book = $connection->real_escape_string($id_book);
    $query = $connection->query("DELETE FROM books WHERE id_book = $id_book");

    if ($query) {
        return true;
    } else {
        return false;
    }

    $connection->close();
}

function UpdateBook($id_book, $title) {
    global $connection;

    $id_book = $connection->real_escape_string($id_book);
    $title = $connection->real_escape_string($title);
    $query = $connection->query("UPDATE books SET title = '$title' WHERE id_book = $id_book");

    if ($query) {
        return true;
    } else {
        return false;
    }

    $connection->close();
}