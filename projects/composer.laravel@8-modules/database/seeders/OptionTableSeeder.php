<?php

namespace Database\Seeders;

use App\Illuminate\Database\Seeder;

class OptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Models\Option::upsert(
            [
                // Global
                [
                    'name' => 'global.type',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'module' => ['value' => 'module', 'name' => 'Module', 'nameCn' => '模块',],
                        'tag' => ['value' => 'tag', 'name' => 'Tag', 'nameCn' => '标签',],
                        'category' => ['value' => 'category', 'name' => 'Category', 'nameCn' => '分类',],
                        'branch' => ['value' => 'branch', 'name' => 'Branch', 'nameCn' => '分支',],
                        'group' => ['value' => 'group', 'name' => 'Group', 'nameCn' => '分组',],
                        'collection' => ['value' => 'collection', 'name' => 'Collection', 'nameCn' => '专辑',],
                        'compilation' => ['value' => 'compilation', 'name' => 'Compilation', 'nameCn' => '合集',],
                        'template' => ['value' => 'template', 'name' => 'Template', 'nameCn' => '模板',],
                        'draft-template' => ['value' => 'template-draft', 'auth' => true, 'name' => 'Template(Draft)', 'nameCn' => '模板（草稿）',],
                        'post' => ['value' => 'post', 'name' => 'Post', 'nameCn' => '文章',],
                        'draft-post' => ['value' => 'post-draft', 'auth' => true, 'name' => 'Post(Draft)', 'nameCn' => '文章（草稿）',],
                        'page' => ['value' => 'page', 'name' => 'Page', 'nameCn' => '页面',],
                        'draft-page' => ['value' => 'page-draft', 'auth' => true, 'name' => 'Page(Draft)', 'nameCn' => '页面（草稿）',],
                        'archive' => ['value' => 'archive', 'auth' => true, 'name' => 'Archive', 'nameCn' => '归档',],
                    ])
                ],
                [
                    'name' => 'global.status',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'public' => ['value' => 'public', 'name' => 'Public', 'nameCn' => '公开',],
                        'publish' => ['value' => 'publish', 'name' => 'Publish', 'nameCn' => '发行',],
                        'protect' => ['value' => 'protect', 'auth' => true, 'name' => 'Protect', 'nameCn' => '受限',],
                        'private' => ['value' => 'private', 'auth' => true, 'name' => 'Private', 'nameCn' => '私有',],
                    ])
                ],
                // Meta
                [
                    'name' => 'meta.type',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'module' => ['value' => 'module', 'name' => 'Module', 'nameCn' => '模块',],
                        'tag' => ['value' => 'tag', 'name' => 'Tag', 'nameCn' => '标签',],
                        'category' => ['value' => 'category', 'name' => 'Category', 'nameCn' => '分类',],
                        'branch' => ['value' => 'branch', 'name' => 'Branch', 'nameCn' => '分支',],
                        'group' => ['value' => 'group', 'name' => 'Group', 'nameCn' => '分组',],
                        'collection' => ['value' => 'collection', 'name' => 'Collection', 'nameCn' => '专辑',],
                        'compilation' => ['value' => 'compilation', 'name' => 'Compilation', 'nameCn' => '合集',],
                        'menu' => ['value' => 'menu', "staus" => "private", 'name' => 'Menu', 'nameCn' => '菜单',],
                        'nav' => ['value' => 'nav', "staus" => "private", 'name' => 'Nav', 'nameCn' => '导航',],
                        // 'site' => ['value' => 'site', "staus" => "private", 'name' => 'Site', 'nameCn' => '网址',],
                        // 'file' => ['value' => 'file', "staus" => "private", 'name' => 'File', 'nameCn' => '文件',],

                    ])
                ],
                [
                    'name' => 'meta.status',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'public' => ['value' => 'public', 'name' => 'Public', 'nameCn' => '公开',],
                        'publish' => ['value' => 'publish', 'name' => 'Publish', 'nameCn' => '发行',],
                        'protect' => ['value' => 'protect', 'auth' => true, 'name' => 'Protect', 'nameCn' => '受限',],
                        'private' => ['value' => 'private', 'auth' => true, 'name' => 'Private', 'nameCn' => '私有',],
                    ])
                ],
                [
                    'name' => 'meta.model',
                    'type' => 'text',
                    'user_id' => 0,
                    'value' => \App\Models\Meta::class
                ],
                [
                    'name' => 'meta.create-item.validate',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'name' => 'required|string',
                        'type' => 'required|string',
                        'status' => 'required|string',
                    ])
                ],
                // Content
                [
                    'name' => 'content.type',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'template' => ['value' => 'template', 'name' => 'Template', 'nameCn' => '模板',],
                        'draft-template' => ['value' => 'template-draft', 'auth' => true, 'name' => 'Template(Draft)', 'nameCn' => '模板（草稿）',],
                        'post' => ['value' => 'post', 'name' => 'Post', 'nameCn' => '文章',],
                        'draft-post' => ['value' => 'post-draft', 'auth' => true, 'name' => 'Post(Draft)', 'nameCn' => '文章（草稿）',],
                        'page' => ['value' => 'page', 'name' => 'Page', 'nameCn' => '页面',],
                        'draft-page' => ['value' => 'page-draft', 'auth' => true, 'name' => 'Page(Draft)', 'nameCn' => '页面（草稿）',],
                    ])
                ],
                [
                    'name' => 'content.status',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'public' => ['value' => 'public', 'name' => 'Public', 'nameCn' => '公开',],
                        'publish' => ['value' => 'publish', 'name' => 'Publish', 'nameCn' => '发行',],
                        'protect' => ['value' => 'protect', 'auth' => true, 'name' => 'Protect', 'nameCn' => '受限',],
                        'private' => ['value' => 'private', 'auth' => true, 'name' => 'Private', 'nameCn' => '私有',],
                    ])
                ],
                [
                    'name' => 'content.model',
                    'type' => 'text',
                    'user_id' => 0,
                    'value' => \App\Models\Content::class
                ],
                // Link
                [
                    'name' => 'link.type',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'site' => ['value' => 'site', 'name' => 'Site', 'nameCn' => '站点',],
                        'draft-site' => ['value' => 'site-draft', 'auth' => true, 'name' => 'Site(Draft)', 'nameCn' => '站点（草稿）',],
                        'file' => ['value' => 'file', 'name' => 'File', 'nameCn' => '文件',],
                        'draft-file' => ['value' => 'file-draft', 'auth' => true, 'name' => 'File(Draft)', 'nameCn' => '文件（草稿）',],
                        'torrent' => ['value' => 'torrent', 'name' => 'Torrent', 'nameCn' => '磁力',],
                        'draft-torrent' => ['value' => 'torrent-draft', 'auth' => true, 'name' => 'Torrent(Draft)', 'nameCn' => '磁力（草稿）',],
                    ])
                ],
                [
                    'name' => 'link.status',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'public' => ['value' => 'public', 'name' => 'Public', 'nameCn' => '公开',],
                        'publish' => ['value' => 'publish', 'name' => 'Publish', 'nameCn' => '发行',],
                        'protect' => ['value' => 'protect', 'auth' => true, 'name' => 'Protect', 'nameCn' => '受限',],
                        'private' => ['value' => 'private', 'auth' => true, 'name' => 'Private', 'nameCn' => '私有',],
                    ])
                ],
                [
                    'name' => 'link.model',
                    'type' => 'text',
                    'user_id' => 0,
                    'value' => \App\Models\Link::class
                ],
                [
                    'name' => 'file.type',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'json' => ['value' => 'json', 'name' => 'json', 'nameCn' => 'json',],
                        'md' => ['value' => 'md', 'name' => 'md', 'nameCn' => 'md',],
                        'txt' => ['value' => 'txt', 'name' => 'txt', 'nameCn' => 'txt',],
                        'xlsx' => ['value' => 'xlsx', 'name' => 'xlsx', 'nameCn' => 'xlsx',],
                        'xls' => ['value' => 'xls', 'name' => 'xls', 'nameCn' => 'xls',],
                        'csv' => ['value' => 'csv', 'name' => 'csv', 'nameCn' => 'csv',],
                    ])
                ],
                [
                    'name' => 'file.mime_type',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'application/json' => ['value' => 'application/json', 'name' => 'json', 'nameCn' => 'json',],
                        'application/octet-stream' => ['value' => 'application/octet-stream', 'name' => 'md', 'nameCn' => 'md',],
                        'text/plain' => ['value' => 'text/plain', 'name' => 'txt', 'nameCn' => 'txt',],
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => ['value' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'name' => 'xlsx', 'nameCn' => 'xlsx',],
                        'application/vnd.ms-excel' => ['value' => 'application/vnd.ms-excel', 'name' => 'xls', 'nameCn' => 'xls',],
                        'text/csv' => ['value' => 'text/csv', 'name' => 'csv', 'nameCn' => 'csv',],
                    ])
                ],
                [
                    'name' => 'file.status',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'public' => ['value' => 'public', 'name' => 'Public', 'nameCn' => '公开',],
                        'publish' => ['value' => 'publish', 'name' => 'Publish', 'nameCn' => '发行',],
                        'protect' => ['value' => 'protect', 'auth' => true, 'name' => 'Protect', 'nameCn' => '受限',],
                        'private' => ['value' => 'private', 'auth' => true, 'name' => 'Private', 'nameCn' => '私有',],
                    ])
                ],
                [
                    'name' => 'file.model',
                    'type' => 'text',
                    'user_id' => 0,
                    'value' => \App\Models\File::class
                ],
                [
                    'name' => 'field.type',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'text' => ['value' => 'text', 'name' => 'text', 'nameCn' => '文本',],
                        'object' => ['value' => 'object', 'name' => 'object', 'nameCn' => '对象',],
                    ])
                ],
                [
                    'name' => 'user.role',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([
                        'admin' => ['value' => 'text', 'name' => 'text', 'nameCn' => '文本',],
                        'user_id' => ['value' => 'text', 'name' => 'text', 'nameCn' => '文本',],
                        'guest' => ['value' => 'text', 'name' => 'text', 'nameCn' => '文本',],
                    ])
                ],
                [
                    'name' => 'user.permission',
                    'type' => 'object',
                    'user_id' => 0,
                    'value' => serialize([])
                ],
            ],
            ['name', 'user_id'],
            ['value']
        );
    }
}
