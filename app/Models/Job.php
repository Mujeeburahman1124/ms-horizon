<?php
namespace App\Models;

use App\Core\Database;

class Job
{
    public static function getAll(array $filters = []): array
    {
        $sql = "SELECT j.*, e.company_name, e.industry 
                FROM jobs j 
                LEFT JOIN employers e ON j.employer_id = e.id 
                WHERE j.is_active = 1";
        $params = [];

        if (!empty($filters['category'])) {
            $sql .= " AND j.category = :category";
            $params['category'] = $filters['category'];
        }
        if (!empty($filters['location'])) {
            $sql .= " AND j.location LIKE :location";
            $params['location'] = '%' . $filters['location'] . '%';
        }
        if (!empty($filters['type'])) {
            $sql .= " AND j.job_type = :type";
            $params['type'] = $filters['type'];
        }

        $sql .= " ORDER BY j.id DESC";
        return Database::fetchAll($sql, $params);
    }

    public static function getFeatured(int $limit = 6): array
    {
        return Database::fetchAll(
            "SELECT * FROM jobs WHERE is_active = 1 ORDER BY id DESC LIMIT :limit",
            ['limit' => $limit]
        );
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetchOne(
            "SELECT j.*, e.company_name, e.industry 
             FROM jobs j 
             LEFT JOIN employers e ON j.employer_id = e.id 
             WHERE j.slug = :slug AND j.is_active = 1",
            ['slug' => $slug]
        );
    }

    public static function create(array $data): int
    {
        return Database::insert('jobs', $data);
    }

    public static function apply(int $jobId, int $candidateId, string $coverLetter = ''): int
    {
        // Check for duplicate application
        $existing = Database::fetchOne(
            "SELECT id FROM job_applications WHERE job_id = :jid AND candidate_id = :cid",
            ['jid' => $jobId, 'cid' => $candidateId]
        );
        if ($existing) return 0;

        return Database::insert('job_applications', [
            'job_id' => $jobId,
            'candidate_id' => $candidateId,
            'cover_letter' => $coverLetter,
            'status' => 'Applied'
        ]);
    }

    public static function getApplicationsByCandidate(int $candidateId): array
    {
        return Database::fetchAll(
            "SELECT ja.*, j.title as job_title, j.location, j.job_type 
             FROM job_applications ja 
             JOIN jobs j ON ja.job_id = j.id 
             WHERE ja.candidate_id = :cid 
             ORDER BY ja.applied_at DESC",
            ['cid' => $candidateId]
        );
    }
}
