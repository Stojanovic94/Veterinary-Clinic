# Veterinary Clinic Appointment System

## Overview
The Veterinary Clinic Appointment System is a web-based platform built using PHP, HTML, CSS, and MySQL. The system allows users (pet owners) to register, log in, and schedule appointments for their pets with available veterinarians. A user can be the owner of multiple pets, and can schedule appointments with various veterinarians. The system ensures that appointments are only scheduled if the chosen veterinarian is available. If a veterinarian is busy during the requested time slot, the next available time will be proposed, with a minimum interval of one hour between appointments.

## Features
- **User Registration & Login:** Users can register an account and log in to manage their pets and schedule appointments.
- **Pet Management:** Users can add, update, and view information about their pets.
- **Veterinarian Scheduling:** Users can select a veterinarian and choose a time slot for their pet's appointment.
- **Doctor Availability Check:** The system ensures that veterinarians are available at the selected time. If the veterinarian is busy, the system suggests the next available time.
- **Time Slot Validation:** Appointments cannot be scheduled at a time when a veterinarian is already booked, and users cannot select appointments at 12:01 if the time slot 12:00 is unavailable.
- **Multiple Pets Per User:** A user can manage multiple pets and schedule appointments for them.
- **Admin Panel:** Admins can manage veterinarians, users, and appointments.

## Technologies Used
- **PHP:** For the backend logic, managing user authentication, scheduling, and appointment validation.
- **MySQL:** To store user data, pet information, doctor details, and appointment records.
- **HTML/CSS:** For the frontend user interface and styling.
- **JavaScript:** For frontend validation and interactive features (e.g., date picker and time slot availability).

## Setup and Installation

### Prerequisites
- PHP 7 or higher.
- MySQL database.
- Apache or Nginx web server.
- Composer for managing dependencies.
