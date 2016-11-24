<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 2016-10-11
 * Time: 14:40
 */

@include "config.php";

$dbc = @mysqli_connect(__SERVER_NAME__,__USER_NAME__,__PASS__,__DB_NAME__) or DIE (
    'MySQL Error: <br/>' . mysqli_connect_error()
);
mysqli_set_charset($dbc, 'utf8');

