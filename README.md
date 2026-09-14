# Arsip Kita

Arsip Kita is an internal document archiving system prototype designed to help organizations store, organize, and monitor official records digitally.

The application brings together document metadata, archive categorization, user ownership, physical storage locations, upload dates, and borrowing transactions in one centralized workspace. Administrators can manage archive records and monitor borrowing activity, while regular users can view their documents and submit borrowing requests.

## Features

- Dashboard with archive, user, and borrowing summaries.
- Archive management with document metadata such as archive number, document name, category, file path, physical storage location, owner/NIP, and upload date.
- Archive categorization for personnel and organizational records, including ijazah, pangkat, CPNS, jabatan, mutasi, and pemberhentian.
- Borrowing workflow with statuses such as not collected, borrowed, and returned.
- User authentication, registration, profile management, and role-based access.
- Borrowing request monitoring for administrators.
- Activity logging for important user actions.
- Dashboard visualizations for borrowing activity in the prototype dashboard.
- Responsive interface built with Laravel Blade and Bootstrap/Tailwind components.

## User roles

### Administrator

- View dashboard summaries.
- Manage archive records and categories.
- Monitor borrowing requests and transaction statuses.
- Review user activity logs.

### Regular user

- View documents assigned to their account.
- View archive details.
- Submit document borrowing requests.
- Track borrowing status.

## Technology stack

- PHP 8+
- Laravel
- Blade templates
- Laravel Eloquent ORM
- MySQL for the local prototype or SQLite/MariaDB for deployment
- Bootstrap and Tailwind CSS
- Font Awesome
- ApexCharts and Chart.js


## Project status

Arsip Kita is a functional prototype and foundation for a larger internal records-management system. Some administrative screens and dashboard visualizations are still being refined, and the project can be extended with file uploads, document previews, search, permissions, reports, and production-ready audit controls.

## License

This project is intended for educational and internal prototype use.
