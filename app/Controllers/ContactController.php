<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Validator;
use App\Core\Database;

class ContactController extends Controller
{
    public function index(): void
    {
        $this->render('pages/contact', [
            'page_title' => 'Contact MS Horizon Group — Dubai Office & Enquiries',
            'page_description' => 'Get in touch with MS Horizon Group. Reach our team by phone, email, or WhatsApp. Visit our Dubai Business Bay office.',
        ]);
    }

    public function submit(): void
    {
        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'name' => 'required|min:2|max:150',
            'email' => 'required|email',
            'phone' => 'required',
            'department' => 'required',
            'subject' => 'required|min:5',
            'message' => 'required|min:15',
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        Database::insert('contact_enquiries', [
            'department' => $data['department'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'subject' => $data['subject'],
            'message' => $data['message']
        ]);

        $this->json(['status' => 'success', 'message' => 'Message sent successfully! We will respond within 24 hours.']);
    }
}
