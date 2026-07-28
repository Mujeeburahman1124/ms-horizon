<?php
namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Request;
use App\Core\Session;

class ReservationAdminController extends DashboardController
{
    public function index(): void
    {
        $reservations = Database::fetchAll(
            "SELECT r.*, u.name as staff_name FROM reservations r 
             LEFT JOIN users u ON r.assigned_staff_id = u.id 
             ORDER BY r.id DESC"
        );
        $this->renderAdmin('admin/reservations', [
            'page_title' => 'Reservations — MS Horizon Admin',
            'reservations' => $reservations,
        ]);
    }

    public function show(string $id): void
    {
        $reservation = Database::fetchOne(
            "SELECT r.*, u.name as staff_name FROM reservations r 
             LEFT JOIN users u ON r.assigned_staff_id = u.id 
             WHERE r.id = :id",
            ['id' => $id]
        );
        if (!$reservation) { $this->redirect('/admin/reservations'); return; }

        $this->renderAdmin('admin/reservation_detail', [
            'page_title' => 'Reservation #' . $id . ' — Admin',
            'reservation' => $reservation,
        ]);
    }

    public function updateStatus(string $id): void
    {
        $data = Request::getBody();
        $allowed = ['Pending Quote', 'Quoted', 'Confirmed', 'Voucher Issued', 'Cancelled'];
        if (!in_array($data['status'] ?? '', $allowed)) {
            $this->json(['status' => 'error', 'message' => 'Invalid status.']);
            return;
        }
        Database::update('reservations', ['status' => $data['status']], 'id = :id', ['id' => $id]);
        $this->json(['status' => 'success', 'message' => 'Reservation status updated.']);
    }
}
