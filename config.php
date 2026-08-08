<?php
/**
 * Coming Keys — Landing Page Configuration
 * ----------------------------------------
 * Every editable value lives here. Change these and the whole page updates.
 * No other file needs to be touched for a normal content update.
 */

return [

    /* ---------------------------------------------------------- Brand ---- */
    'brand' => [
        'name'        => 'Coming Keys',
        'tagline'     => 'Key to Happiness',
        'legal_name'  => 'Coming Keys Realty LLP',
        'phone'       => '+91 98765 43210',
        'phone_raw'   => '919876543210',
        'whatsapp'    => '919876543210',
        'email'       => 'sales@comingkeys.com',
        'address'     => 'Sector 104, Dwarka Expressway, Gurugram, Haryana 122006',
        'locality'    => 'Gurugram',
        'region'      => 'Haryana',
        'postal'      => '122006',
        'country'     => 'IN',
        'lat'         => '28.5355',
        'lng'         => '77.0450',
    ],

    /* -------------------------------------------------------- Project ---- */
    'project' => [
        'name'        => 'Coming Keys — The Reserve',
        'eyebrow'     => 'New Launch · Dwarka Expressway, Gurugram',
        'headline'    => 'A private reserve of',
        'headline_em' => '3 & 4 BHK sky residences',
        'subline'     => 'Fourteen acres. Six towers. Eighty-two percent open. A limited collection of light-filled homes on Gurugram’s fastest-appreciating corridor.',
        'price_from'  => '₹1.65 Cr',
        'price_upto'  => '₹3.85 Cr',
        'possession'  => 'Dec 2028',
        'rera'        => 'RC/REP/HARERA/GGM/2026/04/1187',
        'rera_url'    => 'https://haryanarera.gov.in',
        'map_query'   => 'Sector+104+Dwarka+Expressway+Gurugram',
    ],

    /* ---------------------------------------------------------- Stats ---- */
    'stats' => [
        ['value' => 14.2, 'suffix' => '',    'label' => 'Acres of gated estate',  'decimals' => 1],
        ['value' => 82,   'suffix' => '%',   'label' => 'Open & landscaped',      'decimals' => 0],
        ['value' => 6,    'suffix' => '',    'label' => 'Towers, G+38 floors',    'decimals' => 0],
        ['value' => 45,   'suffix' => '+',   'label' => 'Curated amenities',      'decimals' => 0],
    ],

    /* ----------------------------------------------------- Price table ---- */
    'plans' => [
        ['type' => '2 BHK + Study', 'carpet' => '1,485', 'price' => '₹1.65 Cr*', 'tag' => 'Sold out soon', 'img' => 'plan-2bhk'],
        ['type' => '3 BHK',         'carpet' => '1,890', 'price' => '₹2.10 Cr*', 'tag' => 'Best seller',   'img' => 'plan-3bhk'],
        ['type' => '3 BHK + Servant','carpet' => '2,240','price' => '₹2.55 Cr*', 'tag' => '',              'img' => 'plan-3bhks'],
        ['type' => '4 BHK Duplex',  'carpet' => '3,150', 'price' => '₹3.85 Cr*', 'tag' => 'Corner units',  'img' => 'plan-4bhk'],
        ['type' => 'Sky Penthouse', 'carpet' => '4,600', 'price' => 'On request','tag' => 'Only 6',        'img' => 'plan-ph'],
    ],

    /* ------------------------------------------------------- Amenities ---- */
    'amenities' => [
        'Wellness' => ['70 m infinity pool', 'Kids’ splash pool', 'Double-height gymnasium', 'Yoga & meditation deck', 'Spa, sauna & steam', 'Reflexology walk', 'Salon & grooming suite'],
        'Sport'    => ['Tennis court', 'Squash court', 'Half basketball court', 'Badminton courts', 'Cricket practice net', 'Skating rink', 'Golf putting green', '1.2 km jogging loop'],
        'Social'   => ['22,000 sq.ft clubhouse', 'Banquet & party hall', 'Open-air amphitheatre', 'Barbecue deck', 'Residents’ café', 'Cigar & card lounge', 'Guest suites'],
        'Work'     => ['Co-working lounge', 'Private meeting pods', 'Business centre', 'Library & reading room', 'High-speed fibre backbone'],
        'Family'   => ['Toddler play zone', 'Creche & day-care', 'Teen activity room', 'Senior citizens’ court', 'Pet park & pet spa', 'Butterfly & herb garden'],
        'Estate'   => ['3-tier security with ANPR', 'Video door phone', '100% power backup', 'EV charging bays', 'Rainwater harvesting', 'On-site STP', 'Solar-assisted lighting', 'Concierge desk'],
    ],

    /* One line of context per amenity category — keeps the panel from
       looking thin next to the category rail. */
    'amenity_intros' => [
        'Wellness' => 'A whole floor given to recovery — water, heat, breath and quiet.',
        'Sport'    => 'Courts and tracks laid out so a game never waits on a booking sheet.',
        'Social'   => 'Rooms that hold twelve people or two hundred without feeling borrowed.',
        'Work'     => 'A full workday that never leaves the estate — and never happens at the dining table.',
        'Family'   => 'Zones drawn for the youngest and the oldest residents first.',
        'Estate'   => 'The infrastructure you stop noticing, because it simply always works.',
    ],

    /* --------------------------------------------- Location advantages ---- */
    'location' => [
        'Connectivity' => [
            ['Dwarka Expressway access',      'On it'],
            ['IGI Airport, Terminal 3',       '20 min'],
            ['Dwarka Sector 21 Metro',        '12 min'],
            ['NH-48 / Delhi border',          '10 min'],
            ['Proposed ISBT & Metro corridor','8 min'],
        ],
        'Work' => [
            ['Cyber City & Udyog Vihar', '25 min'],
            ['Aerocity',                 '18 min'],
            ['Diplomatic Enclave II',    '15 min'],
            ['Golf Course Road',         '28 min'],
        ],
        'Life' => [
            ['Delhi Public School',        '5 min'],
            ['Fortis & Medanta hospitals', '15 min'],
            ['Ambience Mall',              '20 min'],
            ['Yashobhoomi Convention Ctr', '12 min'],
            ['DLF Club 5',                 '22 min'],
        ],
    ],

    /* ------------------------------------------------------------ FAQ ---- */
    'faq' => [
        ['Where exactly is Coming Keys — The Reserve located?', 'The project sits on Sector 104, directly off the Dwarka Expressway in Gurugram, Haryana — 20 minutes from IGI Airport Terminal 3 and 12 minutes from the Dwarka Sector 21 metro interchange.'],
        ['What configurations and sizes are available?', 'The Reserve offers 2 BHK + Study (1,485 sq.ft), 3 BHK (1,890 sq.ft), 3 BHK + Servant (2,240 sq.ft), 4 BHK duplexes (3,150 sq.ft) and six sky penthouses of 4,600 sq.ft.'],
        ['What is the price range?', 'Prices start at ₹1.65 Cr for the 2 BHK + Study and go up to ₹3.85 Cr for the 4 BHK duplex. Penthouse pricing is shared on request. All prices are exclusive of GST, IFMS, and statutory charges.'],
        ['When is possession?', 'Possession is scheduled for December 2028, in line with the HARERA-registered completion date. Construction-linked and subvention payment plans are both available.'],
        ['Is the project RERA registered?', 'Yes. The project is registered with the Haryana Real Estate Regulatory Authority under registration number RC/REP/HARERA/GGM/2026/04/1187. Details are verifiable at haryanarera.gov.in.'],
        ['Are home loans pre-approved?', 'Yes — the project is approved by SBI, HDFC, ICICI, Axis and LIC Housing Finance, with loans up to 80% of agreement value and doorstep documentation.'],
        ['Can I book a site visit?', 'Absolutely. Complimentary chauffeur pick-up and drop is offered within Delhi NCR for scheduled site visits. Share your number and our team confirms a slot within 30 minutes.'],
    ],

    /* -------------------------------------------------------- Gallery ---- */
    'gallery' => [
        ['id' => 'hero',    'cap' => 'The Reserve — tower elevation',   'span' => 'lg:col-span-2 lg:row-span-2'],
        ['id' => 'living',  'cap' => 'Living room, 3 BHK',     'span' => ''],
        ['id' => 'pool',    'cap' => 'The 70 m infinity pool', 'span' => ''],
        ['id' => 'bedroom', 'cap' => 'Primary bedroom',        'span' => ''],
        ['id' => 'gym',     'cap' => 'Double-height gym',      'span' => ''],
        ['id' => 'lounge',  'cap' => 'Clubhouse lounge',       'span' => 'lg:col-span-2'],
        ['id' => 'skyline', 'cap' => 'Façade detail, Tower C',        'span' => ''],
        ['id' => 'kitchen', 'cap' => 'Chef’s kitchen',         'span' => ''],
    ],

    /* ---------------------------------------------------------- Media ---- */
    'seo' => [
        'title'   => 'Coming Keys — The Reserve | 3 & 4 BHK Luxury Apartments on Dwarka Expressway, Gurugram',
        'desc'    => 'Coming Keys — The Reserve: 14.2-acre gated estate of 3 & 4 BHK sky residences on Dwarka Expressway, Sector 104 Gurugram. Prices from ₹1.65 Cr. 82% open space, 45+ amenities, possession Dec 2028. RERA registered. Book a site visit.',
        'url'     => 'https://www.comingkeys.com/',
        'og'      => 'https://www.comingkeys.com/assets/img/hero.jpg',
        'keywords'=> '3 BHK Dwarka Expressway, luxury apartments Gurugram, Sector 104 Gurugram flats, Coming Keys, new launch Gurugram, 4 BHK duplex Gurugram',
    ],
];
