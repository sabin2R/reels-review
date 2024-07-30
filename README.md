# Reel Review

## Setup Instructions

1. **Clone the Repository**:
    ```
    git clone https://github.com/sabin2R/reels-review.git
    cd reels-review
    ```

2. **Database Setup**:
    - Import the database tables and data using the provided SQL file.
    - Open phpMyAdmin and select the "Import" tab.
    - Choose the `sql/reelreview_export.sql` file and click "Go".

    OR

    - Use the MySQL command line:
        ```bash
        mysql -u root -p reelreview < sql/reelreview_export.sql
        ```

3. **Configuration**:
    - Ensure that your `includes/db_connect.php` file has the correct database credentials.

4. **Run the Application**:
    - Start your web server (e.g., XAMPP, MAMP).
    - Navigate to `http://localhost/reelreview/` in your browser.

## Project Overview

- **Login System**: Users can log in using their credentials.
- **Registration System**: New users can register.
- **Home Page**: Displays a carousel of random movies and a grid of all movies.
- **Movie Details**: Each movie has a detail page with more information.
- **Data Filtering**: Users can filter movies by genre or rating.
- **Reviews**: Users can view and submit reviews for movies.

