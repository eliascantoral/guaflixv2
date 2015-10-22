<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function get_participantdata($participantid, $data = false){
    $title = get_the_title($participantid);
    $content_post = get_post($participantid);
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);    
    $title = $content_post->post_title;
    $url = wp_get_attachment_url( get_post_thumbnail_id($participantid) );
    $link = get_permalink($participantid);
    return array($participantid, $title, $content,$url,$link);
}