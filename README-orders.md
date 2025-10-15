Migrations and order flow added by assistant

To run migrations and enable order persistence locally:

1. Ensure your database connection is configured in `myapp/.env` (DB_CONNECTION, DB_DATABASE, etc.).
2. From project root run (PowerShell):
   php artisan migrate

This creates `orders` and `order_items` tables.

3. Use the checkout page at /checkout to place an order. The controller will create an Order and OrderItems and clear the session cart.

Notes:
- The sample cart implementation stores items in session. If you want to persist a cart per user, implement a Cart model/table and merge session cart on login.
- If you prefer, I can create seeders or an Order resource controller with index/show for admin views.
