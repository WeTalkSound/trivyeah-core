<?php

return [
    'driver' => config("database.connections.system.driver"),
    'host' => config("database.connections.system.host"),
    'port' => config("database.connections.system.port"),
    'unix_socket' => config("database.connections.system.unix_socket"),
    'charset' => config("database.connections.system.charset"),
    'collation' => config("database.connections.system.collation"),
    'prefix' => config("database.connections.system.prefix"),
    'strict' => config("database.connections.system.strict"),
    'engine' => config("database.connections.system.engine"),
];