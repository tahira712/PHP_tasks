SELECT f.title, c.name AS category
FROM films f
JOIN categories c ON f.category_id = c.id;


-- 2
SELECT c.comment_text, u.username AS commenter
FROM comments c
JOIN users u ON c.user_id = u.id
JOIN films f ON c.film_id = f.id
WHERE f.title = 'Harry Potter Prisoner of Azkaban';
-- 3
SELECT f.title, f.release_date, c.name AS category
FROM wishlist w
JOIN films f ON w.film_id = f.id
JOIN categories c ON f.category_id = c.id
JOIN users u ON w.user_id = u.id
WHERE u.username = 'tahira';

-- 4
SELECT c.comment_text, u.username
FROM comments c
JOIN users u ON c.user_id = u.id;

-- 5
SELECT f.title, COUNT(c.id) AS comment_count
FROM films f
LEFT JOIN comments c ON f.id = c.film_id
GROUP BY f.title;

