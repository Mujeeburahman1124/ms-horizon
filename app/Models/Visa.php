<?php
namespace App\Models;

use App\Core\Database;

class Visa
{
    public static function getAllFeatured(): array
    {
        return Database::fetchAll(
            "SELECT v.*, c.name as country_name, c.code as country_code, c.flag_icon 
             FROM visas v 
             JOIN countries c ON v.country_id = c.id 
             WHERE v.is_featured = 1 
             ORDER BY v.id DESC"
        );
    }

    public static function findBySlug(string $slug): ?array
    {
        return Database::fetchOne(
            "SELECT v.*, c.name as country_name, c.code as country_code, c.flag_icon 
             FROM visas v 
             JOIN countries c ON v.country_id = c.id 
             WHERE v.slug = :slug",
            ['slug' => $slug]
        );
    }

    public static function getByCountry(int $countryId): array
    {
        return Database::fetchAll(
            "SELECT * FROM visas WHERE country_id = :country_id ORDER BY price ASC",
            ['country_id' => $countryId]
        );
    }

    public static function createApplication(array $data): int
    {
        return Database::insert('visa_applications', $data);
    }

    /**
     * Search application by Reference Number OR Passport Number OR Registered Mobile Number
     */
    public static function trackApplication(string $query): ?array
    {
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
    }

    public static function getApplicationByRef(string $ref): ?array
    {
        return self::trackApplication($ref);
    }

    public static function getAllApplications(): array
    {
        return Database::fetchAll(
            "SELECT va.*, v.title as visa_title, c.name as country_name 
             FROM visa_applications va 
             JOIN visas v ON va.visa_id = v.id 
             JOIN countries c ON v.country_id = c.id 
             ORDER BY va.id DESC"
        );
    }
}
