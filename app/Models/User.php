<?php
namespace App\Models;

use App\Core\Database;

/**
 * User Model
 */
class User
{
    public static function findByEmail(string $email): ?array
    {
        return Database::fetchOne(
            "SELECT u.*, r.title as role_title, r.slug as role_slug 
             FROM users u 
             JOIN roles r ON u.role_id = r.id 
             WHERE u.email = :email AND u.deleted_at IS NULL",
            ['email' => $email]
        );
    }

    public static function findById(int $id): ?array
    {
        return Database::fetchOne(
            "SELECT u.*, r.title as role_title, r.slug as role_slug 
             FROM users u 
             JOIN roles r ON u.role_id = r.id 
             WHERE u.id = :id AND u.deleted_at IS NULL",
            ['id' => $id]
        );
    }

    public static function create(array $data): int
    {
        return Database::insert('users', $data);
    }

    public static function update(int $id, array $data): int
    {
        return Database::update('users', $data, 'id = :id', ['id' => $id]);
    }

    public static function getAll(): array
    {
        return Database::fetchAll(
            "SELECT u.*, r.title as role_title 
             FROM users u 
             JOIN roles r ON u.role_id = r.id 
             WHERE u.deleted_at IS NULL 
             ORDER BY u.id DESC"
        );
    }
}
