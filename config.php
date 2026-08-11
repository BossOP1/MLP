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
        'headline_em' => '3 & 3.5 BHK sky residences',
        'subline'     => '3 BHK luxury residences. Premium clubhouse. 30:70 payment plan. A limited collection of spacious homes on Dwarka Expressway, thoughtfully designed for elevated family living.',
        'price_from'  => '₹2.60 Cr',
        'price_upto'  => '₹3.10 Cr',
        'possession'  => 'Oct 2030',
        'rera'        => 'RC/REP/HARERA/GGM/2026/04/1187',
        'rera_url'    => 'https://haryanarera.gov.in',
        'map_query'   => 'Sector+104+Dwarka+Expressway+Gurugram',
    ],

    /* ---------------------------------------------------------- Stats ---- */
    'stats' => [
        ['value' => 17, 'suffix' => '',  'label' => 'Acres of gated estate', 'decimals' => 0],
        ['value' => 7,  'suffix' => '',  'label' => 'Acres of open green',   'decimals' => 0],
        ['value' => 4,  'suffix' => '',  'label' => 'Towers',                'decimals' => 0],
        ['value' => 29, 'suffix' => '+', 'label' => 'Curated amenities',     'decimals' => 0],
    ],

    /* ----------------------------------------------------- Price table ---- */
    'plans' => [
        [
            'type'  => '3 BHK',
            'area'  => '2150',
            'beds'  => '3',   'beds_label'  => 'Bedrooms',
            'baths' => '3',   'baths_label' => 'Bathrooms',
            'price' => '₹2.60 Cr*',
            'tag'   => 'Best seller',
        ],
        [
            'type'  => '3 BHK + Servant',
            'area'  => '2650',
            'beds'  => '3+1', 'beds_label'  => 'Bedrooms + Study',
            'baths' => '4',   'baths_label' => 'Bathrooms',
            'price' => '₹3.10 Cr*',
            'tag'   => '',
        ],
    ],

    /* ------------------------------------------------------- Amenities ---- */
    'amenities' => [
        'Wellness' => ['Gym', 'Yoga / meditation lawns', 'Swimming pool', 'Indoor temperature-controlled pool', 'Spa & salon', 'Jogging & green spaces'],
        'Sport'    => ['Badminton courts', 'Tennis courts', 'Basketball court', 'Squash courts', 'Cricket practice nets', 'Skating rink', 'Football & sports areas'],
        'Social'   => ['Clubhouse', 'Multi-purpose community hall', 'Multi-cuisine restaurant', 'Barbecue deck', 'Outdoor pavilion & library', 'Indoor games zone'],
        'Family'   => ['Children’s play area', 'Indoor play area', 'Kids’ recreational spaces', 'Landscaped greens & gardens'],
        'Estate'   => ['17-acre project', '7 acres of greenery', 'Gated community', 'Dedicated parking', 'High-speed lifts', '24×7 security'],
    ],

    /* One line of context per amenity category — keeps the panel from
       looking thin next to the category rail. */
    'amenity_intros' => [
        'Wellness' => 'Water, movement and quiet — the everyday recovery of a resort, at home.',
        'Sport'    => 'Courts and tracks laid out so a game never waits on a booking sheet.',
        'Social'   => 'Rooms that hold twelve people or two hundred without feeling borrowed.',
        'Family'   => 'Zones drawn for the youngest residents first, indoors and out.',
        'Estate'   => 'The infrastructure you stop noticing, because it simply always works.',
    ],

    /* --------------------------------------------- Location advantages ---- */
    'location' => [
        'heading_a'  => 'On Dwarka Expressway.',
        'heading_em' => 'At the heart of it.',
        'intro'      => 'Indiabulls Heights sits in Sector 104, Gurugram, offering direct access to Dwarka Expressway with seamless connectivity to Delhi, IGI Airport and key business destinations across Gurugram.',
        'why_title'  => 'Why Sector 104',
        'why'        => 'A strategically located address with excellent road connectivity, close proximity to Delhi and the airport, and strong access to Gurugram’s evolving business and lifestyle hubs.',
        'list_title' => 'Key Connectivity',
        'connectivity' => [
            'Dwarka Expressway',
            'Delhi & IGI Airport',
            'NH-48',
            'Golf Course Road',
            'Cyber City & Gurugram business districts',
            'Delhi–Gurugram border',
            'Major NCR destinations',
        ],
        'schools_title' => 'Schools Nearby',
        'schools' => [
            'HSV International School',
            'Delhi Public School, Sector 102A & 103',
            'Gurugram Global Heights School, Sector 102',
            'Prime Scholars International School',
            'Imperial Heritage School',
        ],
    ],

    /* ------------------------------------------------- Office address ---- */
    'office' => [
        'name'      => 'CK Technologies',
        'address'   => 'House No. 59, HUDA Sector 12, Panipat, Haryana 132103',
        'map_query' => 'House+No+59+HUDA+Sector+12+Panipat+Haryana+132103',
    ],

    /* ------------------------------------------------------------ FAQ ---- */
    'faq' => [
        ['Where exactly is the project located?', 'The project sits in Sector 104, Gurugram, with direct access to the Dwarka Expressway and seamless connectivity to Delhi, IGI Airport, NH-48 and Gurugram’s business districts.'],
        ['What configurations and sizes are available?', 'Two layouts are offered: a 3 BHK of 2,150 sq.ft with 3 bedrooms and 3 bathrooms, and a 3 BHK + Servant of 2,650 sq.ft with 3+1 bedrooms, a study and 4 bathrooms.'],
        ['What is the price range?', 'Pricing starts at ₹2.60 Cr for the 3 BHK and ₹3.10 Cr for the 3 BHK + Servant. All prices are exclusive of GST, stamp duty, registration and other statutory charges.'],
        ['When is possession?', 'Possession is scheduled for October 2030, in line with the HARERA-registered completion date. A 30:70 construction-linked plan and a subvention plan are both available.'],
        ['Is the project RERA registered?', 'Yes. The project is registered with the Haryana Real Estate Regulatory Authority under registration number RC/REP/HARERA/GGM/2026/04/1187. Details are verifiable at haryanarera.gov.in.'],
        ['Are home loans pre-approved?', 'Yes — the project is approved for funding by SBI and HDFC, with doorstep documentation and assistance through sanction and disbursement.'],
        ['Can I book a site visit?', 'Absolutely. Complimentary chauffeur pick-up and drop is offered within Delhi NCR for scheduled site visits. Share your number and our team confirms a slot within 30 minutes.'],
    ],

    /* -------------------------------------------------------- Gallery ---- */
    'gallery' => [
        ['id' => 'hero',    'cap' => 'The Reserve — tower elevation', 'span' => 'lg:col-span-2 lg:row-span-2'],
        ['id' => 'living',  'cap' => 'Living room, 3 BHK',            'span' => ''],
        ['id' => 'pool',    'cap' => 'The swimming pool',             'span' => ''],
        ['id' => 'bedroom', 'cap' => 'Primary bedroom',               'span' => ''],
        ['id' => 'gym',     'cap' => 'The gymnasium',                 'span' => ''],
        ['id' => 'lounge',  'cap' => 'Clubhouse lounge',              'span' => 'lg:col-span-2'],
        ['id' => 'skyline', 'cap' => 'Façade detail',                 'span' => ''],
        ['id' => 'kitchen', 'cap' => 'Chef’s kitchen',                'span' => ''],
    ],

    /* ------------------------------------------------------------ SEO ---- */
    'seo' => [
        'title'   => 'Coming Keys — The Reserve | 3 & 3.5 BHK Luxury Apartments on Dwarka Expressway, Gurugram',
        'desc'    => 'Coming Keys — The Reserve: 17-acre gated estate of 3 & 3.5 BHK residences in Sector 104 on Dwarka Expressway, Gurugram. Prices from ₹2.60 Cr. 7 acres of greenery, premium clubhouse, 30:70 payment plan, possession Oct 2030. RERA registered. Book a site visit.',
        'url'     => 'https://www.comingkeys.com/',
        'og'      => 'https://www.comingkeys.com/assets/img/hero.jpg',
        'keywords'=> '3 BHK Dwarka Expressway, luxury apartments Gurugram, Sector 104 Gurugram flats, Coming Keys, new launch Gurugram, 3.5 BHK Gurugram',
    ],

    /* Shown under every block of imagery on the page. */
    'image_disclaimer' => 'Renders are artistic impressions; finishes may vary by unit.',
    'gallery_note'     => 'Click any image to enlarge. Renders are artistic impressions; finishes may vary by unit.',
];
