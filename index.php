<?php

spl_autoload_register(function ($className) {

  if ('Syste/' . $className . '.php') {
    require_once 'Syste/' . $className . '.php';
  } else if ('Controllers/' . $className . '.php') {
    require_once 'Controllers/' . $className . '.php';
  } else if ('Models/' . $className . '.php') {
    require_once 'Models/' . $className . '.php';
  }

});