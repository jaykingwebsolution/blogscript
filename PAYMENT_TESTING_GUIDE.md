# Payment System Testing Guide

## 🎯 Quick Start Testing

This guide provides step-by-step instructions to test both **admin payment management** and **frontend payment functionality** with MySQL.

## 📋 Prerequisites

### Database Setup:
```bash
# 1. Create MySQL database
mysql -u root -p
CREATE DATABASE blogscript;
CREATE USER 'blogscript_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON blogscript.* TO 'blogscript_user'@'localhost';
FLUSH PRIVILEGES;

# 2. Configure environment
cp .env.example .env
# Edit .env with your MySQL credentials:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogscript
DB_USERNAME=blogscript_user
DB_PASSWORD=secure_password

# 3. Run migrations
php artisan migrate
php artisan db:seed (if seeders exist)
```

## 🔧 Admin Payment Testing

### 1. **Payment Settings Configuration**

**URL**: `/admin/payment-settings`

**Test Steps**:
1. Login as admin
2. Navigate to Admin → Payment Settings
3. Test current configuration:
   ```
   Public Key: pk_test_demo_key_replace_with_yours
   Secret Key: sk_test_demo_key_replace_with_yours
   Environment: Test
   ```
4. Click "Test Connection" button
5. Should show connection result (success/failure)
6. Update with real Paystack keys:
   ```
   Public Key: pk_test_[your_real_test_key]
   Secret Key: sk_test_[your_real_secret_key]
   Merchant Email: your-email@domain.com
   ```
7. Save settings and test again

**Expected Results**:
- ✅ Settings save successfully
- ✅ Test connection works with real keys
- ✅ Demo keys show appropriate demo responses
- ✅ Keys are stored in database (site_settings table)

### 2. **Distribution Pricing Management**

**URL**: `/admin/distribution-pricing`

**Test Steps**:
1. Navigate to Admin → Distribution Pricing
2. Create new pricing plan:
   ```
   Name: "6 Month Access"
   Duration: "6 months"
   Price: 5000 (₦50)
   ```
3. Create additional plans:
   ```
   Name: "1 Year Access"
   Duration: "12 months"  
   Price: 15000 (₦150)
   
   Name: "Lifetime Access"
   Duration: "Lifetime"
   Price: 50000 (₦500)
   ```
4. Edit existing plans
5. Delete test plans

**Expected Results**:
- ✅ Plans create successfully
- ✅ Prices display with ₦ currency formatting
- ✅ Plans appear in frontend payment selection
- ✅ Edit/delete functionality works

### 3. **Manual Payment Review**

**URL**: `/admin/manual-payments`

**Test Steps**:
1. Navigate to Admin → Manual Payments
2. Review submitted payment proofs
3. Test approval workflow:
   - Click "View" on pending payment
   - Download payment proof
   - Click "Approve" or "Reject"
   - Add admin notes
4. Test bulk approval for multiple payments

**Expected Results**:
- ✅ Payment proofs display correctly
- ✅ Download functionality works
- ✅ Approval grants user access
- ✅ Rejection sends notification
- ✅ Bulk operations work efficiently

### 4. **Subscription Management**

**URL**: `/admin/subscriptions`

**Test Steps**:
1. Navigate to Admin → Subscriptions
2. View active subscriptions list
3. Check subscription details:
   - Plan name and duration
   - Start and expiry dates
   - Payment status
   - User information
4. Filter by plan type and status

**Expected Results**:
- ✅ All subscriptions display with correct data
- ✅ Filtering works properly
- ✅ Subscription details are accurate
- ✅ Expiry tracking functions correctly

## 🎵 Frontend Payment Testing

### 1. **User Registration & Role Testing**

**Test Steps**:
1. Register as different user types:
   ```
   - Artist account
   - Record Label account  
   - Listener account
   ```
2. Verify role-based access:
   - Artists can access distribution
   - Record labels can access distribution
   - Listeners see subscription options only

**Expected Results**:
- ✅ Registration works for all roles
- ✅ Role-based menu items appear
- ✅ Proper access controls enforced

### 2. **Distribution Payment Testing**

**URL**: `/payment/distribution`

**Test Steps**:
1. Login as Artist or Record Label
2. Navigate to Payment → Distribution
3. Select distribution plan
4. Test Paystack payment:
   ```
   - Click "Pay with Paystack"
   - Should redirect to Paystack checkout
   - Use test card: 4084084084084081
   - Complete payment flow
   ```
5. Test manual payment:
   ```
   - Select "Manual Payment"
   - Fill bank transfer details
   - Upload payment proof (image/PDF)
   - Submit for review
   ```

**Test Payment Details**:
```
# Paystack Test Cards
Success: 4084084084084081
Decline: 4084084084084084
Insufficient: 4000000000000002

# Test CVV: 123
# Test Expiry: Any future date
# Test PIN: 1234 (if prompted)
```

**Expected Results**:
- ✅ Payment initialization works
- ✅ Paystack integration functions
- ✅ Manual payment upload works
- ✅ Access granted after successful payment
- ✅ Redirect to distribution form after payment

### 3. **Subscription Payment Testing**

**URL**: `/dashboard/subscription`

**Test Steps**:
1. Login as any user type
2. Navigate to Dashboard → Subscription
3. Select subscription plan:
   ```
   - Artist Plan: ₦50
   - Record Label Plan: ₦200
   - Premium Plan: ₦30
   ```
4. Complete Paystack payment flow
5. Verify subscription activation:
   - Check subscription status
   - Verify expiry date (30 days from now)
   - Test plan-specific features

**Expected Results**:
- ✅ Plan selection works correctly
- ✅ Pricing displays properly (in kobo for Paystack)
- ✅ Payment flow completes successfully
- ✅ Subscription activates immediately
- ✅ User role updates if applicable
- ✅ Expiry date calculated correctly

### 4. **API Payment Testing**

**API Endpoints**: `/api/paystack/initialize`, `/api/paystack/callback`

**Test Steps**:
1. Create API token:
   ```php
   $user = App\Models\User::find(1);
   $token = $user->createToken('test-token')->plainTextToken;
   ```

2. Test initialization endpoint:
   ```bash
   curl -X POST 'http://localhost:8000/api/paystack/initialize' \
     -H 'Content-Type: application/json' \
     -H 'Authorization: Bearer YOUR_TOKEN_HERE' \
     -d '{
       "email": "test@example.com",
       "amount": 5000,
       "plan": "artist"
     }'
   ```

3. Test callback endpoint:
   ```bash
   curl -H 'Authorization: Bearer YOUR_TOKEN_HERE' \
        'http://localhost:8000/api/paystack/callback?reference=MOCK_API_SUB_1_123456'
   ```

**Expected Results**:
- ✅ API returns proper JSON responses
- ✅ Authentication required and enforced
- ✅ Demo mode works when Paystack unavailable
- ✅ Validation errors return proper status codes
- ✅ Successful payments create/update subscriptions

## 🧪 Demo Mode Testing

### When Paystack API is unavailable:

**Test Steps**:
1. Disconnect from internet or block api.paystack.co
2. Try payment initialization
3. Should get demo responses:
   ```json
   {
     "status": "success",
     "message": "Payment initialization successful (Demo Mode)",
     "authorization_url": "https://checkout.paystack.com/mock_access_38df701052",
     "demo_mode": true,
     "note": "This is a demo response since Paystack API is not accessible"
   }
   ```

**Expected Results**:
- ✅ Demo mode activates automatically
- ✅ Mock responses generated
- ✅ Payment flow continues seamlessly
- ✅ Demo transactions tracked properly
- ✅ Users still gain access for testing

## 🔍 Database Verification

### Check Payment Storage:

**Test Queries**:
```sql
-- Check subscriptions
SELECT * FROM subscriptions ORDER BY created_at DESC;

-- Check distribution payments  
SELECT user_id, distribution_paid_at, distribution_amount_paid 
FROM users WHERE distribution_paid_at IS NOT NULL;

-- Check manual payments
SELECT * FROM manual_payments ORDER BY created_at DESC;

-- Check site settings (payment config)
SELECT * FROM site_settings WHERE `key` LIKE '%paystack%';

-- Check distribution pricing
SELECT * FROM distribution_pricings ORDER BY price ASC;
```

**Expected Results**:
- ✅ All payment data stored correctly
- ✅ Foreign key relationships maintained
- ✅ Timestamps accurate
- ✅ MySQL-specific features utilized

## 📊 Error Testing

### Test Error Scenarios:

1. **Invalid payment amounts** (below minimum)
2. **Expired/invalid Paystack keys**
3. **Network timeouts during payment**
4. **Invalid file uploads** for manual payments
5. **Unauthorized access attempts**
6. **Duplicate payment attempts**

**Expected Results**:
- ✅ Proper error messages displayed
- ✅ Users redirected appropriately
- ✅ No payment data corruption
- ✅ Graceful fallback to demo mode
- ✅ Admin notifications for critical errors

## ✅ Success Criteria

The payment system is working correctly when:

- **Admin Interface**: Can configure payments, review manual payments, manage pricing
- **Frontend Payments**: Both Paystack and manual payments work for distribution and subscriptions  
- **Database Storage**: All payment data properly stored in MySQL
- **API Integration**: JSON endpoints work with authentication
- **Security**: Validation and authorization enforced throughout
- **Error Handling**: Graceful failures and appropriate user feedback
- **Demo Mode**: Testing possible without real payments

This comprehensive testing ensures both admin and frontend payment functionality works perfectly with MySQL database backend.