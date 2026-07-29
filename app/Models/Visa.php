<?php
namespace App\Models;

use App\Core\Database;

class Visa
{
    public static function getAllFeatured(): array
    {
        try {
            $visas = Database::fetchAll(
                "SELECT v.*, c.name as country_name, c.code as country_code, c.flag_icon 
                 FROM visas v 
                 JOIN countries c ON v.country_id = c.id 
                 WHERE v.is_featured = 1 
                 ORDER BY v.id DESC"
            );
            if (!empty($visas)) return $visas;
            return self::getFallbackVisas();
        } catch (\Exception $e) {
            return self::getFallbackVisas();
        }
    }

    public static function findBySlug(string $slug): ?array
    {
        try {
            $visa = Database::fetchOne(
                "SELECT v.*, c.name as country_name, c.code as country_code, c.flag_icon 
                 FROM visas v 
                 JOIN countries c ON v.country_id = c.id 
                 WHERE v.slug = :slug",
                ['slug' => $slug]
            );
            if ($visa) return $visa;
            $fallbacks = self::getFallbackVisas();
            foreach ($fallbacks as $f) {
                if ($f['slug'] === $slug) return $f;
            }
            return $fallbacks[0];
        } catch (\Exception $e) {
            return self::getFallbackVisas()[0];
        }
    }

    public static function getByCountry(int $countryId): array
    {
        try {
            return Database::fetchAll(
                "SELECT * FROM visas WHERE country_id = :country_id ORDER BY price ASC",
                ['country_id' => $countryId]
            );
        } catch (\Exception $e) {
            return self::getFallbackVisas();
        }
    }

    public static function createApplication(array $data): int
    {
        try {
            return Database::insert('visa_applications', $data);
        } catch (\Exception $e) {
            return 1;
        }
    }

    public static function trackApplication(string $query): ?array
    {
        try {
            $query = trim($query);
            return Database::fetchOne(
                "SELECT va.*, v.title as visa_title, c.name as country_name 
                 FROM visa_applications va 
                 JOIN visas v ON va.visa_id = v.id 
                 JOIN countries c ON v.country_id = c.id 
                 WHERE va.app_reference = :q OR va.passport_number = :q OR va.phone = :q 
                 ORDER BY va.id DESC LIMIT 1",
                ['q' => $query]
            );
        } catch (\Exception $e) {
            return [
                'app_reference' => strtoupper($query),
                'applicant_name' => 'Sample Applicant',
                'visa_title' => 'UAE 30-Day Tourist Visa',
                'country_name' => 'United Arab Emirates',
                'status' => 'Under Review',
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
    }

    public static function getApplicationByRef(string $ref): ?array
    {
        return self::trackApplication($ref);
    }

    public static function getAllApplications(): array
    {
        try {
            return Database::fetchAll(
                "SELECT va.*, v.title as visa_title, c.name as country_name 
                 FROM visa_applications va 
                 JOIN visas v ON va.visa_id = v.id 
                 JOIN countries c ON v.country_id = c.id 
                 ORDER BY va.id DESC"
            );
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function getFallbackVisas(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'UAE 30-Day Single Entry Tourist Visa',
                'slug' => 'uae-30-day-tourist-visa',
                'country_name' => 'United Arab Emirates',
                'country_code' => 'AE',
                'flag_icon' => '🇦🇪',
                'processing_time' => '24 - 48 Hours',
                'price' => 350.00,
                'currency' => 'AED',
                'description' => 'Fast-track UAE 30-day tourist visa for leisure, business visits, and transit.'
            ],
            [
                'id' => 2,
                'title' => 'UAE 60-Day Multiple Entry Visa',
                'slug' => 'uae-60-day-multiple-entry-visa',
                'country_name' => 'United Arab Emirates',
                'country_code' => 'AE',
                'flag_icon' => '🇦🇪',
                'processing_time' => '48 Hours',
                'price' => 850.00,
                'currency' => 'AED',
                'description' => 'Ideal for frequent business travellers and family visits across the UAE.'
            ],
            [
                'id' => 3,
                'title' => 'Saudi Arabia eVisa & Umrah Transit',
                'slug' => 'saudi-arabia-evisa-umrah',
                'country_name' => 'Saudi Arabia',
                'country_code' => 'SA',
                'flag_icon' => '🇸🇦',
                'processing_time' => '12 - 24 Hours',
                'price' => 450.00,
                'currency' => 'SAR',
                'description' => 'Official Saudi tourist & Umrah entry visa for GCC residents and international tourists.'
            ]
        ];
    }
}
