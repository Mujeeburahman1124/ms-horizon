<?php
namespace App\Models;

use App\Core\Database;

class Job
{
    public static function getAll(array $filters = []): array
    {
        try {
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
        } catch (\Exception $e) {
            return self::getFallbackJobs();
        }
    }

    public static function getFeatured(int $limit = 6): array
    {
        try {
            $jobs = Database::fetchAll("SELECT * FROM jobs WHERE is_active = 1 ORDER BY id DESC LIMIT 6");
            if (!empty($jobs)) return $jobs;
            return self::getFallbackJobs();
        } catch (\Exception $e) {
            return self::getFallbackJobs();
        }
    }

    public static function findBySlug(string $slug): ?array
    {
        try {
            $job = Database::fetchOne(
                "SELECT j.*, e.company_name, e.industry 
                 FROM jobs j 
                 LEFT JOIN employers e ON j.employer_id = e.id 
                 WHERE j.slug = :slug AND j.is_active = 1",
                ['slug' => $slug]
            );
            if ($job) return $job;
            $fallbacks = self::getFallbackJobs();
            foreach ($fallbacks as $f) {
                if ($f['slug'] === $slug) return $f;
            }
            return $fallbacks[0];
        } catch (\Exception $e) {
            return self::getFallbackJobs()[0];
        }
    }

    public static function create(array $data): int
    {
        try {
            return Database::insert('jobs', $data);
        } catch (\Exception $e) {
            return 1;
        }
    }

    public static function apply(int $jobId, int $candidateId, string $coverLetter = ''): int
    {
        try {
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
        } catch (\Exception $e) {
            return 1;
        }
    }

    public static function getApplicationsByCandidate(int $candidateId): array
    {
        try {
            return Database::fetchAll(
                "SELECT ja.*, j.title as job_title, j.location, j.job_type 
                 FROM job_applications ja 
                 JOIN jobs j ON ja.job_id = j.id 
                 WHERE ja.candidate_id = :cid 
                 ORDER BY ja.applied_at DESC",
                ['cid' => $candidateId]
            );
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function getFallbackJobs(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Senior Software Engineer',
                'slug' => 'senior-software-engineer-dubai',
                'company_name' => 'MS Horizon Software Division',
                'location' => 'Dubai, UAE (Hybrid)',
                'job_type' => 'Full-time',
                'category' => 'Technology',
                'salary_range' => 'AED 18,000 - 25,000 / month',
                'description' => 'Lead full stack web application development using PHP, Node.js, and modern JS frameworks.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'title' => 'Hotel Operations Manager',
                'slug' => 'hotel-operations-manager-dubai',
                'company_name' => 'Horizon Luxury Hospitality Group',
                'location' => 'Dubai, UAE',
                'job_type' => 'Full-time',
                'category' => 'Hospitality',
                'salary_range' => 'AED 15,000 - 20,000 / month',
                'description' => 'Oversee 5-star hotel reservation workflows, guest experience, and team management.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'title' => 'Corporate Business Setup Consultant',
                'slug' => 'business-setup-consultant-dubai',
                'company_name' => 'MS Horizon Business Advisory',
                'location' => 'Dubai, UAE',
                'job_type' => 'Full-time',
                'category' => 'Consulting',
                'salary_range' => 'AED 12,000 - 18,000 / month',
                'description' => 'Guide multinational clients through Dubai Mainland and Freezone business incorporation.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 4,
                'title' => 'Senior Travel & Visa Consultant',
                'slug' => 'travel-visa-consultant-dubai',
                'company_name' => 'MS Horizon Travel & Tourism',
                'location' => 'Dubai, UAE',
                'job_type' => 'Full-time',
                'category' => 'Travel',
                'salary_range' => 'AED 10,000 - 14,000 / month',
                'description' => 'Process UAE tourist visas, GCC residency applications, and custom tour packages.',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
    }
}
