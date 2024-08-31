<?php
class Users extends Modal {
    public function __construct($mysqli) {
        parent::__construct($mysqli, 'users');
    }
}
