<?php

class Python_Model
{
    protected static $db = null;

    public function __construct()
    {
        if (self::$db === null) {
            self::$db = Bootstrap::getMysql();
        }

        return self::$db;
    }

    public function getList($page, $pageSize)
    {
        $offsets = self::$db->offsets($page, $pageSize);
        $limit   = self::$db->limit($page, $pageSize);

        return self::$db->query("select * from `be_python` limit {$limit} offset {$offsets}")->fetchall();
    }

    public function getDetail($id)
    {
        return self::$db->query("select * from `be_python` where id={$id}")->fetch();
    }

    public function create(string $title, string $content, string $tags, string $refers)
    {
        $create = self::$db->createTime();
        $modify = self::$db->modifyTime();

        return self::$db->query("insert into `be_python` (`title`, `content`, `modify_at`, `create_at`, `tags`, `refers`) values ('" . $title . "','" . $content . "', '" . $modify . "', '" . $create . "', '" . $tags . "', '" . $refers . "')");
    }

    public function modify(int $id, string $title, string $content, string $tags, string $refers)
    {
        if (empty($id)) {
            return false;
        }
        $modify = self::$db->modifyTime();

        return self::$db->query("update be_python set `title`='{$title}', `content`='{$content}', `tags`='{$tags}', `refers`='{$refers}', `modify_at`='{$modify}' where `id`={$id}");
    }

    public function delete(int $id)
    {
        if (empty($id)) {
            return false;
        }
        return self::$db->query("delete from be_python where `id`={$id}");
    }

}