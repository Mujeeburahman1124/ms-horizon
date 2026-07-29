<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Validator;
use App\Models\BusinessLead;
use App\Core\Database;

/**
 * Business Consultancy Division Controller
 */
class BusinessController extends Controller
{
    public function index(): void
    {
        try {
            $packages = Database::fetchAll("SELECT * FROM business_packages ORDER BY is_popular DESC, price_starting ASC");
            if (empty($packages)) $packages = $this->getFallbackPackages();
        } catch (\Exception $e) {
            $packages = $this->getFallbackPackages();
        }

        $this->render('business/index', [
            'page_title' => 'UAE Business Setup | Company Formation — MS Horizon Business Consultancy',
            'page_description' => 'Setup your UAE company with expert guidance. Mainland, Free Zone, and Offshore options. Trade license, investor visa, bank account, VAT registration.',
            'packages' => $packages,
        ]);
    }

    public function packages(): void
    {
        try {
            $packages = Database::fetchAll("SELECT * FROM business_packages ORDER BY is_popular DESC");
            if (empty($packages)) $packages = $this->getFallbackPackages();
        } catch (\Exception $e) {
            $packages = $this->getFallbackPackages();
        }

        $this->render('business/packages', [
            'page_title' => 'UAE Business Setup Packages — MS Horizon Group',
            'page_description' => 'Compare Mainland, Free Zone, and Offshore business setup packages with transparent pricing.',
            'packages' => $packages,
        ]);
    }

    public function enquire(): void
    {
        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'name' => 'required|min:2|max:150',
            'email' => 'required|email',
            'phone' => 'required',
            'setup_type' => 'required',
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        $ref = 'BIZ-' . strtoupper(bin2hex(random_bytes(4)));

        try {
            BusinessLead::create([
                'lead_ref' => $ref,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'setup_type' => $data['setup_type'],
                'estimated_budget' => $data['budget'] ?? null,
                'status' => 'New',
            ]);
        } catch (\Exception $e) {
            // Silence fallback
        }

        $this->json([
            'status' => 'success',
            'message' => 'Thank you! Your business enquiry <strong>' . $ref . '</strong> has been received. Our consultant will call you within 2 hours.',
            'reference' => $ref
        ]);
    }

    private function getFallbackPackages(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Dubai Freezone Package',
                'slug' => 'dubai-freezone-package',
                'jurisdiction' => 'Freezone',
                'price_starting' => 12500.00,
                'currency' => 'AED',
                'is_popular' => 1,
                'description' => '100% Foreign ownership, zero corporate tax, 1 investor visa included with office space.'
            ],
            [
                'id' => 2,
                'name' => 'Dubai Mainland LLC Setup',
                'slug' => 'dubai-mainland-llc-setup',
                'jurisdiction' => 'Mainland',
                'price_starting' => 18500.00,
                'currency' => 'AED',
                'is_popular' => 1,
                'description' => 'Trade across UAE local market, government contract eligibility, unlimited employee visas.'
            ],
            [
                'id' => 3,
                'name' => 'Offshore Holding Incorporation',
                'slug' => 'offshore-holding-incorporation',
                'jurisdiction' => 'Offshore',
                'price_starting' => 9500.00,
                'currency' => 'AED',
                'is_popular' => 0,
                'description' => 'Asset protection, international tax planning, multi-currency corporate bank account.'
            ]
        ];
    }
}
