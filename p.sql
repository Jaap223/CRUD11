CREATE TABLE Categories (
    category_id INT PRIMARY KEY,
    category_name VARCHAR(255)
);

CREATE TABLE Customers (
    customer_id INT PRIMARY KEY,
    customer_name VARCHAR(255),
    email VARCHAR(255),
    phone_number VARCHAR(15)
);

CREATE TABLE Orders (
    order_id INT PRIMARY KEY,
    customer_id INT,
    order_date DATE,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id)
);

CREATE TABLE Products (
    product_id INT PRIMARY KEY,
    product_name VARCHAR(255),
    category_id INT,
    price DECIMAL(10, 2),
    stock_quantity INT,
    FOREIGN KEY (category_id) REFERENCES Categoriess(category_id)
);

CREATE TABLE OrderDetails (
    order_id INT,
    product_id INT,
    quantity INT,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);




INSERT INTO Categoriess (category_id, category_name)
VALUES
    (1, 'Electronics'),
    (2, 'Clothing'),
    (3, 'Books');


INSERT INTO Products (product_id, product_name, category_id, price, stock_quantity)
VALUES
    (1, 'Smartphone', 1, 499.99, 50),
    (2, 'Laptop', 1, 899.99, 30),
    (3, 'T-Shirt', 2, 19.99, 100),
    (4, 'Jeans', 2, 39.99, 75),
    (5, 'Programming Book', 3, 49.99, 20),
    (6, 'Cooking Book', 3, 29.99, 15);

INSERT INTO Customers (customer_id, customer_name, email)
VALUES
    (1, 'John Doe', 'john@example.com'),
    (2, 'Jane Smith', 'jane@example.com'),
    (3, 'Bob Johnson', 'bob@example.com');


INSERT INTO Orders (order_id, customer_id, order_date)
VALUES
    (1, 1, '2023-01-15'),
    (2, 2, '2023-02-20'),
    (3, 3, '2023-03-25');


INSERT INTO OrderDetails (order_id, product_id, quantity)
VALUES
    (1, 1, 2),
    (1, 4, 3),
    (2, 2, 1),
    (3, 6, 2);


    1
    SELECT product_name
FROM Products 
WHERE stock_quantity = 0;