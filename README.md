# Telegram Mini App Service Showcase

A configurable Telegram Mini App for businesses and professionals to showcase their work, services, approximate pricing and collect customer requests.

The same application can be adapted for different types of businesses without changing the core application logic.

Examples:

* Construction companies
* Car repair and customization shops
* Auto detailing services
* Renovation teams
* Freelancers
* Designers
* Photographers
* Other service-based businesses

## Concept

The application works as a digital service catalog inside Telegram.

For example, a car customization shop can show:

1. Completed project
2. Before / after photos
3. Description of the work
4. Approximate price
5. "I want the same" button

A customer can select a service, review examples and send a request directly through Telegram.

The same flow can be configured for a construction company:

1. Select service
2. View completed projects
3. See approximate pricing
4. Select required work
5. Send a request

## Main Features

* Telegram Mini App
* Configurable business profile
* Service catalog
* Portfolio / completed projects
* Before and after images
* Approximate pricing
* Service categories
* Project details
* Customer request form
* Telegram-based communication
* Configurable buttons and call-to-actions
* Responsive mobile-first interface

## Example User Flow

```text
Telegram
   |
   v
Business Profile
   |
   +-- Services
   |     |
   |     +-- Service details
   |     +-- Examples
   |     +-- Price
   |     +-- Request service
   |
   +-- Portfolio
   |     |
   |     +-- Project
   |     +-- Before / After
   |     +-- Price
   |     +-- Do the same
   |
   +-- Contact
```

## Configuration

The main goal is to make the application reusable.

Business-specific information should be configurable instead of hardcoded:

* Business name
* Logo
* Description
* Contact information
* Services
* Categories
* Portfolio projects
* Images
* Prices
* Currency
* CTA buttons
* Request form fields
* Telegram configuration

Example configuration:

```json
{
  "business": {
    "name": "Custom Garage",
    "description": "Car customization and restoration"
  },
  "services": [
    {
      "name": "Body Kit Installation",
      "price_from": 800,
      "currency": "USD"
    },
    {
      "name": "Full Car Wrap",
      "price_from": 1200,
      "currency": "USD"
    }
  ]
}
```

## Example: Automotive Business

A customer opens the Mini App and sees:

```text
Custom Garage

Car customization
Restoration
Body work

[ View Services ]

[ View Projects ]

[ Request a Quote ]
```

Project:

```text
BMW M4 Custom Build

Before
[ image ]

After
[ image ]

Work:
- Body kit
- Custom exhaust
- Suspension
- Paint

Estimated price:
$4,500+

[ I Want The Same ]
```

## Example: Construction Business

The same application can be configured for:

```text
Construction Company

Services:

[ Bathroom Renovation ]
[ Kitchen Renovation ]
[ House Construction ]
[ Roofing ]

Each service contains:

- Project examples
- Photos
- Description
- Approximate price
- Estimated duration
- Request button
```

## Architecture

The application should separate:

* Core application logic
* Telegram integration
* Business configuration
* Service catalog
* Portfolio
* Customer requests

This allows the same application to be reused for different businesses without creating a separate application for every customer.

## Planned Stack

Backend:

* Laravel
* REST API
* PostgreSQL

Frontend:

* Vue.js
* Telegram Mini Apps SDK

Infrastructure:

* Docker
* Redis
* S3-compatible storage

Optional:

* Queue workers
* CDN
* Telegram Bot API

## Roadmap

### V1

* Telegram Mini App
* Configurable business profile
* Services
* Portfolio
* Images
* Approximate pricing
* Customer request form
* Telegram integration

### V2

* Admin panel
* Visual configuration
* Multiple businesses
* Service management
* Portfolio management
* Lead management
* Request history

### V3

* Online booking
* Payments
* Notifications
* Analytics
* CRM integrations
* Multi-language support

## Purpose

This project demonstrates how a single configurable platform can be adapted to different service businesses while keeping the core architecture reusable and maintainable.

It can also serve as a foundation for creating specialized Telegram Mini Apps for individual businesses.


## Architecture

The platform is API-first and supports multiple client interfaces.

```text
                    Laravel Backend
                         |
                    REST API
                         |
              +----------+----------+
              |                     |
      Telegram Mini App        Web Application
              |                     |
          Customers          Customers / Admin
```

The backend contains the core business logic and provides a unified API for all supported interfaces.

### Backend

* Laravel
* REST API
* PostgreSQL
* Redis
* Queue workers
* Telegram Bot API
* S3-compatible storage

### Frontend

* Vue.js
* Telegram Mini App
* Web application

### Core principles

* API-first architecture
* Shared business logic
* Configurable business profiles
* Multiple frontend interfaces
* Reusable service and portfolio components
* Separation between presentation and business logic

The same backend can serve multiple businesses and multiple client interfaces without duplicating the core application logic.
