-- InfinityFree/shared hosting: create and select your database in the hosting panel
-- or phpMyAdmin before importing this file. This migration never creates or drops a database.

CREATE TABLE IF NOT EXISTS contact_messages (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL,
  subject VARCHAR(150) NOT NULL,
  budget VARCHAR(100) NULL,
  message TEXT NOT NULL,
  status ENUM('new','read','archived') NOT NULL DEFAULT 'new',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_contact_messages_status_created (status, created_at),
  KEY idx_contact_messages_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
