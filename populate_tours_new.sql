-- Populate tours table with new tour data from provided JSON
-- Note: This script assumes categories are inserted
-- Insert categories if not exist
INSERT INTO categories (name, description, type)
VALUES ('Short Tours', 'Short duration tours', 'tour'),
    ('Day Tours', 'Day tours', 'tour'),
    (
        'Extended Golden Triangle Tours',
        'Extended Golden Triangle tours',
        'tour'
    ),
    ('Train Tours', 'Train based tours', 'tour'),
    ('Luxury Tours', 'Luxury tours', 'tour'),
    ('Wildlife Tours', 'Wildlife tours', 'tour'),
    ('Extended Tours', 'Extended tours', 'tour'),
    ('Day Trips', 'Day trips', 'tour'),
    ('Rajasthan Tours', 'Rajasthan tours', 'tour'),
    ('Food Tours', 'Food tasting tours', 'tour'),
    ('City Tours', 'City tours', 'tour') ON DUPLICATE KEY
UPDATE id = id;
-- Insert tours data
INSERT INTO tours (
        title,
        slug,
        description,
        highlights,
        included,
        excluded,
        itinerary,
        pricing,
        images,
        dates,
        availability,
        category_id,
        location,
        duration,
        rating,
        view_count
    )
VALUES (
        'from delhi 2days agra and jaipur tour by car',
        'from-delhi-2days-agra-and-jaipur-tour-by-car',
        'This 2 days Agra and Jaipur tour from Delhi by car is ideal for travelers who want to experience India’s most iconic Mughal and Rajput heritage in a short time. Starting from Delhi, the journey takes you to Agra to explore the majestic Taj Mahal, Agra Fort, and local handicraft markets. On the second day, continue towards Jaipur, the Pink City of Rajasthan, known for its royal palaces, forts, and vibrant culture. This tour is designed for comfort with a private air-conditioned car, professional driver, and flexible sightseeing schedule. It suits couples, families, and first-time visitors seeking a balanced mix of history, architecture, and local experiences. The route offers smooth highways, safe travel, and well-paced sightseeing without rush. With expert planning and reliable services, this tour ensures a memorable North India travel experience while covering two UNESCO World Heritage destinations efficiently.',
        '["Visit the Taj Mahal at Agra", "Explore Agra Fort and city attractions", "Sightseeing in Jaipur including Amber Fort", "Private AC car with experienced driver", "Comfortable overnight stay in Jaipur"]',
        '["Private air-conditioned car", "Hotel accommodation", "Professional driver", "All sightseeing as per itinerary", "Fuel, parking, and toll taxes"]',
        '["Monument entrance fees", "Personal expenses", "Meals not mentioned", "Camera or video charges", "Travel insurance"]',
        '["Day 1: Delhi to Agra sightseeing and drive to Jaipur", "Day 2: Jaipur sightseeing and return/drop"]',
        9999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Short Tours'
        ),
        'Delhi – Agra – Jaipur',
        '2 Days / 1 Night',
        5.00,
        0
    ),
    (
        'taj mahal sunrise tour from delhi',
        'taj-mahal-sunrise-tour-from-delhi',
        'The Taj Mahal Sunrise Tour from Delhi offers a magical opportunity to witness India’s most famous monument in the soft morning light. Departing early from Delhi, this tour ensures you reach Agra before sunrise to experience the Taj Mahal at its most serene and photogenic moment. The changing colors of the marble at dawn create an unforgettable visual experience. After the Taj Mahal visit, explore Agra Fort, a UNESCO World Heritage Site that reflects the grandeur of Mughal architecture. This tour is perfect for travelers with limited time who want a premium cultural experience in one day. With private transportation, a knowledgeable guide, and a well-planned schedule, the journey is smooth and comfortable. Ideal for couples, photographers, and history lovers, this sunrise tour provides a peaceful and crowd-free way to explore Agra’s iconic landmarks.',
        '["Sunrise visit to the Taj Mahal", "Guided tour of Agra Fort", "Same-day return to Delhi", "Private air-conditioned vehicle", "Professional local guide"]',
        '["Private AC car", "Driver allowance", "Local tour guide", "Sightseeing as planned", "All taxes and tolls"]',
        '["Monument entrance tickets", "Breakfast or meals", "Personal shopping expenses", "Camera fees", "Tips and gratuities"]',
        '["Early morning departure from Delhi", "Sunrise Taj Mahal visit", "Agra Fort sightseeing", "Return to Delhi by evening"]',
        5999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Day Tours'
        ),
        'Delhi – Agra – Delhi',
        'Same Day',
        5.00,
        0
    ),
    (
        'from delhi taj mahal and agra overnight tour',
        'from-delhi-taj-mahal-and-agra-overnight-tour',
        'This overnight Agra tour from Delhi allows travelers to explore the city at a relaxed pace without rushing through major attractions. Starting from Delhi, the journey takes you to Agra where you visit the Taj Mahal, Agra Fort, and local markets. An overnight stay in Agra gives you time to enjoy the city’s heritage, cuisine, and atmosphere beyond a single day. The tour is well-suited for couples and families who prefer comfortable travel with private transportation and flexible sightseeing. With experienced drivers and optional guided tours, this package ensures a smooth and enriching travel experience. The overnight stay also allows you to avoid long same-day travel fatigue while enjoying Agra’s Mughal charm. This tour combines convenience, comfort, and cultural depth, making it a popular choice for short North India getaways.',
        '["Visit Taj Mahal and Agra Fort", "Overnight stay in Agra", "Private car from Delhi", "Local market exploration", "Relaxed sightseeing schedule"]',
        '["Private AC vehicle", "Hotel accommodation", "Driver allowance", "Sightseeing as per plan", "All road taxes"]',
        '["Monument entry fees", "Meals unless specified", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1: Delhi to Agra sightseeing", "Day 2: Optional sunrise visit and return to Delhi"]',
        7999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Short Tours'
        ),
        'Delhi – Agra',
        '2 Days / 1 Night',
        5.00,
        0
    ),
    (
        'taj mahal sunrise and old delhi tour',
        'taj-mahal-sunrise-and-old-delhi-tour',
        'The Taj Mahal Sunrise and Old Delhi Tour combines two iconic experiences in one memorable journey. Begin early with a sunrise visit to the Taj Mahal in Agra, where the soft morning light enhances the monument’s beauty and calm atmosphere. After exploring Agra Fort, return to Delhi to discover the vibrant charm of Old Delhi. This part of the tour includes narrow lanes, historic mosques, bustling markets, and traditional street life. The contrast between Mughal elegance and Delhi’s lively heritage offers a complete cultural experience in a single day. Designed for travelers who want both monument sightseeing and authentic local exploration, the tour includes private transport and expert guidance. It is ideal for visitors interested in history, photography, and traditional Indian culture, all within a well-managed and time-efficient itinerary.',
        '["Sunrise Taj Mahal visit", "Agra Fort exploration", "Old Delhi heritage walk", "Private AC transportation", "Cultural and historical contrast"]',
        '["Private car with driver", "Local guide services", "Sightseeing as per itinerary", "Fuel and toll taxes", "All parking charges"]',
        '["Monument entrance fees", "Meals", "Personal expenses", "Camera charges", "Tips"]',
        '["Early departure from Delhi", "Sunrise Taj Mahal and Agra Fort", "Return to Delhi", "Old Delhi sightseeing"]',
        6999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Day Tours'
        ),
        'Delhi – Agra – Old Delhi',
        'Same Day',
        5.00,
        0
    ),
    (
        'golden triangle tour 4n5d',
        'golden-triangle-tour-4n5d',
        'The Golden Triangle Tour 4N5D is one of the most popular travel circuits in India, covering Delhi, Agra, and Jaipur. This well-paced itinerary allows travelers to explore historical landmarks, royal palaces, and cultural heritage across North India. Starting in Delhi, the tour moves to Agra to witness the Taj Mahal and Mughal architecture, followed by Jaipur, known for its forts, palaces, and colorful markets. The five-day duration ensures comfortable travel without rushing, making it suitable for families and first-time visitors. With private transportation, guided sightseeing, and quality accommodations, this tour offers a complete introduction to India’s rich history and traditions. The Golden Triangle route is ideal for understanding the diversity, architecture, and lifestyle of North India in a structured and enjoyable way.',
        '["Delhi city sightseeing", "Taj Mahal and Agra Fort", "Jaipur forts and palaces", "Private car tour", "Balanced travel pace"]',
        '["Private AC vehicle", "Hotel accommodation", "Driver allowance", "Sightseeing as per plan", "All tolls and taxes"]',
        '["Monument entry tickets", "Meals not mentioned", "Personal expenses", "Camera fees", "Insurance"]',
        '["Day 1: Arrival in Delhi sightseeing", "Day 2: Delhi to Agra", "Day 3: Agra to Jaipur", "Day 4: Jaipur sightseeing", "Day 5: Departure"]',
        18999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Golden Triangle Tours'
        ),
        'Delhi – Agra – Jaipur',
        '5 Days / 4 Nights',
        5.00,
        0
    ),
    (
        'golden triangle tour with amritsar 6n7d',
        'golden-triangle-tour-with-amritsar-6n7d',
        'The Golden Triangle Tour with Amritsar 6N7D extends the classic Delhi, Agra, and Jaipur circuit by adding the spiritual and cultural city of Amritsar. Along with iconic attractions like the Taj Mahal and Jaipur’s royal forts, this tour includes a visit to the Golden Temple, one of India’s most sacred sites. The itinerary blends history, spirituality, and cultural diversity, offering travelers a deeper understanding of North India. Comfortable travel arrangements, guided sightseeing, and well-planned routes ensure a smooth experience across multiple cities. This tour is ideal for travelers seeking both heritage and spiritual enrichment within a single journey. From Mughal monuments to Sikh traditions, the tour offers a balanced and meaningful travel experience.',
        '["Golden Temple visit in Amritsar", "Classic Golden Triangle sightseeing", "Wagah Border ceremony", "Private guided tour", "Cultural and spiritual experience"]',
        '["Private AC transportation", "Hotel accommodation", "Driver allowance", "Sightseeing as per itinerary", "All road taxes"]',
        '["Monument entry fees", "Meals not mentioned", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1-2: Delhi sightseeing", "Day 3: Agra visit", "Day 4: Jaipur sightseeing", "Day 5-6: Amritsar visit", "Day 7: Departure"]',
        29999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Extended Golden Triangle Tours'
        ),
        'Delhi – Agra – Jaipur – Amritsar',
        '7 Days / 6 Nights',
        5.00,
        0
    ),
    (
        'taj mahal tour by gatimaan express train',
        'taj-mahal-tour-by-gatimaan-express-train',
        'The Taj Mahal Tour by Gatimaan Express Train is the fastest and most comfortable way to visit Agra from Delhi. Gatimaan Express offers a smooth and time-efficient rail journey, allowing travelers to maximize sightseeing time in Agra. This tour includes a guided visit to the Taj Mahal and Agra Fort, making it ideal for travelers who prefer train travel over long road journeys. With early morning departure and same-day return, the tour is perfect for business travelers, families, and senior citizens. The combination of modern train facilities and well-organized local transfers ensures a hassle-free experience. This tour provides a convenient, reliable, and comfortable option to explore Agra’s iconic monuments in one day.',
        '["Fast Gatimaan Express train journey", "Guided Taj Mahal visit", "Agra Fort sightseeing", "Same-day return", "Comfortable and time-saving travel"]',
        '["Train tickets", "Local AC transport in Agra", "Tour guide", "Sightseeing as planned", "All applicable taxes"]',
        '["Monument entrance fees", "Meals other than train service", "Personal expenses", "Camera charges", "Tips"]',
        '["Morning train from Delhi", "Taj Mahal and Agra Fort visit", "Evening return by train"]',
        6499.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Train Tours'
        ),
        'Delhi – Agra – Delhi',
        'Same Day',
        5.00,
        0
    ),
    (
        'golden triangle tours with varanasi 5n6d',
        'golden-triangle-tours-with-varanasi-5n6d',
        'The Golden Triangle Tour with Varanasi combines North India’s most famous heritage cities with one of the world’s oldest living spiritual centers. Along with Delhi, Agra, and Jaipur, this tour includes Varanasi, known for its sacred ghats, temples, and spiritual rituals along the Ganges River. The itinerary offers a perfect mix of history, culture, and spirituality. Travelers experience Mughal monuments, Rajput architecture, and deeply rooted religious traditions in one comprehensive journey. Comfortable transportation, guided sightseeing, and well-planned stays ensure a smooth experience. This tour is ideal for travelers seeking both cultural exploration and spiritual insight within a limited timeframe.',
        '["Ganga Aarti in Varanasi", "Golden Triangle sightseeing", "Taj Mahal and Jaipur forts", "Cultural and spiritual blend", "Private guided travel"]',
        '["Private AC transport", "Hotel accommodation", "Driver allowance", "Sightseeing as per plan", "All taxes"]',
        '["Monument entry fees", "Meals not specified", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1: Delhi sightseeing", "Day 2: Agra visit", "Day 3: Jaipur sightseeing", "Day 4-5: Varanasi visit", "Day 6: Departure"]',
        26999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Golden Triangle Tours'
        ),
        'Delhi – Agra – Jaipur – Varanasi',
        '6 Days / 5 Nights',
        5.00,
        0
    ),
    (
        'taj mahal and agra tour by premium cars',
        'taj-mahal-and-agra-tour-by-premium-cars',
        'The Taj Mahal and Agra Tour by Premium Cars is designed for travelers who value comfort, privacy, and luxury while exploring Agra’s iconic attractions. This tour includes a private premium vehicle with professional chauffeur service, ensuring a smooth and stylish journey from Delhi to Agra. Visit the Taj Mahal, Agra Fort, and other local highlights at a relaxed pace. Ideal for couples, business travelers, and luxury seekers, the tour focuses on personalized service and flexible scheduling. The premium car experience enhances overall comfort, making the journey as enjoyable as the destination. This tour offers a refined way to explore Agra in a single day or with optional extensions.',
        '["Luxury premium car travel", "Taj Mahal and Agra Fort visit", "Personalized itinerary", "Professional chauffeur", "Comfort-focused experience"]',
        '["Premium AC vehicle", "Driver allowance", "Sightseeing as planned", "Fuel and tolls", "All taxes"]',
        '["Monument entry tickets", "Meals", "Personal expenses", "Camera charges", "Tips"]',
        '["Morning departure from Delhi", "Agra sightseeing", "Return to Delhi"]',
        8999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Luxury Tours'
        ),
        'Delhi – Agra',
        'Same Day',
        5.00,
        0
    ),
    (
        'golden triangle tour 2n3d',
        'golden-triangle-tour-2n3d',
        'The Golden Triangle Tour 2N3D is a compact itinerary covering Delhi, Agra, and Jaipur within three days. Designed for travelers with limited time, this tour focuses on key highlights such as the Taj Mahal, Jaipur’s forts, and Delhi’s historic landmarks. The route is efficient and well-organized, ensuring comfortable travel and maximum sightseeing. Ideal for first-time visitors, the tour provides a quick yet meaningful introduction to North India’s cultural heritage. Private transportation, guided sightseeing, and carefully selected stops make this tour convenient and enjoyable. Despite its short duration, the tour captures the essence of the Golden Triangle experience.',
        '["Short Golden Triangle circuit", "Taj Mahal visit", "Jaipur heritage sightseeing", "Private AC car", "Time-efficient itinerary"]',
        '["Private transportation", "Hotel accommodation", "Driver allowance", "Sightseeing as planned", "All road taxes"]',
        '["Monument entry fees", "Meals not mentioned", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1: Delhi to Agra", "Day 2: Agra to Jaipur", "Day 3: Jaipur sightseeing and departure"]',
        14999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Golden Triangle Tours'
        ),
        'Delhi – Agra – Jaipur',
        '3 Days / 2 Nights',
        5.00,
        0
    ),
    (
        'from delhi day trip to taj mahal and agra fort by car',
        'from-delhi-day-trip-to-taj-mahal-and-agra-fort-by-car',
        'This day trip from Delhi to the Taj Mahal and Agra Fort by car is ideal for travelers seeking a comfortable and flexible same-day excursion. The journey begins early in the morning with a private air-conditioned car, allowing ample time to explore Agra’s most famous landmarks. Visit the Taj Mahal, one of the Seven Wonders of the World, followed by a guided tour of Agra Fort. The itinerary is designed to avoid rush and ensure a smooth return to Delhi by evening. Suitable for families, couples, and solo travelers, this tour offers convenience, safety, and a well-managed schedule for a memorable Agra visit.',
        '["Private car day trip", "Taj Mahal visit", "Agra Fort exploration", "Flexible sightseeing time", "Same-day return"]',
        '["Private AC car", "Driver allowance", "Sightseeing as per plan", "Fuel and toll taxes", "Parking charges"]',
        '["Monument entry tickets", "Meals", "Personal expenses", "Camera fees", "Tips"]',
        '["Morning departure from Delhi", "Taj Mahal and Agra Fort visit", "Evening return to Delhi"]',
        4999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Day Trips'
        ),
        'Delhi – Agra – Delhi',
        'Same Day',
        5.00,
        0
    ),
    (
        'golden triangle tour with udaipur 7n8d',
        'golden-triangle-tour-with-udaipur-7n8d',
        'The Golden Triangle Tour with Udaipur 7N8D combines North India’s iconic heritage cities with the romantic charm of Udaipur. Along with Delhi, Agra, and Jaipur, this tour includes Udaipur, known for its lakes, palaces, and serene atmosphere. The itinerary offers a balanced mix of history, royal architecture, and scenic beauty. Travelers enjoy comfortable travel, guided sightseeing, and carefully planned stays across multiple destinations. This extended tour is ideal for travelers seeking a deeper exploration of Rajasthan along with classic Golden Triangle highlights.',
        '["Golden Triangle sightseeing", "Udaipur lake and palace tour", "Royal Rajasthan experience", "Private guided travel", "Scenic and cultural diversity"]',
        '["Private AC transport", "Hotel accommodation", "Driver allowance", "Sightseeing as per itinerary", "All applicable taxes"]',
        '["Monument entry fees", "Meals not specified", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1-2: Delhi sightseeing", "Day 3: Agra visit", "Day 4-5: Jaipur sightseeing", "Day 6-7: Udaipur visit", "Day 8: Departure"]',
        34999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Extended Tours'
        ),
        'Delhi – Agra – Jaipur – Udaipur',
        '8 Days / 7 Nights',
        5.00,
        0
    ),
    (
        'golden triangle tour with ranthambore 4n5d',
        'golden-triangle-tour-with-ranthambore-4n5d',
        'The Golden Triangle Tour with Ranthambore 4N5D adds a wildlife experience to the classic Delhi, Agra, and Jaipur circuit. Along with visiting the Taj Mahal and Jaipur’s forts, travelers enjoy a jungle safari in Ranthambore National Park, known for its tiger population. This tour offers a unique blend of heritage and nature, making it ideal for wildlife enthusiasts and families. The itinerary is well-balanced, ensuring comfortable travel and sufficient time for sightseeing and safari activities. With professional planning and reliable transport, the tour provides a memorable North India experience beyond traditional city tours.',
        '["Ranthambore jungle safari", "Taj Mahal and Agra Fort", "Jaipur heritage sightseeing", "Wildlife and culture blend", "Private guided tour"]',
        '["Private AC transportation", "Hotel accommodation", "Driver allowance", "Safari (subject to availability)", "All road taxes"]',
        '["Monument entry fees", "Safari permit extras", "Meals not specified", "Personal expenses", "Insurance"]',
        '["Day 1: Delhi sightseeing", "Day 2: Agra visit", "Day 3: Ranthambore safari", "Day 4: Jaipur sightseeing", "Day 5: Departure"]',
        27999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Wildlife Tours'
        ),
        'Delhi – Agra – Ranthambore – Jaipur',
        '5 Days / 4 Nights',
        5.00,
        0
    ),
    (
        'golden triangle toui 3n4d',
        'golden-triangle-toui-3n4d',
        'The Golden Triangle Toui 3N4D is a well-structured tour covering Delhi, Agra, and Jaipur over four days. Designed for travelers seeking a slightly relaxed pace compared to shorter itineraries, this tour allows more time at each destination. Explore Delhi’s historic sites, witness the beauty of the Taj Mahal in Agra, and experience Jaipur’s royal heritage. The itinerary balances travel and sightseeing, ensuring comfort and cultural immersion. Ideal for families and first-time visitors, the tour offers a comprehensive introduction to North India’s most famous travel circuit.',
        '["Four-day Golden Triangle tour", "Taj Mahal and Agra Fort", "Jaipur forts and palaces", "Comfortable private transport", "Balanced itinerary"]',
        '["Private AC vehicle", "Hotel accommodation", "Driver allowance", "Sightseeing as per plan", "All applicable taxes"]',
        '["Monument entry tickets", "Meals not mentioned", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1: Delhi sightseeing", "Day 2: Agra visit", "Day 3: Jaipur sightseeing", "Day 4: Departure"]',
        17999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Golden Triangle Tours'
        ),
        'Delhi – Agra – Jaipur',
        '4 Days / 3 Nights',
        5.00,
        0
    ),
    (
        'royal rajasthan tour 5n6d',
        'royal-rajasthan-tour-5n6d',
        'The Royal Rajasthan Tour 5N6D showcases the grandeur, culture, and royal heritage of Rajasthan. This tour covers major cities known for palaces, forts, and vibrant traditions. Travelers experience historic architecture, colorful markets, and traditional Rajasthani hospitality. The itinerary is designed for comfortable travel with guided sightseeing and quality accommodations. Ideal for cultural explorers, this tour highlights Rajasthan’s royal past and living traditions. From majestic forts to local experiences, the journey offers a deep insight into one of India’s most culturally rich states.',
        '["Royal forts and palaces", "Cultural city tours", "Traditional Rajasthani experience", "Private guided travel", "Comfortable itinerary"]',
        '["Private AC transport", "Hotel accommodation", "Driver allowance", "Sightseeing as planned", "All road taxes"]',
        '["Monument entry fees", "Meals not specified", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1-2: Arrival and city sightseeing", "Day 3-4: Heritage tours", "Day 5-6: Departure"]',
        24999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Rajasthan Tours'
        ),
        'Rajasthan',
        '6 Days / 5 Nights',
        5.00,
        0
    ),
    (
        'old delhi food tasting tour evening 4 hours',
        'old-delhi-food-tasting-tour-evening-4-hours',
        'The Old Delhi Food Tasting Tour is a guided evening experience that introduces travelers to the rich culinary heritage of Delhi. Over four hours, explore narrow lanes, historic markets, and iconic food spots known for traditional recipes. The tour offers insight into local culture, history, and flavors through curated tastings. Ideal for food lovers and cultural explorers, this experience focuses on authenticity and safety. Guided by local experts, travelers enjoy a flavorful journey through Old Delhi’s vibrant street food scene while learning about the area’s heritage.',
        '["Guided food tasting experience", "Traditional Old Delhi cuisine", "Local market exploration", "Cultural storytelling", "Evening walking tour"]',
        '["Local food tastings", "Professional guide", "Walking tour", "Cultural insights", "All service charges"]',
        '["Personal purchases", "Extra food or drinks", "Transportation", "Tips", "Insurance"]',
        '["Evening meeting point", "Food tasting stops", "Market walk and local insights"]',
        2499.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Food Tours'
        ),
        'Old Delhi',
        '4 Hours',
        5.00,
        0
    ),
    (
        'colorful rajasthan tour 8d9n',
        'colorful-rajasthan-tour-8d9n',
        'The Colorful Rajasthan Tour 8D9N offers an in-depth exploration of Rajasthan’s diverse culture, architecture, and landscapes. This extended itinerary covers multiple cities known for forts, palaces, deserts, and traditional lifestyles. Travelers experience vibrant markets, local traditions, and historical landmarks at a relaxed pace. Designed for cultural enthusiasts, the tour highlights Rajasthan’s royal legacy and everyday life. Comfortable transportation, guided sightseeing, and thoughtfully planned stays ensure a rich and immersive travel experience across the state.',
        '["Extended Rajasthan exploration", "Multiple heritage cities", "Cultural and local experiences", "Traditional markets", "Comfort-focused itinerary"]',
        '["Private AC transport", "Hotel accommodation", "Driver allowance", "Sightseeing as per plan", "All taxes"]',
        '["Monument entry fees", "Meals not specified", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1-3: Major city sightseeing", "Day 4-6: Cultural experiences", "Day 7-8: Heritage tours", "Day 9: Departure"]',
        39999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Rajasthan Tours'
        ),
        'Rajasthan',
        '9 Days / 8 Nights',
        5.00,
        0
    ),
    (
        'rajasthan heritage tour 4n5d',
        'rajasthan-heritage-tour-4n5d',
        'The Rajasthan Heritage Tour 4N5D focuses on the historical and architectural legacy of Rajasthan. This tour includes visits to famous forts, palaces, and heritage sites that reflect the royal past of the region. Designed for travelers interested in history and culture, the itinerary offers guided sightseeing and comfortable travel. The tour provides a concise yet enriching experience of Rajasthan’s heritage within a manageable timeframe.',
        '["Historic forts and palaces", "Guided heritage sightseeing", "Cultural city tours", "Comfortable travel", "Short heritage itinerary"]',
        '["Private AC transport", "Hotel accommodation", "Driver allowance", "Sightseeing as planned", "All road taxes"]',
        '["Monument entry fees", "Meals not specified", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1: Arrival and city tour", "Day 2-4: Heritage sightseeing", "Day 5: Departure"]',
        22999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Rajasthan Tours'
        ),
        'Rajasthan',
        '5 Days / 4 Nights',
        5.00,
        0
    ),
    (
        'rajasthan city tour 3n4d',
        'rajasthan-city-tour-3n4d',
        'The Rajasthan City Tour 3N4D is a short and focused itinerary covering key urban destinations in Rajasthan. The tour highlights city-based attractions, including palaces, forts, markets, and cultural landmarks. Ideal for travelers with limited time, this tour provides a structured introduction to Rajasthan’s urban heritage. Comfortable travel arrangements and guided sightseeing ensure a smooth experience while capturing the essence of the region.',
        '["Key Rajasthan city attractions", "Palaces and forts", "Local markets", "Short and efficient itinerary", "Guided sightseeing"]',
        '["Private AC transportation", "Hotel accommodation", "Driver allowance", "Sightseeing as per plan", "All taxes"]',
        '["Monument entry fees", "Meals not mentioned", "Personal expenses", "Camera charges", "Insurance"]',
        '["Day 1: Arrival and city tour", "Day 2-3: Sightseeing", "Day 4: Departure"]',
        18499.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'Rajasthan Tours'
        ),
        'Rajasthan',
        '4 Days / 3 Nights',
        5.00,
        0
    ),
    (
        'delhi private day tour by car',
        'delhi-private-day-tour-by-car',
        'The Delhi Private Day Tour by Car offers a comfortable and personalized way to explore India’s capital city. This tour covers major historical, cultural, and modern attractions of Delhi with a flexible schedule. Ideal for first-time visitors and families, the private car ensures convenience and safety. With optional guided commentary, travelers gain insights into Delhi’s rich past and vibrant present. The tour is designed to be relaxed, informative, and customizable according to interests.',
        '["Private car city tour", "Major Delhi attractions", "Flexible itinerary", "Comfortable travel", "Optional local guide"]',
        '["Private AC vehicle", "Driver allowance", "Sightseeing as per plan", "Fuel and toll taxes", "Parking charges"]',
        '["Monument entry fees", "Meals", "Personal expenses", "Camera charges", "Tips"]',
        '["Morning pickup", "City sightseeing", "Evening drop-off"]',
        3999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'City Tours'
        ),
        'Delhi',
        'Same Day',
        5.00,
        0
    ),
    (
        'evening delhi city tour 4 hours',
        'evening-delhi-city-tour-4-hours',
        'The Evening Delhi City Tour is a short and relaxed exploration of Delhi’s prominent landmarks during the cooler evening hours. Ideal for travelers with limited time, this tour focuses on illuminated monuments, local streets, and cultural spots. The four-hour duration allows a comfortable pace while enjoying the city’s atmosphere after sunset. With private transportation and optional guidance, the tour offers a pleasant introduction to Delhi’s charm in the evening.',
        '["Evening sightseeing experience", "Illuminated landmarks", "Short city tour", "Comfortable private travel", "Relaxed schedule"]',
        '["Private AC car", "Driver allowance", "Sightseeing as planned", "Fuel and toll taxes", "Parking charges"]',
        '["Monument entry fees", "Meals", "Personal expenses", "Camera charges", "Tips"]',
        '["Evening pickup", "City sightseeing", "Drop-off"]',
        2999.00,
        '[]',
        0,
        (
            SELECT id
            FROM categories
            WHERE name = 'City Tours'
        ),
        'Delhi',
        '4 Hours',
        5.00,
        0
    );