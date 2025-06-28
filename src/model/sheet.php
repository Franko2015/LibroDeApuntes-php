<?php

namespace libroDeApuntes\Model;

class Sheet {
    public $id_sheet;
    public $book; // Referencia al libro
    public $title;
    public $content;
    public $created_at;
    public $updated_at;

    public function __construct($id_sheet, Book $book, $title, $content, $created_at, $updated_at) {
        $this->id_sheet = $id_sheet;
        $this->book = $book;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}