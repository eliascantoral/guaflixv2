<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function check_membership($userid){
    return true;
}

function get_userobjectlog($userid, $objectid){
    include_once 'backend/backend.php';
    $backend = new backend();
    return $backend->get_userobjectlog($userid, $objectid);
}
function get_useralldata($userid){
    include_once 'backend/backend.php';
    $backend = new backend();
    return $backend->get_userdata($userid);
}
function unsubscribe_user_object($userid, $objectid){
    include_once 'backend/backend.php';
    $backend = new backend();
    return $backend->unsubscribe_user_object($userid, $objectid);
}