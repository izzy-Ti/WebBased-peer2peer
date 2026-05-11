CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE items (
    id SERIAL PRIMARY KEY,
    provider_id INTEGER REFERENCES users(id),
    title VARCHAR(255) NOT NULL,
    description TEXT,
    price_per_day DECIMAL(10, 2) NOT NULL,
    image_url TEXT,
    status VARCHAR(20) DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rentals (
    id SERIAL PRIMARY KEY,
    item_id INTEGER REFERENCES items(id),
    consumer_id INTEGER REFERENCES users(id),
    status VARCHAR(20) DEFAULT 'pending', -- pending, approved, completed
    total_price DECIMAL(10, 2) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
