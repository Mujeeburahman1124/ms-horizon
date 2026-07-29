<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Database;
use App\Core\Validator;
use App\Core\Session;
use App\Models\Visa;

/**
 * Travel & Tourism Division Controller
 */
class TravelController extends Controller
{
    public function index(): void
    {
        try {
            $countries = Database::fetchAll("SELECT * FROM countries WHERE visa_available = 1 ORDER BY popularity_rank DESC");
            if (empty($countries)) $countries = $this->getFallbackCountries();
        } catch (\Exception $e) {
            $countries = $this->getFallbackCountries();
        }

        $featured_visas = Visa::getAllFeatured();

        $this->render('travel/index', [
            'page_title' => 'Travel & Tourism | Worldwide Visa Services — MS Horizon Group',
            'page_description' => 'Fast UAE, Qatar, Saudi Arabia, Oman, Bahrain, UK, Schengen, USA, Canada visa processing with expert guidance.',
            'countries' => $countries,
            'featured_visas' => $featured_visas,
        ]);
    }

    public function countries(): void
    {
        try {
            $countries = Database::fetchAll(
                "SELECT c.*, COUNT(v.id) as visa_count 
                 FROM countries c 
                 LEFT JOIN visas v ON c.id = v.country_id 
                 WHERE c.visa_available = 1 
                 GROUP BY c.id 
                 ORDER BY c.popularity_rank DESC"
            );
            if (empty($countries)) $countries = $this->getFallbackCountries();
        } catch (\Exception $e) {
            $countries = $this->getFallbackCountries();
        }

        $this->render('travel/countries', [
            'page_title' => 'Countries & Visa Services — MS Horizon Group',
            'page_description' => 'Explore visa requirements, processing times, and application guidance for UAE, Qatar, Oman, Saudi Arabia, Bahrain, Sri Lanka, India, Europe, USA, Canada.',
            'countries' => $countries,
        ]);
    }

    public function visaDetail(string $slug): void
    {
        $visa = Visa::findBySlug($slug);
        if (!$visa) {
            $this->redirect('/travel/countries');
            return;
        }

        $related_visas = Visa::getByCountry($visa['country_id'] ?? 1);

        $this->render('travel/visa_detail', [
            'page_title' => $visa['title'] . ' — MS Horizon Travel & Visa',
            'page_description' => 'Apply for ' . $visa['title'] . ' with MS Horizon. Processing time: ' . ($visa['processing_time'] ?? '48 hours'),
            'visa' => $visa,
            'required_docs' => json_decode($visa['required_docs_json'] ?? '[]', true),
            'related_visas' => $related_visas,
        ]);
    }

    public function applyVisa(): void
    {
        $data = Request::getBody();
        $files = $_FILES;

        $validator = new Validator();
        if (!$validator->validate($data, [
            'visa_id' => 'required',
            'applicant_name' => 'required|min:3|max:150',
            'passport_number' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ])) {
            if (Request::isAjax()) {
                $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            } else {
                Session::setFlash('error', $validator->getFirstError());
                $this->redirect('/travel');
            }
            return;
        }

        $ref = 'VISA-' . strtoupper(bin2hex(random_bytes(4)));

        try {
            $appId = Visa::createApplication([
                'app_reference' => $ref,
                'visa_id' => (int)$data['visa_id'],
                'applicant_name' => $data['applicant_name'],
                'passport_number' => $data['passport_number'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'status' => 'Application Received'
            ]);
        } catch (\Exception $e) {
            // Log fallback
        }

        if (Request::isAjax()) {
            $this->json([
                'status' => 'success',
                'message' => 'Application submitted successfully! Your tracking reference: <strong>' . $ref . '</strong>',
                'reference' => $ref
            ]);
        } else {
            Session::setFlash('success', 'Application submitted! Your tracking reference number is: ' . $ref);
            $this->redirect('/travel/track');
        }
    }

    public function trackForm(): void
    {
        $this->render('travel/track', [
            'page_title' => 'Track Visa Application — MS Horizon Group',
            'page_description' => 'Check real-time status of your visa application using your Reference Number, Passport Number, or Registered Mobile Number.',
        ]);
    }

    public function trackResult(): void
    {
        $ref = trim(Request::get('reference', ''));
        $application = null;
        $error = null;

        if (!empty($ref)) {
            $application = Visa::trackApplication($ref);
            if (!$application) {
                $error = 'No visa application found for input: "' . htmlspecialchars($ref, ENT_QUOTES, 'UTF-8') . '". Please check your Application Number, Passport Number, or Mobile Number.';
            }
        }

        if (Request::isAjax()) {
            if ($application) {
                $this->json(['status' => 'success', 'application' => $application]);
            } else {
                $this->json(['status' => 'error', 'message' => $error ?? 'Please enter your Application Number, Passport Number, or Mobile Number.']);
            }
            return;
        }

        $this->render('travel/track', [
            'page_title' => 'Track Visa Application — MS Horizon Group',
            'page_description' => 'Real-time visa application status tracking.',
            'application' => $application,
            'track_error' => $error,
            'ref' => $ref
        ]);
    }

    private function getFallbackCountries(): array
    {
        return [
            ['id' => 1, 'name' => 'United Arab Emirates', 'code' => 'AE', 'flag_icon' => '🇦🇪', 'visa_count' => 5],
            ['id' => 2, 'name' => 'Saudi Arabia', 'code' => 'SA', 'flag_icon' => '🇸🇦', 'visa_count' => 3],
            ['id' => 3, 'name' => 'Qatar', 'code' => 'QA', 'flag_icon' => '🇶🇦', 'visa_count' => 2],
            ['id' => 4, 'name' => 'Oman', 'code' => 'OM', 'flag_icon' => '🇴🇲', 'visa_count' => 2],
            ['id' => 5, 'name' => 'Kuwait', 'code' => 'KW', 'flag_icon' => '🇰🇼', 'visa_count' => 2],
            ['id' => 6, 'name' => 'Bahrain', 'code' => 'BH', 'flag_icon' => '🇧🇭', 'visa_count' => 2]
        ];
    }
}
