<?php

namespace libroDeApuntes\Model;

class Book extends Sheet {
    public $id_book;
    public $title;
    public $created_at;
    public $updated_at;
    public $sheets;
    
    public function __construct($id_book, $title, $created_at, $updated_at) {
        $this->id_book = $id_book;
        $this->title = $title;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->sheets = [];
    }

    public function addSheet(Sheet $sheet) {
        $this->sheets[] = $sheet;
    }
}
