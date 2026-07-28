<?php
namespace App\Models;

use App\Core\Database;

class Reservation
{
    public static function create(array $data): int
    {
        return Database::insert('reservations', $data);
    }

    public static function findByRef(string $ref): ?array
    {
        return Database::fetchOne(
            "SELECT r.*, u.name as staff_name 
             FROM reservations r 
             LEFT JOIN users u ON r.assigned_staff_id = u.id 
             WHERE r.booking_ref = :ref",
            ['ref' => $ref]
        );
    }

    public static function getAll(): array
    {
        return Database::fetchAll(
            "SELECT r.*, u.name as staff_name 
             FROM reservations r 
             LEFT JOIN users u ON r.assigned_staff_id = u.id 
             ORDER BY r.id DESC"
        );
    }

    public static function updateStatus(int $id, string $status, ?int $staffId = null): int
    {
        $data = ['status' => $status];
        if ($staffId !== null) {
            $data['assigned_staff_id'] = $staffId;
        }
        return Database::update('reservations', $data, 'id = :id', ['id' => $id]);
    }
}
