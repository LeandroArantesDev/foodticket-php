<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define('BASE_URL', '/SISTEMA-FICHAS/');
} else {
    define('BASE_URL', '/');
}
