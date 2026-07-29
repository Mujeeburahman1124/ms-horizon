<?php
namespace App\Models;

use App\Core\Database;
use Throwable;

class Offer
{
    public static function autoArchiveExpired(): void
    {
        try {
            Database::query(
                "UPDATE offers SET is_archived = 1 WHERE expiry_date IS NOT NULL AND expiry_date < CURDATE() AND is_archived = 0"
            );
        } catch (Throwable $e) {
            // Silence fallback
        }
    }

    public static function getActive(): array
    {
        try {
            self::autoArchiveExpired();

            $offers = Database::fetchAll(
                "SELECT o.*, d.title as division_name, d.slug as division_slug
                 FROM offers o 
                 LEFT JOIN divisions d ON o.division_id = d.id
                 WHERE o.is_archived = 0 AND (o.start_date IS NULL OR o.start_date <= CURDATE())
                 ORDER BY o.id DESC"
            );
            if (!empty($offers)) return $offers;
            return self::getFallbackOffers();
        } catch (Throwable $e) {
            return self::getFallbackOffers();
        }
    }

    public static function getArchived(): array
    {
        try {
            return Database::fetchAll(
                "SELECT o.*, d.title as division_name 
                 FROM offers o 
                 LEFT JOIN divisions d ON o.division_id = d.id
                 WHERE o.is_archived = 1 
                 ORDER BY o.expiry_date DESC"
            );
        } catch (Throwable $e) {
            return [];
        }
    }

    public static function findBySlug(string $slug): ?array
    {
        try {
            $offer = Database::fetchOne(
                "SELECT o.*, d.title as division_name 
                 FROM offers o 
                 LEFT JOIN divisions d ON o.division_id = d.id
                 WHERE o.slug = :slug",
                ['slug' => $slug]
            );
            if ($offer) return $offer;

            $fallbacks = self::getFallbackOffers();
            foreach ($fallbacks as $f) {
                if ($f['slug'] === $slug) return $f;
            }
            return $fallbacks[0];
        } catch (Throwable $e) {
            return self::getFallbackOffers()[0];
        }
    }

    public static function create(array $data): int
    {
        try {
            return Database::insert('offers', $data);
        } catch (Throwable $e) {
            return 0;
        }
    }

    public static function update(int $id, array $data): int
    {
        try {
            return Database::update('offers', $data, 'id = :id', ['id' => $id]);
        } catch (Throwable $e) {
            return 0;
        }
    }

    public static function delete(int $id): int
    {
        try {
            return Database::delete('offers', 'id = :id', ['id' => $id]);
        } catch (Throwable $e) {
            return 0;
        }
    }

    public static function getFallbackOffers(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'UAE 30-Day Express Tourist Visa Special',
                'slug' => 'uae-30-day-tourist-visa-special',
                'division_name' => 'Travel & Tourism',
                'division_slug' => 'travel-tourism',
                'discount_percentage' => 15,
                'original_price' => 450,
                'offer_price' => 350,
                'promo_code' => 'UAEVISA2026',
                'expiry_date' => '2026-12-31',
                'terms' => 'Valid for express 24-48 hr processing. Includes mandatory COVID & health travel insurance.',
                'description' => 'Fast-track 30-day single entry UAE tourist visa with complimentary health travel insurance.'
            ],
            [
                'id' => 2,
                'title' => 'Dubai IFZA Freezone Business Setup Package',
                'slug' => 'dubai-ifza-freezone-setup-package',
                'division_name' => 'Business Consultancy',
                'division_slug' => 'business-consultancy',
                'discount_percentage' => 20,
                'original_price' => 15500,
                'offer_price' => 12900,
                'promo_code' => 'BIZDUBAI',
                'expiry_date' => '2026-12-31',
                'terms' => 'Includes 1 commercial license, zero visa allocation, 100% foreign ownership, and corporate bank support.',
                'description' => 'Turn-key Dubai Freezone company formation with trade license and bank account assistance.'
            ],
            [
                'id' => 3,
                'title' => 'Corporate HR Candidate Screening & Recruitment Deal',
                'slug' => 'corporate-hr-recruitment-deal',
                'division_name' => 'HR Consultancy',
                'division_slug' => 'hr-consultancy',
                'discount_percentage' => 25,
                'original_price' => 4000,
                'offer_price' => 2999,
                'promo_code' => 'HRGCC2026',
                'expiry_date' => '2026-12-31',
                'terms' => 'Includes pre-screened candidate shortlisting, background verification, and 90-day replacement guarantee.',
                'description' => 'Executive workforce recruitment & candidate placement package for GCC corporations.'
            ],
            [
                'id' => 4,
                'title' => 'Custom Web Application & Mobile App Development Offer',
                'slug' => 'custom-web-mobile-app-development-offer',
                'division_name' => 'Software Development',
                'division_slug' => 'software-development',
                'discount_percentage' => 30,
                'original_price' => 12000,
                'offer_price' => 8400,
                'promo_code' => 'DEV2026',
                'expiry_date' => '2026-12-31',
                'terms' => 'Includes responsive web frontend, PHP/Node backend API, MySQL database, and 6 months free maintenance.',
                'description' => 'Enterprise web application development, travel booking portals, and mobile apps.'
            ],
            [
                'id' => 5,
                'title' => 'VIP Flight Ticket & Luxury Hotel Reservation Promo',
                'slug' => 'vip-flight-hotel-reservation-promo',
                'division_name' => 'Reservations Services',
                'division_slug' => 'reservations-services',
                'discount_percentage' => 18,
                'original_price' => 2500,
                'offer_price' => 2050,
                'promo_code' => 'FLYHIGH',
                'expiry_date' => '2026-12-31',
                'terms' => 'Applies to worldwide airline ticket bookings and 5-star hotel reservations via MS Horizon concierge.',
                'description' => 'Discounted airline tickets, luxury hotel reservations, and private airport transfers.'
            ],
            [
                'id' => 6,
                'title' => 'Saudi Arabia & Qatar Seasonal Travel Package',
                'slug' => 'saudi-qatar-seasonal-travel-package',
                'division_name' => 'Travel & Tourism',
                'division_slug' => 'travel-tourism',
                'discount_percentage' => 22,
                'original_price' => 1800,
                'offer_price' => 1400,
                'promo_code' => 'GCCSEASONS',
                'expiry_date' => '2026-12-31',
                'terms' => 'Covers Saudi tourist e-Visa, Qatar Hayya entry, flight booking, and hotel vouchers.',
                'description' => 'Seasonal GCC travel promotion including e-Visa, hotel booking, and flight ticketing.'
            ]
        ];
    }
}
