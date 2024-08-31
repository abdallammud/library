<?php
class Books extends Modal {
    public function __construct() {
        parent::__construct('books', 'book_id');
    }
}
$Books = new Books();