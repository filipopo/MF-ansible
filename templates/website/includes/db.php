<?php
  $db = new SQLite3('donations.db');
  $db->exec(<<<EOT
    CREATE TABLE IF NOT EXISTS donations (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      time TEXT,
      day INT,
      month INT,
      year INT,
      name TEXT,
      message TEXT,
      amount_sent REAL,
      amount_received REAL
    )
    EOT
  );
?>