<?php
namespace App\Models;

use App\Core\Database;

class BusinessLead
{
    public static function create(array $data): int
    {
        return Database::insert('business_leads', $data);
    }

    public static function getAll(): array
    {
        return Database::fetchAll(
            "SELECT * FROM business_leads ORDER BY id DESC"
        );
    }

    public static function findById(int $id): ?array
    {
        return Database::fetchOne(
            "SELECT * FROM business_leads WHERE id = :id",
            ['id' => $id]
        );
    }

    public static function updateStatus(int $id, string $status, string $notes = ''): int
    {
        return Database::update('business_leads', [
            'status' => $status,
            'notes' => $notes
        ], 'id = :id', ['id' => $id]);
    }

    public static function countByStatus(string $status): int
    {
        $row = Database::fetchOne(
            "SELECT COUNT(*) as total FROM business_leads WHERE status = :status",
            ['status' => $status]
        );
        return (int)($row['total'] ?? 0);
    }
}
