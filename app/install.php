#!/usr/bin/env php
<?php


    require_once __DIR__ . "/core/bootstrap.php";

    use App\Traits\DatabaseSetupTrait;

    class DatabaseInstaller {
        use DatabaseSetupTrait;
    }

    $installer = new DatabaseInstaller();
    $installer->installDatabase();
