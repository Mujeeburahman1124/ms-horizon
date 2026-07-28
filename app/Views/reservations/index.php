<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-plane-departure text-warning me-2"></i> Reservations Services</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <span>Reservations</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="row align-items-center g-5 mb-5">
      <div class="col-lg-6">
        <span class="section-eyebrow">Ticketing & Hospitality</span>
        <h2 class="section-title">Global Airline Tickets, Hotels & <span class="highlight">Transfers</span></h2>
        <p class="section-subtitle">
          MS Horizon Reservations Division provides instant GDS ticketing, 5-star hotel reservations, 
          VIP airport transfers, tour bookings, travel insurance, appointment reservations, and corporate travel services.
        </p>

        <div class="row g-3 mt-3">
          <div class="col-6">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
              <i class="fas fa-plane text-warning fa-2x mb-2"></i>
              <h4 class="h6 font-weight-bold">Airline Ticket Reservations</h4>
              <p class="small text-muted mb-0">Best fares on all major airlines worldwide.</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
              <i class="fas fa-hotel text-warning fa-2x mb-2"></i>
              <h4 class="h6 font-weight-bold">Hotel Reservations</h4>
              <p class="small text-muted mb-0">Corporate rates at luxury hotels & resorts.</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
              <i class="fas fa-car-side text-warning fa-2x mb-2"></i>
              <h4 class="h6 font-weight-bold">Airport Transfers</h4>
              <p class="small text-muted mb-0">VIP chauffeured sedan & van pickups.</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
              <i class="fas fa-briefcase text-warning fa-2x mb-2"></i>
              <h4 class="h6 font-weight-bold">Corporate Travel</h4>
              <p class="small text-muted mb-0">Dedicated account manager & monthly invoicing.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Detailed Reservation Enquiry Form -->
      <div class="col-lg-6">
        <div class="hero-card-float style-dark" style="background:var(--clr-navy-mid);border-color:var(--clr-gold);">
          <h3 style="color:var(--clr-gold);"><i class="fas fa-calculator"></i> Reservation Enquiry Form</h3>
          <form data-ajax="true" action="<?= APP_URL ?>/reservations/enquire" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="res_name">Customer Name</label>
                  <input type="text" id="res_name" name="customer_name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="res_phone">Phone Number</label>
                  <input type="tel" id="res_phone" name="customer_phone" required>
                </div>
              </div>
            </div>

            <div class="enquiry-form-group">
              <label for="res_email">Email Address</label>
              <input type="email" id="res_email" name="customer_email" required>
            </div>

            <div class="enquiry-form-group">
              <label for="res_type">Reservation Type</label>
              <select id="res_type" name="service_type" required>
                <option value="Airline Ticket">✈ Airline Ticket Reservations</option>
                <option value="Hotel Booking">🏨 Hotel Reservations</option>
                <option value="Airport Transfer">🚘 Airport Transfers</option>
                <option value="Tour Package">🏖 Tour Reservations</option>
                <option value="Travel Insurance">🛡 Travel Insurance Assistance</option>
                <option value="Appointment">📅 Appointment Reservations</option>
                <option value="Event Booking">🎉 Event / Activity Bookings</option>
                <option value="Corporate Travel">💼 Corporate Travel Reservations</option>
              </select>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="res_dep_country">Departure Country</label>
                  <input type="text" id="res_dep_country" name="departure_country" placeholder="e.g. UAE, India" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="res_dest_country">Destination Country</label>
                  <input type="text" id="res_dest_country" name="destination_country" placeholder="e.g. UK, France" required>
                </div>
              </div>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="res_travel_date">Travel Date</label>
                  <input type="date" id="res_travel_date" name="travel_date" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="res_return_date">Return Date</label>
                  <input type="date" id="res_return_date" name="return_date">
                </div>
              </div>
            </div>

            <div class="row g-2">
              <div class="col-6">
                <div class="enquiry-form-group">
                  <label for="res_adults">Number of Adults</label>
                  <input type="number" id="res_adults" name="passenger_count" value="1" min="1" required>
                </div>
              </div>
              <div class="col-6">
                <div class="enquiry-form-group">
                  <label for="res_children">Number of Children</label>
                  <input type="number" id="res_children" name="children_count" value="0" min="0">
                </div>
              </div>
            </div>

            <div class="enquiry-form-group">
              <label for="res_pref">Preferred Airline / Hotel (Optional)</label>
              <input type="text" id="res_pref" name="preferred_provider" placeholder="Emirates, Etihad, Marriott, etc.">
            </div>

            <div class="enquiry-form-group">
              <label for="res_details">Additional Request</label>
              <textarea id="res_details" name="details" rows="2" placeholder="Specific seating, dietary, room type, or travel insurance notes..." required></textarea>
            </div>

            <div class="enquiry-form-group">
              <label for="res_doc">Document Upload (Passport / ID Copy)</label>
              <input type="file" id="res_doc" name="document" accept=".pdf,.jpg,.jpeg,.png" class="form-control" style="background:rgba(255,255,255,.05);color:white;">
            </div>

            <button type="submit" class="btn btn-primary w-100 justify-content-center mt-2">
              <i class="fas fa-paper-plane"></i> Submit Reservation Request
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
