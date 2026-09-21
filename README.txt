# ScholarConnect – PHP + MySQL Scholarship Portal

ScholarConnect is a Maharashtra scholarship portal designed to help students
explore scholarships and check their eligibility.

## Technology Used

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- XAMPP

## Main Features

- Student registration and login
- Scholarship search and filtering
- Eligibility Checker
- Save/Favourite scholarships
- Student Dashboard
- Scholarship deadline tracking
- Open / Closing Soon / Closed status
- Required document checklist
- Scholarship alerts
- Admin authentication
- Admin scholarship management
- Add, edit and delete scholarships
- Contact messages for administrators
- 28 scholarship records
- Official scholarship website links

## Important

ScholarConnect does **not** provide scholarship application submission.

It helps students explore scholarships and check their eligibility.

Official Maharashtra scholarship portal:

https://mahadbt.maharashtra.gov.in/

## Run Locally on Mac / XAMPP

1. Copy the project folder into:

   `/Applications/XAMPP/htdocs/`

2. Start **Apache** and **MySQL** from XAMPP.

3. Open:

   `http://localhost/Scholar_Connect/`

4. Make sure the local MySQL database is configured in:

   `includes/db.php`

## Database

The project uses MySQL to store:

- Students
- Administrators
- Scholarships
- Contact messages
- Favourite scholarships

The scholarship table also contains deadline and required-document
information.

## Security

Do not upload real database passwords or administrator credentials
to a public repository.

For the live deployment, configure the database connection separately
using the hosting provider's database credentials.
