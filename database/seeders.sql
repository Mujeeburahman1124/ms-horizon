-- ============================================================================
-- MS HORIZON GROUP - SEED DATA INSERTS (EXPANDED REGIONAL & GLOBAL DATA)
-- ============================================================================

USE `ms_horizon`;

SET FOREIGN_KEY_CHECKS = 0;

-- 1. ROLES (11 Enterprise Roles)
INSERT INTO `roles` (`id`, `title`, `slug`, `description`) VALUES
(1, 'Super Admin', 'super_admin', 'Full system control across all group divisions'),
(2, 'Group Manager', 'group_manager', 'Overlooks division leads, operations and group reports'),
(3, 'Travel Manager', 'travel_manager', 'Manages visa applications, country rules, travel products'),
(4, 'Reservation Officer', 'reservation_officer', 'Handles flight, hotel, and tour quotations & ticketing'),
(5, 'Recruitment Manager', 'recruitment_manager', 'Manages candidate privacy unlock approvals, employers, jobs'),
(6, 'Recruiter', 'recruiter', 'Screens candidates, schedules interviews, shortlists applicants'),
(7, 'Business Consultant', 'business_consultant', 'Manages UAE business setup leads, licensing, PRO services'),
(8, 'Software Project Manager', 'software_pm', 'Scopes software client requests, manages deliverables'),
(9, 'Accounts Officer', 'accounts_officer', 'Manages invoices, payments, refunds, financial tracking'),
(10, 'Customer Support', 'customer_support', 'Handles contact enquiries, live chat, lead routing'),
(11, 'Content Manager', 'content_manager', 'Manages group news, blogs, offers, testimonials')
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- 2. DEFAULT USERS (Password for admin is AdminPass2026!)
INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `password_hash`, `phone`, `is_active`) VALUES
(1, 1, 'Group Super Admin', 'admin@mshorizontravel.com', '$2y$12$N2b8Q.uW2Xp3ZqD1a7N1b.s9Wn7V8Z0K2l3M4n5O6p7Q8r9S0t1U2', '+97141234567', 1),
(2, 5, 'Sarah Jenkins (Recruitment)', 'recruitment@mshorizontravel.com', '$2y$12$N2b8Q.uW2Xp3ZqD1a7N1b.s9Wn7V8Z0K2l3M4n5O6p7Q8r9S0t1U2', '+97141234568', 1),
(3, 7, 'Tariq Al-Mansoor (Business)', 'business@mshorizontravel.com', '$2y$12$N2b8Q.uW2Xp3ZqD1a7N1b.s9Wn7V8Z0K2l3M4n5O6p7Q8r9S0t1U2', '+97141234569', 1)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- 3. DIVISIONS
INSERT INTO `divisions` (`id`, `title`, `slug`, `icon`, `short_description`, `full_description`) VALUES
(1, 'Reservations Services', 'reservations-services', 'fa-plane-departure', 'Seamless global flight ticketing, luxury hotel bookings, transfers, and corporate travel logistics.', 'MS Horizon Reservations Division provides world-class ticketing, hotel reservations, airport concierge, VIP transfers, and corporate group travel management with speed and accuracy.'),
(2, 'Travel & Tourism', 'travel-tourism', 'fa-passport', 'Worldwide visa assistance, curated holiday packages, and international travel insurance.', 'Our Travel & Tourism division specializes in fast-track visit visas, tourist visas, Schengen appointments, UK/USA visa processing, and customized vacation packages.'),
(3, 'Human Resource Consultancy', 'hr-consultancy', 'fa-users-gear', 'Executive recruitment, GCC staffing solutions, candidate placement, and HR advisory.', 'Connecting premier global talent with leading GCC corporations. We provide candidate screening, employer portals, compliance advisory, and talent acquisition.'),
(4, 'Business Consultancy', 'business-consultancy', 'fa-building-columns', 'UAE company formation (Mainland, Free Zone, Offshore), PRO services, trade licensing, and corporate tax.', 'Comprehensive turn-key business setup services in Dubai & across the UAE, including trade license issuance, investor visa processing, corporate banking, and VAT advisory.'),
(5, 'Software Development', 'software-development', 'fa-laptop-code', 'Custom web applications, travel portals, mobile apps, enterprise ERPs, and cloud automation.', 'Delivering cutting-edge software solutions, AI-driven automation, custom booking engines, travel portals, and high-performance mobile apps built for scale.')
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- 4. EXPANDED COUNTRIES (10 Specific Requested Locations)
TRUNCATE TABLE `countries`;
INSERT INTO `countries` (`id`, `name`, `code`, `flag_icon`, `visa_available`, `popularity_rank`) VALUES
(1, 'United Arab Emirates', 'AE', 'ae-flag.png', 1, 100),
(2, 'Qatar', 'QA', 'qa-flag.png', 1, 98),
(3, 'Oman', 'OM', 'om-flag.png', 1, 96),
(4, 'Saudi Arabia', 'SA', 'sa-flag.png', 1, 99),
(5, 'Bahrain', 'BH', 'bh-flag.png', 1, 94),
(6, 'Sri Lanka', 'LK', 'lk-flag.png', 1, 90),
(7, 'India', 'IN', 'in-flag.png', 1, 92),
(8, 'Europe (Schengen)', 'EU', 'eu-flag.png', 1, 95),
(9, 'United States', 'US', 'us-flag.png', 1, 93),
(10, 'Canada', 'CA', 'ca-flag.png', 1, 91);

-- 5. VISAS
TRUNCATE TABLE `visas`;
INSERT INTO `visas` (`id`, `country_id`, `title`, `slug`, `visa_type`, `price`, `currency`, `processing_time`, `eligibility`, `required_docs_json`, `is_featured`) VALUES
(1, 1, 'UAE 30 Days Tourist Visa', 'uae-30-days-tourist-visa', 'Tourist', 350.00, 'AED', '24-48 Hours', 'Open to all nationalities holding valid passport with 6 months validity.', '["Passport First Page Copy", "White Background Passport Photo"]', 1),
(2, 1, 'UAE 60 Days Multiple Entry Visa', 'uae-60-days-multiple-entry-visa', 'Visit', 850.00, 'AED', '2-3 Business Days', 'Ideal for frequent business visitors and long-stay tourists.', '["Passport Color Copy", "Recent Photo", "Previous Visa Copy if applicable"]', 1),
(3, 4, 'Saudi Arabia Tourist E-Visa', 'saudi-arabia-tourist-evisa', 'Tourist', 550.00, 'SAR', '1-2 Days', 'Available for GCC Residents, US, UK, and Schengen visa holders.', '["Passport Copy", "Passport Size Photo"]', 1),
(4, 2, 'Qatar 30 Days Tourist Visa', 'qatar-30-days-tourist-visa', 'Tourist', 400.00, 'QAR', '48 Hours', 'Passport with minimum 6 months validity and confirmed hotel booking.', '["Passport Copy", "Flight Reservation"]', 1),
(5, 8, 'Schengen Express Tourist Visa', 'schengen-tourist-express-visa', 'Tourist', 950.00, 'AED', '10-14 Days', 'UAE Residents with valid Emirates ID.', '["Emirates ID Copy", "NOC Letter", "3 Months Bank Statement", "Flight & Hotel Voucher"]', 1),
(6, 9, 'US B1/B2 Tourist Appointment & Visa', 'us-b1-b2-tourist-visa', 'Business', 1400.00, 'AED', '15 Days', 'Valid passport and intent of temporary stay.', '["DS-160 Form Details", "Passport Copy", "5x5 cm Photo"]', 1);

-- 6. BUSINESS PACKAGES
TRUNCATE TABLE `business_packages`;
INSERT INTO `business_packages` (`id`, `title`, `jurisdiction`, `price_starting`, `features_json`, `is_popular`) VALUES
(1, 'Dubai IFZA Free Zone License', 'Free Zone', 12900.00, '["1 Commercial License", "Zero Visa Allocation included", "100% Business Ownership", "No Corporate Income Tax for qualifying entities", "Fast-track 3-day approval"]', 1),
(2, 'Dubai Mainland General Trading (DED)', 'Mainland', 18500.00, '["DED General Trading License", "1 Investor Visa Included", "100% Foreign Ownership", "Office Space Leasing Support", "Corporate Bank Account Opening Assistance"]', 1),
(3, 'RAK Offshore International Company', 'Offshore', 9900.00, '["International Business Company", "Tax Free Status", "Confidential Shareholder Register", "Multi-currency Corporate Account"]', 0);

-- 7. JOBS
TRUNCATE TABLE `jobs`;
INSERT INTO `jobs` (`id`, `title`, `slug`, `category`, `location`, `job_type`, `experience_level`, `salary_range`, `description`, `requirements`, `is_active`) VALUES
(1, 'Senior Travel & Ticketing Consultant', 'senior-travel-consultant', 'Hospitality & Travel', 'Dubai, UAE', 'Full-time', '3-5 Years', 'AED 8,000 - 12,000', 'We are looking for an experienced Senior Travel Consultant proficient in GDS (Amadeus/Galileo), ticketing, hotel reservations, and visa advising.', '3+ years GCC experience in Travel agency, Amadeus certification, fluent in English & Arabic.', 1),
(2, 'Corporate Business Setup Consultant', 'corporate-business-setup-consultant', 'Consulting & Legal', 'Dubai, UAE', 'Full-time', '2-4 Years', 'AED 10,000 - 15,000 + Commission', 'Advise global investors on UAE company formation, Freezone vs Mainland setup, trade licensing, and banking procedures.', 'Proven track record in UAE company formation, knowledge of DED and Freezone regulations.', 1),
(3, 'Full Stack PHP Developer (MVC / MySQL)', 'full-stack-php-developer', 'Software Engineering', 'Dubai / Remote', 'Full-time', '3-6 Years', 'AED 12,000 - 18,000', 'Join our Software Division to engineer enterprise web portals, booking engines, RESTful APIs, and SaaS platforms.', 'Expertise in PHP 8+, MySQL 8, OOP, JavaScript ES6, RESTful APIs, security compliance.', 1);

SET FOREIGN_KEY_CHECKS = 1;
