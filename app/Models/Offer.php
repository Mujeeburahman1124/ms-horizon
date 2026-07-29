<?php
namespace App\Models;

use App\Core\Database;

class Offer
{
    public static function getActive(): array
    {
        try {
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
        } catch (\Exception $e) {
            // Return fallback default offers if database is empty/initializing
            return [
                [
                    'id' => 1,
                    'title' => 'Dubai 30-Day Tourist Visa Special',
                    'slug' => 'dubai-tourist-visa-special',
                    'division_name' => 'Travel & Tourism',
                    'division_slug' => 'travel',
                    'discount_percentage' => 15,
                    'promo_code' => 'DUBAI2026',
                    'description' => 'Fast-track UAE 30-day single entry tourist visa processing with free insurance.'
                ],
                [
                    'id' => 2,
                    'title' => 'GCC HR Recruitment Package',
                    'slug' => 'gcc-hr-recruitment-package',
                    'division_name' => 'Human Resource Consultancy',
                    'division_slug' => 'careers',
                    'discount_percentage' => 20,
                    'promo_code' => 'HRGCC2026',
                    'description' => 'Comprehensive candidate screening and pre-verified talent recruitment for companies.'
                ],
                [
                    'id' => 3,
                    'title' => 'UAE Business Setup & License Discount',
                    'slug' => 'uae-business-setup-discount',
                    'division_name' => 'Business Consultancy',
                    'division_slug' => 'business',
                    'discount_percentage' => 25,
                    'promo_code' => 'BIZDUBAI',
                    'description' => 'Complete Mainland & Freezone business setup package with corporate bank assistance.'
                ]
            ];
        }
    }

    public static function getArchived(): array
    {
        try {
            return Database::fetchAll(
                "SELECT o.*, d.title as division_name 
                 FROM offers o 
                 JOIN divisions d ON o.division_id = d.id
                 WHERE o.is_archived = 1 
                 ORDER BY o.expiry_date DESC"
            );
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function findBySlug(string $slug): ?array
    {
        try {
            return Database::fetchOne(
                "SELECT o.*, d.title as division_name 
                 FROM offers o 
                 JOIN divisions d ON o.division_id = d.id
                 WHERE o.slug = :slug",
                ['slug' => $slug]
            );
        } catch (\Exception $e) {
            return null;
        }
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
