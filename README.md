# CallTrack Pro - Call Center Dashboard

A modern, responsive call center dashboard application built with Laravel and Bootstrap. This application provides real-time monitoring of call center activities, agent performance tracking, and call ticket management.

![CallTrack Pro Dashboard](https://via.placeholder.com/800x400?text=CallTrack+Pro+Dashboard)

## Tech Stack

- **Backend Framework**: Laravel
- **Frontend**: Bootstrap 5
- **JavaScript**: Vanilla JS with Chart.js
- **Icons**: Font Awesome
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze

## Features

- Responsive design optimized for desktop and mobile devices
- Collapsible sidebar navigation (toggleable on mobile devices)
- Real-time call statistics and monitoring
- Agent performance tracking and analytics
- Call ticket management system
- Interactive charts and data visualization
- Dark-themed sidebar with user status indicators
- User authentication and role-based access control

## Quick Start

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL or PostgreSQL database

### Installation
```bash
# Clone or download the project
cd call-center-dashboard

# Install PHP dependencies
composer install

# Set up environment
cp .env.example .env
php artisan key:generate

# Run migrations and seed sample data
php artisan migrate --seed

# Start the development server
php artisan serve
```

### Access the Application
- **URL**: http://127.0.0.1:8000
- **Login**: Use any of the test accounts:
  - john@example.com (password: password)
  - jane@example.com (password: password)
  - mike@example.com (password: password)

## Dashboard Features

### 📱 Key Features
- **Fully Responsive**: Works on desktop, tablet, and mobile devices
- **Interactive Dashboard**: Real-time statistics and visualizations
- **Dark Sidebar**: Professional sidebar with navigation
- **Bootstrap UI**: Modern, clean interface components

### ✅ Implemented Features

#### Agent Dashboard
- Real-time statistics display (active calls, daily totals, metrics)
- Active call tickets with priority indicators
- Recent call history for context
- Quick action buttons (assign, complete, escalate)

#### Call Ticket Management
- Comprehensive ticket details view
- Status management (Active, Completed, Forwarded, Escalated)
- Priority levels (Low, Medium, High, Urgent)
- Agent assignment and call forwarding
- Complete call lifecycle tracking

#### Caller Information System
- Contact details management (phone, email, company, address)
- Call history tracking for customer context
- Comprehensive notes system with categorization

#### Authentication
- Laravel Breeze integration
- Agent login and profile management
- Secure session handling

## Testing

1. Login with test credentials (e.g., john@example.com / password)
2. Explore the responsive dashboard (try mobile view)
3. Test the sidebar toggle functionality



## Production Setup Tips

- Configure database connection in `.env`
- Enable HTTPS in production
- Set up proper caching

## Support

For questions or issues, please open a GitHub issue or contact the development team.

---

**Status**: Ready for deployment with Bootstrap 5 UI
# VoIP
