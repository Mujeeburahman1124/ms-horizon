<?php
namespace App\Models;

use App\Core\Database;
use Throwable;

class Candidate
{
    public static function create(array $data): int
    {
        try {
            return Database::insert('candidates', [
                'user_id'             => $data['user_id'] ?? 1,
                'full_name'           => $data['full_name'] ?? '',
                'email'               => $data['email'] ?? '',
                'phone'               => $data['phone'] ?? '',
                'nationality'         => $data['nationality'] ?? 'UAE Resident',
                'experience_years'    => (int)($data['experience_years'] ?? 0),
                'current_title'       => $data['current_title'] ?? '',
                'cv_path'             => $data['resume_path'] ?? $data['cv_path'] ?? '',
                'passport_path'       => $data['passport_path'] ?? null,
                'certificates_json'   => isset($data['certificates']) ? json_encode($data['certificates']) : null,
                'is_contact_unlocked' => (int)($data['is_contact_unlocked'] ?? 0),
                'status'              => $data['status'] ?? 'Active'
            ]);
        } catch (Throwable $e) {
            return 0;
        }
    }

    public static function findById(int $id): ?array
    {
        try {
            return Database::fetchOne("SELECT * FROM candidates WHERE id = :id", ['id' => $id]);
        } catch (Throwable $e) {
            return null;
        }
    }

    public static function findByUserId(int $userId): ?array
    {
        try {
            return Database::fetchOne("SELECT * FROM candidates WHERE user_id = :uid", ['uid' => $userId]);
        } catch (Throwable $e) {
            return null;
        }
    }

    public static function getAll(): array
    {
        try {
            return Database::fetchAll("SELECT * FROM candidates ORDER BY id DESC");
        } catch (Throwable $e) {
            return [];
        }
    }
}
