-- Database\Seeders\ModuleDatabaseSeeder
-- 2025-07-13 21:28:32

select * from `_metas` where `slug` = 'module:toolkit' limit 1

insert into `_metas` (`created_at`, `ico`, `name`, `order`, `parent`, `slug`, `status`, `type`, `updated_at`) values ('2025-07-13 21:28:32', 'fas fa-tachometer-alt', '加密类', 1, 25, 'toolkit:encryption', 'public', 'category', '2025-07-13 21:28:32'), ('2025-07-13 21:28:32', 'fas fa-tachometer-alt', '解密类', 2, 25, 'toolkit:decryption', 'public', 'category', '2025-07-13 21:28:32') on duplicate key update `slug` = values(`slug`), `ico` = values(`ico`), `name` = values(`name`), `type` = values(`type`), `status` = values(`status`), `order` = values(`order`), `parent` = values(`parent`), `updated_at` = values(`updated_at`)
