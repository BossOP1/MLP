<?php
/**
 * Indiabulls Sector 104 — Landing Page Configuration
 * --------------------------------------------------
 * Operated by CK Technologies (brand: Gurgaon Property Experts), an
 * Authorized Channel Partner. This is not an official Indiabulls website.
 *
 * Every editable value lives here. Change these and the whole page updates.
 */

return [

    /* ------------------------------------------- Operator / channel ------ */
    'brand' => [
        'name'        => 'Gurgaon Property Experts',
        'legal_name'  => 'CK Technologies',
        'role'        => 'Authorized Channel Partner',
        'website'     => 'gurgaonpropertyexperts.com',
        'tagline'     => 'Key to Happiness',
        'phone'       => '+91 95993 00008',
        'phone_raw'   => '919599300008',
        'whatsapp'    => '919599300008',
        'email'       => 'info@gurgaonpropertyexperts.com',
        'gstin'       => '06AOBPG6584J1ZR',
        'address'     => 'House No 59, HUDA Sector 12, Panipat, Haryana 132103',
        'map_query'   => 'House+No+59+HUDA+Sector+12+Panipat+Haryana+132103',
        'locality'    => 'Panipat',
        'region'      => 'Haryana',
        'postal'      => '132103',
        'country'     => 'IN',
        'lat'         => '28.5355',
        'lng'         => '77.0450',
    ],

    /* -------------------------------------------------------- Project ---- */
    'project' => [
        'name'        => 'Indiabulls Sector 104',
        'developer'   => 'Indiabulls',
        'status'      => 'Under Construction',
        'eyebrow'     => 'New Launch · Dwarka Expressway, Gurugram',
        'headline'    => 'A private reserve of',
        'headline_em' => '3 & 3.5 BHK sky residences',
        'subline'     => '3 BHK luxury residences. Premium clubhouse. 30:70 payment plan. A limited collection of spacious homes on Dwarka Expressway, thoughtfully designed for elevated family living.',
        'price_from'  => '₹2.60 Cr',
        'price_upto'  => '₹3.10 Cr',
        'possession'  => 'Oct 2030',
        'address'     => 'Indiabulls Sector 104, Dwarka Expressway, Gurugram',
        'dev_office'  => 'Plot No. 448-451, Udyog Vihar, Phase-5, Gurugram, Haryana 122016',
        'rera'        => 'RC/REP/HARERA/GGM/160(A) of 2017/7(3)/89/2025/31',
        'rera_date'   => '17.10.2025',
        'rera_url'    => 'https://www.haryanarera.gov.in',
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
        'intro'      => 'Indiabulls sits in Sector 104, Gurugram, offering direct access to Dwarka Expressway with seamless connectivity to Delhi, IGI Airport and key business destinations across Gurugram.',
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

    /* ------------------------------------------------------------ FAQ ---- */
    'faq' => [
        ['Are you the official developer?', 'No. We are an Authorized Channel Partner and not officials of Indiabulls. This project is being developed by Indiabulls Limited.'],
        ['Who contacts me?', 'The sales team of CK Technologies will connect with you when you submit your information on gurgaonpropertyexperts.com.'],
        ['How do I verify your authorization?', 'Visit the Authorization Certificate and GST details published on this website.'],
        ['Is there an additional brokerage?', 'Contact the sales team for commercial details.'],
        ['Is the project RERA approved?', 'Yes. Indiabulls Sector 104 is RERA approved. Visit the government website for more details about the registration at www.haryanarera.gov.in.'],
        ['Can I book directly with the developer?', 'Yes.'],
    ],

    /* -------------------------------------------------------- Gallery ---- */
    'gallery' => [
        ['id' => 'hero',      'cap' => 'Towers and pool at night',  'span' => 'lg:col-span-2 lg:row-span-2'],
        ['id' => 'clubhouse', 'cap' => 'The clubhouse at dusk',     'span' => ''],
        ['id' => 'sports',    'cap' => 'Sports courts, aerial view','span' => ''],
        /* One 2x2 plus one 2x1 makes the eight tiles fill a 4-column grid
           exactly (4 + 2 + 6 = 12 cells); moving the wide tile elsewhere
           leaves a hole in the second row. */
        ['id' => 'greens',    'cap' => 'Tower and central green',   'span' => 'lg:col-span-2'],
        ['id' => 'courtyard', 'cap' => 'Landscaped courtyard',      'span' => ''],
        ['id' => 'arrival',   'cap' => 'The arrival court',         'span' => ''],
        ['id' => 'pooldeck',  'cap' => 'Poolside deck',             'span' => ''],
        ['id' => 'gardens',   'cap' => 'Landscaped gardens',        'span' => ''],
    ],

    /* ------------------------------------------------------------ SEO ---- */
    'seo' => [
        'title'   => 'Indiabulls Sector 104 | 3 & 3.5 BHK Luxury Apartments on Dwarka Expressway, Gurugram',
        'desc'    => 'Indiabulls Sector 104: 17-acre gated estate of 3 & 3.5 BHK residences on Dwarka Expressway, Gurugram. Prices from ₹2.60 Cr. 7 acres of greenery, premium clubhouse, 30:70 payment plan, possession Oct 2030. RERA registered. Enquire with an Authorized Channel Partner.',
        'url'     => 'https://www.gurgaonpropertyexperts.com/',
        'og'      => 'https://www.gurgaonpropertyexperts.com/assets/img/hero.jpg',
        'keywords'=> 'Indiabulls Sector 104, 3 BHK Dwarka Expressway, luxury apartments Gurugram, Sector 104 Gurugram flats, 3.5 BHK Gurugram',
    ],

    /* -------------------------------------------------- Legal & notices --- */
    'notices' => [
        /* Top announcement bar */
        'ticker' => 'CK Technologies | Authorized Channel Partner for Indiabulls High Rise Sector 104 | GSTIN: 06AOBPG6584J1ZR | HRERA Registered Project | This website is independently operated by CK Technologies and is not the official website of Indiabulls Limited.',

        /* Shown under every block of imagery on the page */
        'image'         => 'Renders are artistic impressions; finishes may vary by unit.',
        'gallery'       => 'Click any image to enlarge. Renders are artistic impressions; finishes may vary by unit.',

        /* Footer project block */
        'price_note'    => 'Prices are indicative and subject to change without prior notice.',
        'image_note'    => 'Images shown are artistic impressions and may differ from actual construction.',

        /* Footer master disclaimer */
        'disclaimer'    => 'This website (gurgaonpropertyexperts.com) is operated and maintained by CK Technologies by Gurgaon Property Experts, an Authorized Channel Partner for Indiabulls Sector 104, Gurugram. This is NOT the official website of Indiabulls Limited. Project details, prices, floor plans and specifications are subject to change. Images are artistic impressions. Trademarks belong to respective owners and only for Indiabulls.',
    ],
];
