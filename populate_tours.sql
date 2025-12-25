-- Populate tours table with existing tour data
-- Note: This script assumes categories are already created

-- Insert tours data
INSERT INTO tours (title, slug, description, itinerary, pricing, images, category_id, location, duration, rating) VALUES
('Taj Mahal Sunrise Tour From Delhi', 'taj-mahal-sunrise-tour-from-delhi',
 'Embark on a magical journey to witness the Taj Mahal at sunrise, when the first rays of the sun illuminate the marble monument in breathtaking golden hues. This exclusive sunrise tour from Delhi offers photographers and travelers the chance to experience the Taj Mahal\'s ethereal beauty at its most serene moment, away from the daytime crowds.',
 'Early Morning: Depart Delhi at 4 AM for Agra.\nSunrise at Taj Mahal: Witness the golden illumination.\nExplore Taj Mahal: Guided tour of the complex and gardens.\nPhotography Session: Capture stunning sunrise shots.\nVisit Agra Fort: Explore nearby Mughal architecture.\nBreakfast: Traditional Indian meal.\nReturn to Delhi: Afternoon arrival with memories to cherish.',
 4500.00, '["sunrise-taj.webp"]', (SELECT id FROM categories WHERE name = 'Taj Mahal Tours' LIMIT 1), 'Delhi Taj Mahal', '1 Day', 4.8),

('Taj Mahal And Agra Overnight Tour', 'from-delhi-taj-mahal-and-agra-overnight-tour',
 'Experience the Taj Mahal and Agra on an overnight tour from Delhi. Visit the iconic Taj Mahal, explore Agra Fort, and enjoy a comfortable overnight stay with authentic local experiences.',
 'Day 1: Delhi to Agra transfer, Taj Mahal visit, Agra Fort exploration, overnight stay in Agra.\nDay 2: Morning at leisure, transfer back to Delhi.',
 6500.00, '["agra-tour-1.webp"]', (SELECT id FROM categories WHERE name = 'Taj Mahal Tours' LIMIT 1), 'Delhi Taj Mahal', '2 Days', 4.9),

('Golden Triangle Tour 4N5D', 'golden-triangle-tour-4n5d',
 'Explore the Golden Triangle of India - Delhi, Agra, and Jaipur on this comprehensive 5-day tour. Visit iconic monuments, palaces, and experience the rich cultural heritage of Rajasthan.',
 'Day 1: Delhi arrival and city tour.\nDay 2: Agra - Taj Mahal and Agra Fort.\nDay 3: Jaipur - Amber Fort and City Palace.\nDay 4: Jaipur sightseeing.\nDay 5: Delhi departure.',
 18500.00, '["golden-tour.webp"]', (SELECT id FROM categories WHERE name = 'Golden Triangle Tours' LIMIT 1), 'Delhi, Agra, Jaipur, India', '5 Days', 4.9),

('Old Delhi Food Tasting Tour', 'old-delhi-food-tasting-tour',
 'Discover the vibrant street food culture of Old Delhi on this culinary adventure. Sample authentic Indian delicacies, learn about local traditions, and experience the bustling markets of India\'s historic capital.',
 'Morning pickup from hotel, visit to Chandni Chowk market, food tasting at local eateries, spice market visit, return to hotel.',
 1200.00, '["delhi-food-taste.webp"]', (SELECT id FROM categories WHERE name = 'Same Day Tours' LIMIT 1), 'Old Delhi', '4 hours', 4.7),

('Delhi Private Day Tour By Car', 'delhi-private-day-tour-by-car',
 'Experience Delhi\'s rich history and culture on a private day tour. Visit Old Delhi and New Delhi, explore Mughal monuments, and enjoy personalized sightseeing with your own guide and vehicle.',
 'Morning pickup, Red Fort visit, Jama Masjid, Chandni Chowk market, afternoon in New Delhi - India Gate, Parliament House, Lotus Temple, return to hotel.',
 3500.00, '["private-car.webp"]', (SELECT id FROM categories WHERE name = 'Same Day Tours' LIMIT 1), 'Old And New Delhi', '1 day', 4.8),

('Taj Mahal Sunrise And Old Delhi Tour', 'taj-mahal-sunrise-and-old-delhi-tour',
 'Combine the magic of Taj Mahal at sunrise with the historic charm of Old Delhi. Experience the best of both Mughal and colonial Delhi in one comprehensive day tour.',
 'Early morning departure for Agra, Taj Mahal sunrise viewing, Agra Fort visit, return to Delhi, Old Delhi sightseeing including Red Fort and Jama Masjid.',
 5500.00, '["taj-old-delhi.webp"]', (SELECT id FROM categories WHERE name = 'Taj Mahal Tours' LIMIT 1), 'Delhi Taj Mahal', '1 day', 4.9),

('Taj Mahal Tour By Gatimaan Express Train', 'taj-mahal-tour-by-gatimaan-express-train',
 'Experience the fastest way to reach Agra from Delhi on the Gatimaan Express. Visit the Taj Mahal and return to Delhi in the same day with this efficient and comfortable train journey.',
 'Morning train from Delhi to Agra, Taj Mahal visit, Agra Fort exploration, afternoon train back to Delhi.',
 4200.00, '["gatiman.webp"]', (SELECT id FROM categories WHERE name = 'Taj Mahal Tours' LIMIT 1), 'Delhi Taj Mahal', '1 Day', 4.8),

('Golden Triangle Tour with Varanasi 5N6D', 'golden-triangle-tours-with-varanasi-5n6d',
 'Extend your Golden Triangle tour to include the spiritual city of Varanasi. Experience the contrast between Rajasthan\'s royal heritage and the sacred ghats of Varanasi.',
 'Day 1-4: Golden Triangle itinerary.\nDay 5: Transfer to Varanasi.\nDay 6: Varanasi sightseeing and departure.',
 24500.00, '["varanashi-tour.webp"]', (SELECT id FROM categories WHERE name = 'Golden Triangle Tours' LIMIT 1), 'Delhi, Agra, Jaipur And Varanasi', '6 Days', 4.9),

('Golden Triangle Tour with Udaipur 7N8D', 'golden-triangle-tour-with-udaipur-7n8d',
 'Enhance your Golden Triangle experience with a visit to the romantic city of Udaipur. Explore Rajasthan\'s royal heritage with the added charm of Udaipur\'s lakes and palaces.',
 'Day 1-5: Golden Triangle itinerary.\nDay 6-7: Udaipur sightseeing.\nDay 8: Departure.',
 28500.00, '["udaipur-tour.webp"]', (SELECT id FROM categories WHERE name = 'Golden Triangle Tours' LIMIT 1), 'Delhi, Agra, Jaipur And Udaipur', '6 days', 4.9),

('Golden Triangle Tour with Ranthambore 4N5D', 'golden-triangle-tour-with-ranthambore-4n5d',
 'Combine heritage sightseeing with wildlife adventure. Visit the Golden Triangle cities and experience tiger safaris in Ranthambore National Park.',
 'Day 1-3: Delhi and Agra sightseeing.\nDay 4: Jaipur and transfer to Ranthambore.\nDay 5: Tiger safari and departure.',
 22500.00, '["ranthambroe.webp"]', (SELECT id FROM categories WHERE name = 'Golden Triangle Tours' LIMIT 1), 'Delhi, Agra, Jaipur And Ranthambore', '5 days', 4.8),

('Golden Triangle Tour with Amritsar 6N7D', 'golden-triangle-tour-with-amritsar-6n7d',
 'Experience the Golden Triangle with a visit to the holy city of Amritsar. Witness the grandeur of the Golden Temple and explore Punjab\'s rich Sikh heritage.',
 'Day 1-5: Golden Triangle itinerary.\nDay 6: Transfer to Amritsar and sightseeing.\nDay 7: Golden Temple visit and departure.',
 26500.00, '["amritsar-tour.webp"]', (SELECT id FROM categories WHERE name = 'Golden Triangle Tours' LIMIT 1), 'Delhi, Agra, Jaipur And Amritsar', '7 days', 4.9),

('Taj Mahal And Agra Tour By Premium Car', 'taj-mahal-and-agra-tour-by-premium-cars',
 'Travel in comfort to Agra in a premium car. Visit the Taj Mahal and Agra Fort with personalized service and luxury transportation.',
 'Morning departure from Delhi, Taj Mahal visit, Agra Fort exploration, return to Delhi in the evening.',
 4800.00, '["premium-car.webp"]', (SELECT id FROM categories WHERE name = 'Taj Mahal Tours' LIMIT 1), 'Delhi Taj Mahal', '1 day', 4.8),

('Evening Delhi City Tour 4 Hours', 'evening-delhi-city-tour-4-hours',
 'Experience Delhi after sunset on this evening city tour. Visit illuminated monuments and enjoy the city\'s vibrant nightlife.',
 'Evening pickup, visit to India Gate, Red Fort illuminated, Jama Masjid, return to hotel.',
 1500.00, '["evening-delhi.webp"]', (SELECT id FROM categories WHERE name = 'Same Day Tours' LIMIT 1), 'Delhi', '4 hours', 4.6),

('From Delhi Day Trip to Taj Mahal and Agra Fort by Car', 'from-delhi-day-trip-to-taj-mahal-and-agra-fort-by-car',
 'A comprehensive day trip from Delhi to visit both the Taj Mahal and Agra Fort. Experience the pinnacle of Mughal architecture in one day.',
 'Early morning departure, Taj Mahal visit, Agra Fort exploration, return to Delhi.',
 4000.00, '["day-trip-taj-agra.webp"]', (SELECT id FROM categories WHERE name = 'Taj Mahal Tours' LIMIT 1), 'Delhi Taj Mahal', '1 day', 4.8),

('Rajasthan Heritage Tour 4N5D', 'rajasthan-heritage-tour-4n5d',
 'Explore Rajasthan\'s royal heritage on this comprehensive tour. Visit magnificent palaces, forts, and experience the vibrant culture of the desert state.',
 'Day 1: Jaipur arrival and sightseeing.\nDay 2: Jaipur exploration.\nDay 3: Transfer to Jodhpur.\nDay 4: Jodhpur sightseeing.\nDay 5: Departure.',
 16500.00, '["rajasthan-heritage.webp"]', (SELECT id FROM categories WHERE name = 'Golden Triangle Tours' LIMIT 1), 'Jaipur, Jodhpur, Rajasthan', '5 days', 4.8),

('Colorful Rajasthan Tour 8D9N', 'colorful-rajasthan-tour-8d9n',
 'Experience the vibrant colors and rich heritage of Rajasthan on this extended tour. Visit multiple cities and immerse yourself in Rajasthani culture.',
 'Comprehensive itinerary covering major Rajasthan destinations with cultural experiences and heritage sites.',
 32000.00, '["rajasthan-colorful.webp"]', (SELECT id FROM categories WHERE name = 'Golden Triangle Tours' LIMIT 1), 'Rajasthan', '9 days', 4.9);