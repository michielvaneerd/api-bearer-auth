<?php

function api_bearer_auth_migrate() {

  global $wpdb;

  $tableName = $wpdb->base_prefix . 'user_tokens';
  $charsetCollate = $wpdb->get_charset_collate();

  $migrations = [
    '1' => "CREATE TABLE $tableName (
      id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      user_id int(11) UNSIGNED NOT NULL,
      access_token varchar(255) NOT NULL,
      access_token_valid datetime NOT NULL,
      refresh_token varchar(255) NOT NULL,
      refresh_token_valid datetime NOT NULL,
      PRIMARY KEY  (id),
      UNIQUE KEY key_user_id_token (user_id)
    ) $charsetCollate;",
    '20181228' => "ALTER TABLE $tableName
      DROP COLUMN refresh_token_valid;"
  ];

  $currentVersion = get_option('api_bearer_auth_activated', '0');

  foreach ($migrations as $version => $sql) {
    if ($version > $currentVersion) {
      $wpdb->query($sql);
    }
  }

};