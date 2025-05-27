
# Project Title

Laptop Sales and Blog

## Project Description

This project is a comprehensive solution that combines a Point of Sale (POS) system and a blog system. It is specifically designed for selling new and second-hand laptops. The POS system enables efficient management of inventory, discounts, and effective customer interactions.

The primary purpose of blog system is to provide users with comprehensive and reliable information about laptops. My goal is to empower users with the knowledge they need to make informed decisions when purchasing laptops, whether they are interested in new or second-hand devices.

## Admin Features

- POS
- Brand Management:
  - Ability to create, update and delete brands.
  - Deletion of related products and images when deleting a brand.
- Product Management:
  - Ability to create, update and delete products.
- Product Order Management:
  - Ability to manage product orders.
- Blog
- Category Management:
  - Ability to create, update and delete categories.
  - Deletion of related posts and images when deleting a category. 
- Post Management:
  - Ability of create, update and delete posts.
- Post Comment Management:
  - can manage show or hide comments.
- User Management                                 
  - User creation with customizable roles and permissions.
  - Admin can manage roles for all users.
- Contact 
  - Admin can set contact details such as email, phone, and location map.

## Frondend Features

1. **Responsive Design**: The frontend is designed to be responsive, ensuring compatibility across different devices and screen sizes. Users can access and utilize the system seamlessly from desktops, laptops, tablets, and mobile devices.
2. **User Authentication**: The frontend includes a user authentication system that allows users to create accounts, log in, and manage their profiles. They can also reset password.
3. **Product Listings**: The frontend displays a comprehensive listing of available laptops, showcasing essential information such as product images, specifications, pricing, and availability. Users can easily browse and search for laptops based on their preferences and needs.
4. **Product Rating**: Authenticated users can access personalized features, such as rating products.
5. **Cart Validation**: 
  - Users are not allowed to proceed to the cart if it is empty.
  - Each product added to the cart must have a count greater than zero when users proceed to checkout. 
6. **Blog Section**:  The frontend incorporates a blog section that features informative and engaging articles related to laptops. And posts with other categories.
7. **Comment System**: The frontend includes a comment system for blog posts. Users can comment posts. *Authorized users have the ability to delete their own comments if necessary*.
8. **Like System**: Authenticated users can like posts.
9. **Contact Information**: The frontend provides contact information, including email, phone number, and location map, allowing users to easily reach out for inquiries, support, or further assistance.


## Technologies Used 

- Laravel (9)
- jQuery 
- Ajax
- HTML/CSS
- Javascript
- Bootstrap 5
- Fontawesome, Sweetalert 2, Ckeditor
- jQuery leaflet map location picker
- jQuery am_map.js

## Installation

- If cloning my project is complete or download is complete, open terminal in project directory.
- Install composer dependicies
  - **composer install** (command)
- Install npm dependicies
  - **npm install**
- Create a copy of .env file
  - **cp .env.example .env**
- Generate an app encryption key
  - **php artisan key:generate**
- Create an empty database for my web project
  - created database name must match from .env file
- Start npm 
  - **npm run build**
- Migrate
  - **php artisan migrate**
- Seed Database
  - **php artisan db:seed**
- link storage
  - **php artisan storage:link**
- Start 
  - **php artisan serve**
- type in url with port 
  - localhost:8000

## Usage

- Need Internet!
- In DatabaseSeeder.php, I created admin account.
- Login as admin,
  - Email - admin@gmail.com
  - Password - password

