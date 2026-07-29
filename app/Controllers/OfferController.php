<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index(): void
    {
        $offers = Offer::getActive();

        $this->render('offers/index', [
            'page_title' => 'Offers & Special Deals — MS Horizon Group',
            'page_description' => 'Exclusive promotional offers on UAE visa processing, hotel reservations, HR recruitment, business setup, and software development packages.',
            'offers' => $offers
        ]);
    }

    public function show(string $slug): void
    {
        $offer = Offer::findBySlug($slug);
        if (!$offer) {
            $this->redirect('/offers');
            return;
        }

        $this->render('offers/index', [
            'page_title' => $offer['title'] . ' — MS Horizon Offers',
            'page_description' => $offer['description'] ?? '',
            'offers' => [$offer]
        ]);
    }
}
