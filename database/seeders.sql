-- ============================================================================
-- MS HORIZON GROUP - SEED DATA v2.0 (matches schema v2.0)
-- ============================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

-- 1. ROLES (11 Enterprise Roles)
INSERT INTO `roles` (`id`, `title`, `slug`, `description`) VALUES
(1,  'Super Administrator',      'super_admin',           'Full system control across all group divisions'),
(2,  'Group Manager',            'group_manager',         'Overlooks division leads, operations and group reports'),
(3,  'Travel Manager',           'travel_manager',        'Manages visa applications, country rules, travel products'),
(4,  'Reservation Officer',      'reservation_officer',   'Handles flight, hotel, and tour quotations & ticketing'),
(5,  'Recruitment Manager',      'recruitment_manager',   'Manages candidate privacy unlock approvals, employers, jobs'),
(6,  'Recruiter',                'recruiter',             'Screens candidates, schedules interviews, shortlists applicants'),
(7,  'Business Consultant',      'business_consultant',   'Manages UAE business setup leads, licensing, PRO services'),
(8,  'Software Project Manager', 'software_pm',           'Scopes software client requests, manages deliverables'),
(9,  'Accounts Officer',         'accounts_officer',      'Manages invoices, payments, refunds, financial tracking'),
(10, 'Customer Support',         'customer_support',      'Handles contact enquiries, live chat, lead routing'),
(11, 'Content Manager',          'content_manager',       'Manages group news, blogs, offers, testimonials')
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- 2. DIVISIONS (5 Core Business Divisions)
INSERT INTO `divisions` (`id`, `title`, `slug`, `icon`, `short_description`, `full_description`) VALUES
(1, 'Reservations Services',      'reservations-services',  'fa-plane-departure',    'Seamless global flight ticketing, luxury hotel bookings, transfers, and corporate travel logistics.',       'MS Horizon Reservations Division provides world-class ticketing, hotel reservations, airport concierge, VIP transfers, and corporate group travel management with speed and accuracy.'),
(2, 'Travel & Tourism',           'travel-tourism',         'fa-passport',           'Worldwide visa assistance, curated holiday packages, and international travel insurance.',                    'Our Travel & Tourism division specializes in fast-track visit visas, tourist visas, Schengen appointments, UK/USA visa processing, and customized vacation packages.'),
(3, 'Human Resource Consultancy', 'hr-consultancy',         'fa-users-gear',         'Executive recruitment, GCC staffing solutions, candidate placement, and HR advisory.',                       'Connecting premier global talent with leading GCC corporations. We provide candidate screening, employer portals, compliance advisory, and talent acquisition.'),
(4, 'Business Consultancy',       'business-consultancy',   'fa-building-columns',   'UAE company formation (Mainland, Free Zone, Offshore), PRO services, trade licensing, and corporate tax.',   'Comprehensive turn-key business setup services in Dubai & across the UAE, including trade license issuance, investor visa processing, corporate banking, and VAT advisory.'),
(5, 'Software Development',       'software-development',   'fa-laptop-code',        'Custom web applications, travel portals, mobile apps, enterprise ERPs, and cloud automation.',               'Delivering cutting-edge software solutions, AI-driven automation, custom booking engines, travel portals, and high-performance mobile apps built for scale.')
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- 3. COUNTRIES (10 Key Markets)
INSERT INTO `countries` (`id`, `name`, `code`, `flag_emoji`, `flag_icon`, `visa_available`, `popularity_rank`) VALUES
(1,  'United Arab Emirates', 'AE', '🇦🇪', 'ae-flag.png', 1, 100),
(2,  'Qatar',                'QA', '🇶🇦', 'qa-flag.png', 1, 98),
(3,  'Oman',                 'OM', '🇴🇲', 'om-flag.png', 1, 96),
(4,  'Saudi Arabia',         'SA', '🇸🇦', 'sa-flag.png', 1, 99),
(5,  'Bahrain',              'BH', '🇧🇭', 'bh-flag.png', 1, 94),
(6,  'Sri Lanka',            'LK', '🇱🇰', 'lk-flag.png', 1, 90),
(7,  'India',                'IN', '🇮🇳', 'in-flag.png', 1, 92),
(8,  'Europe (Schengen)',    'EU', '🇪🇺', 'eu-flag.png', 1, 95),
(9,  'United States',        'US', '🇺🇸', 'us-flag.png', 1, 93),
(10, 'Canada',               'CA', '🇨🇦', 'ca-flag.png', 1, 91)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- 4. VISAS (6 Featured Visa Products)
INSERT INTO `visas` (`id`, `country_id`, `title`, `slug`, `visa_type`, `price`, `currency`, `processing_time`, `processing_days`, `eligibility`, `required_docs_json`, `is_featured`) VALUES
(1, 1, 'UAE 30 Days Tourist Visa',         'uae-30-days-tourist-visa',         'Tourist',  350.00, 'AED', '24-48 Hours',     1,  'Open to all nationalities holding valid passport with 6 months validity.',                    '["Passport First Page Copy","White Background Passport Photo"]',                                                            1),
(2, 1, 'UAE 60 Days Multiple Entry Visa',  'uae-60-days-multiple-entry-visa',  'Visit',    850.00, 'AED', '2-3 Business Days', 3, 'Ideal for frequent business visitors and long-stay tourists.',                               '["Passport Color Copy","Recent Photo","Previous Visa Copy if applicable"]',                                                 1),
(3, 4, 'Saudi Arabia Tourist E-Visa',      'saudi-arabia-tourist-evisa',       'Tourist',  550.00, 'SAR', '1-2 Days',        2,  'Available for GCC Residents, US, UK, and Schengen visa holders.',                            '["Passport Copy","Passport Size Photo"]',                                                                                   1),
(4, 2, 'Qatar 30 Days Tourist Visa',       'qatar-30-days-tourist-visa',       'Tourist',  400.00, 'QAR', '48 Hours',        2,  'Passport with minimum 6 months validity and confirmed hotel booking.',                        '["Passport Copy","Flight Reservation"]',                                                                                    1),
(5, 8, 'Schengen Express Tourist Visa',    'schengen-tourist-express-visa',    'Tourist',  950.00, 'AED', '10-14 Days',      12, 'UAE Residents with valid Emirates ID.',                                                       '["Emirates ID Copy","NOC Letter","3 Months Bank Statement","Flight & Hotel Voucher"]',                                      1),
(6, 9, 'US B1/B2 Tourist Appointment & Visa', 'us-b1-b2-tourist-visa',        'Business', 1400.00,'AED', '15 Days',         15, 'Valid passport and intent of temporary stay.',                                                '["DS-160 Form Details","Passport Copy","5x5 cm Photo"]',                                                                    1)
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- 5. BUSINESS PACKAGES (3 Key Packages)
INSERT INTO `business_packages` (`id`, `title`, `jurisdiction`, `price_starting`, `features_json`, `is_popular`) VALUES
(1, 'Dubai IFZA Free Zone License',           'Free Zone', 12900.00, '["1 Commercial License","Zero Visa Allocation included","100% Business Ownership","No Corporate Income Tax for qualifying entities","Fast-track 3-day approval"]', 1),
(2, 'Dubai Mainland General Trading (DED)',   'Mainland',  18500.00, '["DED General Trading License","1 Investor Visa Included","100% Foreign Ownership","Office Space Leasing Support","Corporate Bank Account Opening Assistance"]', 1),
(3, 'RAK Offshore International Company',     'Offshore',  9900.00,  '["International Business Company","Tax Free Status","Confidential Shareholder Register","Multi-currency Corporate Account"]', 0)
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- 6. JOBS (3 Live Positions)
INSERT INTO `jobs` (`id`, `title`, `slug`, `category`, `location`, `job_type`, `experience_level`, `salary_range`, `description`, `requirements`, `is_active`) VALUES
(1, 'Senior Travel & Ticketing Consultant',    'senior-travel-consultant',            'Hospitality & Travel',  'Dubai, UAE',     'Full-time', '3-5 Years',   'AED 8,000 - 12,000',           'We are looking for an experienced Senior Travel Consultant proficient in GDS (Amadeus/Galileo), ticketing, hotel reservations, and visa advising.',         '3+ years GCC experience in Travel agency, Amadeus certification, fluent in English & Arabic.',        1),
(2, 'Corporate Business Setup Consultant',     'corporate-business-setup-consultant', 'Consulting & Legal',    'Dubai, UAE',     'Full-time', '2-4 Years',   'AED 10,000 - 15,000 + Commission', 'Advise global investors on UAE company formation, Freezone vs Mainland setup, trade licensing, and banking procedures.',                              'Proven track record in UAE company formation, knowledge of DED and Freezone regulations.',            1),
(3, 'Full Stack PHP Developer (MVC / MySQL)',  'full-stack-php-developer',            'Software Engineering',  'Dubai / Remote', 'Full-time', '3-6 Years',   'AED 12,000 - 18,000',          'Join our Software Division to engineer enterprise web portals, booking engines, RESTful APIs, and SaaS platforms.',                                        'Expertise in PHP 8+, MySQL 8, OOP, JavaScript ES6, RESTful APIs, security compliance.',              1),
(4, 'HR Recruitment Coordinator',             'hr-recruitment-coordinator',          'Human Resources',       'Dubai, UAE',     'Full-time', '1-3 Years',   'AED 6,000 - 8,500',            'Coordinate end-to-end recruitment processes for GCC corporate clients including job posting, CV screening, and interview scheduling.',                       'Experience in recruitment or HR coordination, excellent communication in English.',                    1)
ON DUPLICATE KEY UPDATE title=VALUES(title);

-- 7. BLOG POSTS (3 Sample Articles) — table is blog_posts in schema v2.0
INSERT INTO `blog_posts` (`id`, `title`, `slug`, `author`, `category`, `featured_image`, `excerpt`, `content`, `is_published`) VALUES
(1, 'Top 5 Visa Tips for UAE Residents Travelling to Europe in 2026', 'top-5-visa-tips-uae-residents-europe-2026', 'MS Horizon Editorial', 'Travel & Visa', 'default-blog.jpg', 'Planning a Europe trip? Here are the top 5 must-know tips for UAE residents applying for a Schengen visa in 2026.', '<p>Planning a European getaway from the UAE? The Schengen visa process can seem complex, but with the right preparation, it is very achievable. Here are our top five tips for UAE residents...</p><p><strong>1. Apply Early:</strong> Embassy slots book up fast, especially during summer and holiday seasons. We recommend applying 8-10 weeks before your intended travel date.</p><p><strong>2. Strong Bank Statements:</strong> Show minimum AED 15,000 in your account for the last 3 months. Statements must be bank-stamped.</p><p><strong>3. NOC Letter:</strong> If employed, a No Objection Certificate from your employer is essential. It should be on company letterhead with the HR signature.</p><p><strong>4. Comprehensive Travel Insurance:</strong> Minimum coverage of €30,000 is mandatory for all Schengen visa applications.</p><p><strong>5. Complete Hotel & Flight Vouchers:</strong> Full itinerary including hotel bookings and return flight reservations must be provided upfront.</p><p>Contact MS Horizon Travel Division for expert Schengen visa assistance and fast-track processing.</p>', 1),
(2, 'Why Dubai is the Best Place to Set Up Your Business in 2026', 'why-dubai-best-place-business-setup-2026', 'MS Horizon Business Team', 'Business & Investment', 'default-blog.jpg', 'Dubai offers zero income tax, 100% foreign ownership, and world-class infrastructure. Here is why now is the perfect time.', '<p>Dubai continues to cement its position as the global business capital. With the introduction of 100% foreign ownership laws, corporate tax exemptions for qualifying SMEs, and a streamlined company formation process, there has never been a better time to establish your business in the UAE.</p><p><strong>Key Advantages:</strong></p><ul><li>0% personal income tax</li><li>9% corporate tax only on profits above AED 375,000</li><li>World-class logistics & connectivity hub</li><li>50+ Free Trade Zones</li><li>Investor-friendly legal framework</li></ul><p>MS Horizon Business Consultancy offers complete end-to-end company formation services, from trade license issuance to corporate bank account opening and investor visa processing.</p>', 1),
(3, 'MS Horizon Launches New Online Visa Tracking Portal for 2026', 'ms-horizon-launches-visa-tracking-portal-2026', 'MS Horizon Group', 'Company News', 'default-blog.jpg', 'Applicants can now track their UAE, Saudi, and Schengen visa applications in real time through our new online portal.', '<p>MS Horizon Group is proud to announce the launch of our new Online Visa Application Tracking Portal. Customers can now submit visa applications, upload documents securely, and track their application status in real time — all from the comfort of their homes.</p><p><strong>Features of the New Portal:</strong></p><ul><li>Real-time visa application tracking with SMS and email notifications</li><li>Secure document upload and management</li><li>Automated status updates from embassy processing centers</li><li>24/7 chatbot support for common visa enquiries</li></ul><p>The portal is now live for UAE Tourist Visa, Saudi Arabia E-Visa, Qatar Tourist Visa, and Schengen Express Visa applications. Login at mshorizontravel.com/travel/track</p>', 1)
ON DUPLICATE KEY UPDATE title=VALUES(title);

SET FOREIGN_KEY_CHECKS = 1;
