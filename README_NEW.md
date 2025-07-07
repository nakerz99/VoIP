# Call Center Dashboard - Laravel Prototype

A Laravel-based prototype for replacing legacy call-handling systems (like Amtelco) with modern web-based agent dashboard functionality, designed for future integration with VOIP systems like 3CX.

## Quick Start

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM

### Installation
```bash
# Clone or download the project
cd call-center-dashboard

# Install PHP dependencies
composer install

# Install and build frontend assets
npm install
npm run build

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

## Features

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

#### Notes and Documentation
- Categorized notes (General, Escalation, Resolution, Follow-up)
- Internal vs external note visibility
- Complete audit trail with timestamps

#### Authentication
- Laravel Breeze integration
- Agent login and profile management
- Secure session handling

### 🔧 VOIP Integration Framework

#### VoipIntegrationService
Complete service class with placeholder methods for 3CX integration:
- `initializeCall()` - Create tickets from incoming calls
- `updateCallStatus()` - Sync call state changes
- `transferCall()` - Handle agent transfers
- `endCall()` - Process call completion
- `getCallStatistics()` - Retrieve metrics
- `getAgentStatus()` - Monitor availability

#### API Webhook Endpoints
Ready-to-use endpoints for 3CX integration:
- `POST /api/voip/incoming-call` - New call notifications
- `POST /api/voip/call-status-update` - Call state changes
- `POST /api/voip/agent-status-update` - Agent availability
- `POST /api/voip/call-ended` - Call completion
- `POST /api/voip/test` - Integration testing

#### Database Schema
VOIP-ready fields in all relevant tables:
- `voip_call_id` - Unique 3CX call identifier
- `voip_metadata` - JSON field for additional data
- Call timing and duration tracking
- Agent assignment for routing

## Technical Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade templates with Tailwind CSS
- **Database**: SQLite (easily migrated to MySQL/PostgreSQL)
- **Authentication**: Laravel Breeze
- **Assets**: Vite for build process

## Sample Data

The system includes comprehensive sample data for testing:
- 5 sample callers with complete contact information
- Historical call logs (2-5 calls per caller)
- Active call tickets in various states
- Completed tickets with resolution notes
- Call notes demonstrating different workflows

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Api/VoipWebhookController.php    # VOIP integration endpoints
│   ├── DashboardController.php          # Main dashboard
│   └── CallTicketController.php         # Ticket management
├── Models/
│   ├── CallTicket.php                   # Active call management
│   ├── Caller.php                       # Customer information
│   ├── CallLog.php                      # Historical calls
│   └── CallNote.php                     # Interaction tracking
└── Services/
    └── VoipIntegrationService.php       # 3CX integration layer

resources/views/
├── dashboard.blade.php                  # Main agent dashboard
└── call-tickets/
    ├── index.blade.php                  # All tickets view
    └── show.blade.php                   # Ticket details

database/
├── migrations/                          # Database schema
└── seeders/CallCenterSeeder.php        # Sample data
```

## Development Philosophy

### Code Organization
- **Model-driven design**: Clear Eloquent relationships
- **Service layer**: Business logic separation
- **RESTful controllers**: Standard HTTP semantics
- **Component-based views**: Reusable Blade templates

### Future-Ready Architecture
- **Modular structure**: Easy feature extension
- **API-first mindset**: Controllers ready for JSON responses
- **VOIP integration points**: Clearly marked extension areas
- **Scalable database design**: Proper indexing and relationships

### Best Practices
- **Validation**: Server-side form validation
- **Security**: CSRF protection and input sanitization
- **Error handling**: User-friendly error messages
- **Documentation**: Comprehensive code and system docs

## Next Steps for 3CX Integration

1. **API Authentication**: Implement proper webhook security
2. **Real-time Updates**: WebSocket integration for live dashboard
3. **Call Controls**: Desktop phone integration
4. **Recording Integration**: Link to 3CX recording system
5. **Advanced Routing**: Skill-based call distribution

## Testing

### Manual Testing
1. Login with test credentials
2. View dashboard with sample active calls
3. Click on call tickets to view details
4. Add notes and test status changes
5. Test assignment and forwarding workflows

### API Testing
```bash
# Test VOIP webhook integration
curl -X POST http://127.0.0.1:8000/api/voip/test \
  -H "Content-Type: application/json" \
  -d '{"test": "data"}'
```

## Production Considerations

### Security
- Enable API authentication for webhook endpoints
- Implement rate limiting
- Set up proper CORS policies
- Configure HTTPS certificates

### Performance
- Migrate to production database (MySQL/PostgreSQL)
- Set up Redis for caching and sessions
- Configure queue workers for background jobs
- Implement database query optimization

### Monitoring
- Set up application monitoring (Laravel Telescope)
- Configure error tracking (Sentry)
- Implement call metrics dashboard
- Set up automated backups

## Documentation

For detailed technical documentation, see [DOCUMENTATION.md](DOCUMENTATION.md)

## Support

This prototype demonstrates a complete call center management system with clear integration paths for enterprise VOIP systems. The codebase is designed for easy extension and production deployment.

---

**Development Timeline**: Completed ahead of July 31, 2025 deadline
**Status**: Ready for demonstration and 3CX integration planning
