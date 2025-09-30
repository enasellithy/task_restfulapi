# Inventory Management API

## Features
- Multi-warehouse inventory management  
- Stock transfers between warehouses
- Low stock alerts
- Search & filtering
- Pagination
- Caching
- Authentication

## API Endpoints

### Authentication
- `POST /auth/register` - Register user
- `POST /auth/login` - Login user

### Inventory  
- `GET /inventory` - Get inventory (filters: name, sku, price, warehouse_id)
- `POST /inventory_transfer` - Transfer stock

### Warehouses
- `GET /warehouse` - List warehouses
- `GET /warehouse/{id}` - Get warehouse
- `GET /warehouse/{id}/inventory` - Get warehouse inventory

## Events
- `LowStockDetected` - Triggered when stock reaches threshold
