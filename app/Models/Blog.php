<?php
namespace App\Models;

use App\Core\Database;

class Blog
{
    public static function getPublished(int $limit = 10, int $offset = 0): array
    {
        return Database::fetchAll(
            "SELECT * FROM blogs WHERE is_published = 1 ORDER BY published_at DESC LIMIT :limit OFFSET :offset",
            ['limit' => $limit, 'offset' => $offset]
        );
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetchOne(
            "SELECT * FROM blogs WHERE slug = :slug AND is_published = 1",
            ['slug' => $slug]
        );
    }

    public static function countPublished(): int
    {
        $row = Database::fetchOne("SELECT COUNT(*) as total FROM blogs WHERE is_published = 1");
        return (int)($row['total'] ?? 0);
    }

    public static function create(array $data): int
    {
        return Database::insert('blogs', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('blogs', $data, 'id = :id', ['id' => $id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('blogs', 'id = :id', ['id' => $id]);
    }
}
