<?php
namespace App\Models;

use App\Core\Database;

class Offer
{
    public static function getActive(): array
    {
        // Auto-archive expired offers
        Database::query(
            "UPDATE offers SET is_archived = 1 WHERE expiry_date < CURDATE() AND is_archived = 0"
        );

        return Database::fetchAll(
            "SELECT o.*, d.title as division_name, d.slug as division_slug
             FROM offers o 
             JOIN divisions d ON o.division_id = d.id
             WHERE o.is_archived = 0 AND o.start_date <= CURDATE()
             ORDER BY o.id DESC"
        );
    }

    public static function getArchived(): array
    {
        return Database::fetchAll(
            "SELECT o.*, d.title as division_name 
             FROM offers o 
             JOIN divisions d ON o.division_id = d.id
             WHERE o.is_archived = 1 
             ORDER BY o.expiry_date DESC"
        );
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetchOne(
            "SELECT o.*, d.title as division_name 
             FROM offers o 
             JOIN divisions d ON o.division_id = d.id
             WHERE o.slug = :slug",
            ['slug' => $slug]
        );
    }

    public static function create(array $data): int
    {
        return Database::insert('offers', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('offers', $data, 'id = :id', ['id' => $id]);
    }

    public static function delete(int $id): int
    {
        return Database::delete('offers', 'id = :id', ['id' => $id]);
    }
}
