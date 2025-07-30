# Contact Manager - Laravel CRUD Application

A comprehensive contact management system built with Laravel that supports full CRUD operations and bulk XML import functionality.

## Features

- ✅ **Complete CRUD Operations**: Create, Read, Update, Delete contacts
- ✅ **XML Bulk Import**: Import multiple contacts from XML files
- ✅ **Data Validation**: Server-side validation for all contact data
- ✅ **Responsive Design**: Bootstrap-powered responsive UI
- ✅ **Pagination**: Efficient handling of large contact lists
- ✅ **Error Handling**: Comprehensive error reporting for import operations
- ✅ **Success Notifications**: User feedback for all operations

## Contact Fields

Each contact contains the following information:
- **Name** (required): Full name of the contact
- **Phone** (optional): Phone number
- **Company** (optional): Company name
- **Address** (optional): Full address

## Installation & Setup

### Prerequisites
- PHP 8.0 or higher
- Composer
- SQLite, MySQL, or PostgreSQL

### Installation Steps

1. **Navigate to the project directory**:
   ```bash
   cd contact-manager
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Set up environment file**:
   ```bash
   cp .env.example .env
   ```

4. **Configure database** (choose one):

   **Option A: SQLite (recommended for development)**
   ```bash
   # Update .env file
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/contact-manager/database/database.sqlite
   
   # Create database file
   touch database/database.sqlite
   ```

   **Option B: MySQL**
   ```bash
   # Update .env file
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=contact_manager
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

6. **Run migrations**:
   ```bash
   php artisan migrate
   ```

7. **Start the development server**:
   ```bash
   php artisan serve
   ```

8. **Access the application**:
   Open your browser to `http://localhost:8000`

## Usage

### Basic CRUD Operations

1. **View All Contacts**: Navigate to the home page to see all contacts
2. **Add New Contact**: Click "Add New Contact" button
3. **View Contact**: Click the eye icon in the actions column
4. **Edit Contact**: Click the edit icon in the actions column
5. **Delete Contact**: Click the delete icon (requires confirmation)

### XML Import Feature

1. **Access Import**: Click "Import XML" in the navigation or contact list
2. **Prepare XML File**: Use the provided format (see XML Format section)
3. **Upload File**: Select your XML file (max 2MB)
4. **Review Results**: View import success/error summary

### XML Format

Your XML file should follow this structure:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<contacts>
    <contact>
        <name>John Doe</name>
        <phone>+1-555-123-4567</phone>
        <company>ABC Corporation</company>
        <address>123 Main St, City, State 12345</address>
    </contact>
    <contact>
        <name>Jane Smith</name>
        <phone>+1-555-987-6543</phone>
        <company>XYZ Inc</company>
        <address>456 Oak Ave, Town, State 67890</address>
    </contact>
</contacts>
```

**Important Notes:**
- `name` is the only required field
- `phone`, `company`, and `address` are optional
- Duplicate names are allowed
- Invalid data will be reported but won't stop the import process

### Sample XML File

A sample XML file (`sample_contacts.xml`) is included in the project root for testing purposes.

## API Routes

The application uses standard Laravel resource routes:

- `GET /contacts` - List all contacts (with pagination)
- `GET /contacts/create` - Show create contact form
- `POST /contacts` - Store new contact
- `GET /contacts/{id}` - Show specific contact
- `GET /contacts/{id}/edit` - Show edit contact form
- `PUT /contacts/{id}` - Update specific contact
- `DELETE /contacts/{id}` - Delete specific contact
- `GET /contacts-import` - Show XML import form
- `POST /contacts-import` - Process XML import

## Validation Rules

### Contact Validation
- **Name**: Required, string, max 255 characters
- **Email**: Required, valid email format, unique in database
- **Phone**: Optional, string, max 20 characters
- **Company**: Optional, string, max 255 characters
- **Address**: Optional, text field

### XML File Validation
- **File Type**: Must be XML file
- **File Size**: Maximum 2MB
- **Content**: Must be valid XML with proper structure

## Features & Technologies

### Backend
- **Laravel 9.x**: PHP framework
- **Eloquent ORM**: Database abstraction
- **Blade Templates**: Templating engine
- **Form Validation**: Server-side validation
- **File Upload**: XML file processing

### Frontend
- **Bootstrap 5**: Responsive CSS framework
- **Font Awesome**: Icon library
- **JavaScript**: Client-side interactions
- **Responsive Design**: Mobile-friendly interface

### Database
- **SQLite/MySQL/PostgreSQL**: Flexible database support
- **Migrations**: Version-controlled database schema
- **Eloquent Models**: Object-relational mapping

## File Structure

```
contact-manager/
├── app/
│   ├── Http/Controllers/
│   │   └── ContactController.php      # Main CRUD controller
│   └── Models/
│       └── Contact.php                # Contact model
├── database/
│   └── migrations/
│       └── *_create_contacts_table.php # Database schema
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php              # Main layout template
│   └── contacts/
│       ├── index.blade.php            # Contact list view
│       ├── create.blade.php           # Create contact form
│       ├── edit.blade.php             # Edit contact form
│       ├── show.blade.php             # Contact details view
│       └── import.blade.php           # XML import form
├── routes/
│   └── web.php                        # Application routes
├── sample_contacts.xml                # Sample XML file
└── README.md                          # This file
```

## Error Handling

The application includes comprehensive error handling:

- **Form Validation**: Real-time validation with error messages
- **Import Errors**: Detailed reporting of XML import issues
- **Database Errors**: Graceful handling of database constraints
- **File Upload Errors**: Clear messaging for file-related issues

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is open-source software licensed under the MIT license.

## Support

For issues or questions:
1. Check the error messages in the application
2. Verify your XML file format matches the required structure
3. Ensure database permissions are properly configured
4. Check Laravel logs in `storage/logs/` for detailed error information
