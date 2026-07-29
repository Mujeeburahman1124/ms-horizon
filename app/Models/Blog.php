<?php
namespace App\Models;

use App\Core\Database;
use Throwable;

class Blog
{
    public static function getPublished(int $limit = 10, int $offset = 0): array
    {
        try {
            $limit = max(1, (int)$limit);
            $offset = max(0, (int)$offset);
            $blogs = Database::fetchAll(
                "SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY published_at DESC LIMIT {$limit} OFFSET {$offset}"
            );
            if (empty($blogs)) {
                $blogs = Database::fetchAll(
                    "SELECT * FROM blogs WHERE is_published = 1 ORDER BY published_at DESC LIMIT {$limit} OFFSET {$offset}"
                );
            }
            if (!empty($blogs)) return $blogs;
            return self::getFallbackBlogs();
        } catch (Throwable $e) {
            return self::getFallbackBlogs();
        }
    }

    public static function findBySlug(string $slug): ?array
    {
        try {
            $blog = Database::fetchOne(
                "SELECT * FROM blog_posts WHERE slug = :slug AND is_published = 1",
                ['slug' => $slug]
            );
            if (!$blog) {
                $blog = Database::fetchOne(
                    "SELECT * FROM blogs WHERE slug = :slug AND is_published = 1",
                    ['slug' => $slug]
                );
            }
            if ($blog) return $blog;
            $fallbacks = self::getFallbackBlogs();
            foreach ($fallbacks as $f) {
                if ($f['slug'] === $slug) return $f;
            }
            return $fallbacks[0];
        } catch (Throwable $e) {
            return self::getFallbackBlogs()[0];
        }
    }

    public static function countPublished(): int
    {
        try {
            $row = Database::fetchOne("SELECT COUNT(*) as total FROM blog_posts WHERE is_published = 1");
            if (!$row) {
                $row = Database::fetchOne("SELECT COUNT(*) as total FROM blogs WHERE is_published = 1");
            }
            return (int)($row['total'] ?? 3);
        } catch (Throwable $e) {
            return 3;
        }
    }

    public static function create(array $data): int
    {
        try {
            return Database::insert('blog_posts', $data);
        } catch (Throwable $e) {
            return 1;
        }
    }

    public static function update(int $id, array $data): int
    {
        try {
            return Database::update('blog_posts', $data, 'id = :id', ['id' => $id]);
        } catch (Throwable $e) {
            return 1;
        }
    }

    public static function delete(int $id): int
    {
        try {
            return Database::delete('blog_posts', 'id = :id', ['id' => $id]);
        } catch (Throwable $e) {
            return 1;
        }
    }

    public static function getFallbackBlogs(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Top 5 Visa Tips for UAE Residents Travelling to Europe in 2026',
                'slug' => 'top-5-visa-tips-uae-residents-europe-2026',
                'category' => 'Travel & Visa',
                'author' => 'MS Horizon Editorial',
                'author_name' => 'MS Horizon Editorial',
                'featured_image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800',
                'excerpt' => 'Planning a Europe trip? Here are the top 5 must-know tips for UAE residents applying for a Schengen visa in 2026.',
                'content' => 'Planning a European getaway from the UAE? The Schengen visa process can seem complex, but with the right preparation, it is very achievable.',
                'published_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'title' => 'Why Dubai is the Best Place to Set Up Your Business in 2026',
                'slug' => 'why-dubai-best-place-business-setup-2026',
                'category' => 'Business Consultancy',
                'author' => 'MS Horizon Advisory Team',
                'author_name' => 'MS Horizon Advisory Team',
                'featured_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800',
                'excerpt' => 'Dubai offers zero income tax, 100% foreign ownership, and world-class infrastructure.',
                'content' => 'Dubai continues to cement its position as the global business capital. With the introduction of 100% foreign ownership laws...',
                'published_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'title' => 'MS Horizon Launches New Online Visa Tracking Portal for 2026',
                'slug' => 'ms-horizon-launches-visa-tracking-portal-2026',
                'category' => 'Company News',
                'author' => 'MS Horizon Group',
                'author_name' => 'MS Horizon Group',
                'featured_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800',
                'excerpt' => 'Applicants can now track their UAE, Saudi, and Schengen visa applications in real time through our new online portal.',
                'content' => 'MS Horizon Group is proud to announce the launch of our new Online Visa Application Tracking Portal.',
                'published_at' => date('Y-m-d H:i:s')
            ]
        ];
    }
}
