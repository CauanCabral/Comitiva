<?php
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'index'));

// Páginas estáticas, mas privadas
Router::connect('/estatica/*', array('controller' => 'pages', 'action' => 'display'));

// Páginas estáticas e públicas
Router::connect('/p/*', array('controller' => 'pages', 'action' => 'display'));

// Páginas públicas para divulgação
Router::connect('/divulgacao/:slug', array('controller' => 'events', 'action' => 'view'), array('pass' => array('slug')));

// Páginas ligadas ao PagSeguro
Router::connect('/retorno_pagamento/*', array('controller' => 'payments', 'action' => 'view'), array('pass' => array('slug')));

Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));

Router::connect('/account_create', array('controller' => 'users', 'action' => 'account_create'));
Router::connect('/criar_conta', array('controller' => 'users', 'action' => 'account_create'));

Router::connect('/account_confirm/*', array('controller' => 'users', 'action' => 'account_confirm'));
Router::connect('/confirmar_conta/*', array('controller' => 'users', 'action' => 'account_confirm'));

Router::connect('/recover', array('controller' => 'users', 'action' => 'recover'));
Router::connect('/recuperar_senha', array('controller' => 'users', 'action' => 'recover'));

Router::connect('/profile', array('controller' => 'users', 'action' => 'profile'));
Router::connect('/perfil', array('controller' => 'users', 'action' => 'profile'));

Router::connect('/reset_password/*', array('controller' => 'users', 'action' => 'reset_password'));
Router::connect('/nova_senha/*', array('controller' => 'users', 'action' => 'reset_password'));


Router::connect('/admin', array('controller' => 'users', 'action' => 'profile', 'admin' => true));

Router::connect('/participant', array('controller' => 'users', 'action' => 'profile', 'participant' => true));

Router::connect('/speaker', array('controller' => 'users', 'action' => 'profile', 'speaker' => true));

require CAKE . 'Config' . DS . 'routes.php';