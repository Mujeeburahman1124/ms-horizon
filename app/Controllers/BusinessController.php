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
        $packages = Database::fetchAll("SELECT * FROM business_packages ORDER BY is_popular DESC, price_starting ASC");

        $this->render('business/index', [
            'page_title' => 'UAE Business Setup | Company Formation — MS Horizon Business Consultancy',
            'page_description' => 'Setup your UAE company with expert guidance. Mainland, Free Zone, and Offshore options. Trade license, investor visa, bank account, VAT registration.',
            'packages' => $packages,
        ]);
    }

    public function packages(): void
    {
        $packages = Database::fetchAll("SELECT * FROM business_packages ORDER BY is_popular DESC");

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

        BusinessLead::create([
            'lead_ref' => $ref,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'setup_type' => $data['setup_type'],
            'estimated_budget' => $data['budget'] ?? null,
            'status' => 'New',
        ]);

        $this->json([
            'status' => 'success',
            'message' => 'Thank you! Your business enquiry <strong>' . $ref . '</strong> has been received. Our consultant will call you within 2 hours.',
            'reference' => $ref
        ]);
    }
}
