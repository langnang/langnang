-- Modules\Toolkit\Database\Seeders\ToolkitDatabaseSeeder
-- 2025-08-12 17:19:44

select * from `_metas` where `slug` = 'toolkit' and `_metas`.`deleted_at` is null limit 1

insert into `_metas` (`created_at`, `ico`, `name`, `order`, `parent`, `slug`, `status`, `type`, `updated_at`) values ('2025-08-12 17:19:44', 'fas fa-tachometer-alt', '加密类', 1, 19, 'toolkit:encryption', 'public', 'category', '2025-08-12 17:19:44'), ('2025-08-12 17:19:44', 'fas fa-tachometer-alt', '解密类', 2, 19, 'toolkit:decryption', 'public', 'category', '2025-08-12 17:19:44') on duplicate key update `slug` = values(`slug`), `ico` = values(`ico`), `name` = values(`name`), `type` = values(`type`), `status` = values(`status`), `order` = values(`order`), `parent` = values(`parent`), `updated_at` = values(`updated_at`)
