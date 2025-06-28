<?php

include "src/conn.php";
$connection = conn();

function ListSheet($id_book){
    global $connection;
    $list = [];

    $id_book = $connection->real_escape_string($id_book);
    $query = $connection->query("SELECT * FROM sheets WHERE id_book = $id_book");

    if ($query) {
        while ($sheet = $query->fetch_assoc()) {
            $list[] = $sheet;
        }
    }

    return $list;
}

function DeleteSheet($id_sheet){
    global $connection;

    $id_sheet = $connection->real_escape_string($id_sheet);
    $query = $connection->query("DELETE FROM sheets WHERE id_sheet = $id_sheet");

    if ($query) {
        return true;
    } else {
        return false;
    }

    $connection->close();
}

function CreateSheet($id_book, $title, $content){
    global $connection;

    $id_book = intval($id_book);
    $title = $connection->real_escape_string($title);
    $content = $connection->real_escape_string($content);

    $is_used = $connection->query("SELECT * FROM sheets WHERE id_book = $id_book AND title = '$title' OR content = '$content'");

    if ($is_used->num_rows > 0) {
        UpdateSheet($is_used->fetch_assoc()['id_sheet'], $id_book, $title, $content);
        return true;
    } else {
        $query = $connection->query("INSERT INTO sheets (id_book, title, content) VALUES ($id_book, '$title', '$content')");

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    $connection->close();
}

function UpdateSheet($id_sheet, $id_book, $title, $content){
    global $connection;

    $id_sheet = $connection->real_escape_string($id_sheet);
    $id_book = $connection->real_escape_string($id_book);
    $title = $connection->real_escape_string($title);
    $content = $connection->real_escape_string($content);

    $query = $connection->query("UPDATE sheets SET id_book = $id_book, title = '$title', content = '$content' WHERE id_sheet = $id_sheet");

    if ($query) {
        return true;
    } else {
        return false;
    }

    $connection->close();
}
