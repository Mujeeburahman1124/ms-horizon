<?php
namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Request;

class ReservationAdminController extends DashboardController
{
    public function index(): void
    {
        try {
            $reservations = Database::fetchAll(
                "SELECT * FROM reservations ORDER BY id DESC LIMIT 100"
            );
        } catch (\Exception $e) {
            $reservations = [];
        }
        $this->renderAdmin('admin/reservations', [
            'page_title'   => 'Reservations — MS Horizon Admin',
            'breadcrumb'   => 'Reservations',
            'reservations' => $reservations,
            'current_user' => $this->user,
        ]);
    }

    public function detail(int $id): void
    {
        try {
            $reservation = Database::fetchOne(
                "SELECT * FROM reservations WHERE id = :id",
                ['id' => $id]
            );
        } catch (\Exception $e) {
            $reservation = null;
        }
        if (!$reservation) { $this->redirect('/admin/reservations'); return; }

        $this->renderAdmin('admin/reservation_detail', [
            'page_title'   => 'Reservation #' . $id . ' — Admin',
            'breadcrumb'   => 'Reservation Detail',
            'reservation'  => $reservation,
            'current_user' => $this->user,
        ]);
    }

    public function updateStatus(): void
    {
        $data = Request::getBody();
        $id = $data['id'] ?? 0;
        $status = $data['status'] ?? '';
        $allowed = ['Pending Quote', 'Quoted', 'Confirmed', 'Voucher Issued', 'Cancelled'];
        if (!$id || !in_array($status, $allowed)) {
            $this->json(['status' => 'error', 'message' => 'Invalid status or missing ID.'], 400);
            return;
        }
        try {
            Database::query("UPDATE reservations SET status = :s WHERE id = :id", ['s' => $status, 'id' => $id]);
            $this->json(['status' => 'success', 'message' => 'Reservation status updated to ' . $status]);
        } catch (\Exception $e) {
            $this->json(['status' => 'error', 'message' => 'DB error.'], 500);
        }
    }
}
