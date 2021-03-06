<?php

// ***************************************************************************
// Rename this file to params.php and fill the appropriate fileds with your owns!!!
// ***************************************************************************

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    //доменные данные для просмота LDAP
    'domain_auth' => false, // Если планируется LDAP авторизация, установить true
    'domain_group' => 'LDAP Group', //доменная группа доступа. Если domain_auth = true.
    'domain_name' => 'Domain name', //Корневое имя домена. Если domain_auth = true.

    //Общие настройки
    'org_name'      => 'Сокращенное название организации',
    'org_name_full' => 'Полное название организации',
    'org_logo_file' => 'yourLogo.png' // (расширения gif, bmp, jpg или png) файл должен быть в папке web
];
