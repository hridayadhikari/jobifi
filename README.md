# Jobifi

Jobifi is a modern job portal platform designed to connect job seekers with employers through a seamless and user-friendly experience. The platform enables users to create professional profiles, search and apply for jobs, while allowing recruiters to post job opportunities and manage applicants efficiently.

## Features

### For Job Seekers

* User Registration and Authentication
* Profile Creation and Management
* Upload Profile Photo and Resume
* Search Jobs by Title, Skill, or Location
* Apply for Jobs
* Track Application Status
* Save Jobs for Later

### For Recruiters

* Recruiter Registration and Authentication
* Company Profile Management
* Post New Job Openings
* Edit and Delete Job Listings
* View and Manage Applications
* Shortlist Candidates

### General Features

* Secure Authentication System
* Responsive User Interface
* Dashboard for Users and Recruiters
* Real-time Data Management
* Role-Based Access Control

## Tech Stack

### Frontend

* HTML
* CSS
* JavaScript
* Bootstrap / Tailwind CSS

### Backend

* Laravel

### Database

* MySQL

### Additional Tools

* Composer
* Git & GitHub

## Installation

### Prerequisites

* PHP 8.x
* Composer
* MySQL
* Node.js & NPM
* Git

### Clone the Repository

```bash
git clone https://github.com/your-username/jobifi.git
cd jobifi
```

### Install Dependencies

```bash
composer install
npm install
```

### Environment Setup

Copy the environment file:

```bash
cp .env.example .env
```

Configure database credentials inside `.env`.

### Generate Application Key

```bash
php artisan key:generate
```

### Run Migrations

```bash
php artisan migrate
```

### Start the Development Server

```bash
php artisan serve
```

### Compile Frontend Assets

```bash
npm run dev
```

The application will be available at:

```text
http://127.0.0.1:8000
```

## Project Structure

```text
jobifi/
│
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
└── vendor/
```

## Future Enhancements

* AI-based Job Recommendations
* Resume Analysis System
* Email Notifications
* Interview Scheduling
* Skill Assessment Tests
* Application Analytics Dashboard

## Contributors

Developed and maintained by the Jobifi Development Team.

## License

This project is licensed under the MIT License.
