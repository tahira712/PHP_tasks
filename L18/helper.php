<?php

function post($key){
    return $_POST[$key] ?? null;
}
