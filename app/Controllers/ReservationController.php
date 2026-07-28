<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Database;
use App\Core\Validator;
use App\Core\Session;
use App\Models\Reservation;

/**
 * Reservations Division Controller
 */
class ReservationController extends Controller
{
    public function index(): void
    {
        $this->render('reservations/index', [
            'page_title' => 'Reservation Services | Flights, Hotels & Transfers — MS Horizon Group',
            'page_description' => 'Book airline tickets, hotels, airport transfers, tours, corporate travel, and travel insurance through MS Horizon Reservations Division.',
        ]);
    }

    public function enquire(): void
    {
        $data = Request::getBody();

        $validator = new Validator();
        if (!$validator->validate($data, [
            'service_type' => 'required',
            'customer_name' => 'required|min:2|max:150',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'travel_date' => 'required',
            'details' => 'required|min:10',
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        $bookingRef = 'RES-' . strtoupper(bin2hex(random_bytes(5)));

        Reservation::create([
            'booking_ref' => $bookingRef,
            'service_type' => $data['service_type'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'travel_date' => $data['travel_date'],
            'return_date' => !empty($data['return_date']) ? $data['return_date'] : null,
            'passenger_count' => (int)($data['passenger_count'] ?? 1),
            'details' => $data['details'],
            'status' => 'Pending Quote'
        ]);

        $this->json([
            'status' => 'success',
            'message' => 'Your reservation request has been received! Reference: <strong>' . $bookingRef . '</strong>. Our team will send you a quotation within 2 hours.',
            'reference' => $bookingRef
        ]);
    }
}
