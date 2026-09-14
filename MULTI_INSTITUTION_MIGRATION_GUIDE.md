# Multi-Institution Migration Guide
## ElimView ERP - Single to Multi-Institution Support

---

## 📊 DATABASE STRUCTURE CHANGES

### New Table: `school_profiles`
**Location:** Added in v2 database

```sql
CREATE TABLE `school_profiles` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `uuid` varchar(36) UNIQUE NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `email` varchar(100),
  `phone` varchar(100),
  `website` varchar(255),
  `address` text,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime
)
```

**Purpose:** Represents a school/institution group that can have multiple branches/campuses.

**Example Data in v2:**
- Twinses Pride Schools (ID: 1) - covers 5 branches
- Musabe Schools (ID: 2) - covers 3 branches  
- Kaizirege (ID: 3)
- Feza Schools (ID: 4)
- Dynamic Schools (ID: 5)
- Marian Schools (ID: 6)

---

### Modified Table: `branch`
**Key Change:** Added foreign key relationship to school_profiles

```sql
ALTER TABLE branch ADD COLUMN school_profile_id int(11) DEFAULT NULL;
ALTER TABLE branch ADD CONSTRAINT fk_branch_school_profile_id 
  FOREIGN KEY (school_profile_id) REFERENCES school_profiles (id) 
  ON DELETE RESTRICT ON UPDATE CASCADE;
```

**Current Status in v2:**
- Branches 1-5 belong to Twinses Pride Schools (school_profile_id = 1)
- Branches 6-8 belong to Musabe Schools (school_profile_id = 2)
- And so on...

---

## 🔄 APPLICATION ARCHITECTURE OVERVIEW

### Current Data Flow (Single Institution - Works Fine)
```
User Login 
  ↓
Authentication Model validates credentials
  ↓
Session stores: loggedin_branch (branch_id from user's branch)
  ↓
All queries use: $this->application_model->get_branch_id()
  ↓
Returns branch_id from session
  ↓
All queries filtered by: WHERE branch_id = X
```

### New Data Flow (Multi-Institution)
```
User Login 
  ↓
Authentication Model validates credentials + Fetch school_profile_id from branch
  ↓
Session stores: 
  - loggedin_branch (branch_id) 
  - loggedin_school_profile_id (school_profile_id) ← NEW
  ↓
All queries can now:
  - Filter by branch (existing: branch_id)
  - Filter by school profile (new: school_profile_id)
  ↓
Access school-wide data across all branches when needed
```

---

## 🛠️ CODE CHANGES NEEDED

### 1. Authentication Controller (`application/controllers/Authentication.php`)
**What to Add:** Fetch and store school_profile_id in session

**Location:** Lines 50-88 (login process)

**Change Required:**
```php
// After line 78, add:
$school_profile_id = NULL;
if(!empty($getUser['branch_id'])) {
    $branch = $this->db->select('school_profile_id')
        ->where('id', $getUser['branch_id'])
        ->get('branch')
        ->row();
    $school_profile_id = $branch->school_profile_id ?? NULL;
}

// Then update sessionData array (line 75-86) to include:
'loggedin_school_profile_id' => $school_profile_id,  // Add this line
```

---

### 2. Application Model (`application/models/Application_model.php`)
**What to Add:** New helper method to get school_profile_id

**Add New Method:**
```php
public function get_school_profile_id()
{
    if (is_superadmin_loggedin()) {
        return $this->input->post('school_profile_id');
    } else {
        return get_loggedin_school_profile_id();
    }
}
```

---

### 3. General Helper (`application/helpers/general_helper.php`)
**What to Add:** New function to retrieve school_profile_id from session

**Add These Functions:**
```php
if (!function_exists('get_loggedin_school_profile_id')) {
    function get_loggedin_school_profile_id()
    {
        $ci = &get_instance();
        return $ci->session->userdata('loggedin_school_profile_id');
    }
}

if (!function_exists('is_valid_school_profile')) {
    function is_valid_school_profile($school_profile_id)
    {
        $ci = &get_instance();
        $ci->db->select('id')
            ->where('id', $school_profile_id)
            ->where('status', 1)
            ->limit(1);
        return $ci->db->get('school_profiles')->num_rows() > 0;
    }
}
```

---

### 4. School Settings Controller (New)
**Create File:** `application/controllers/School_settings.php`

**Purpose:** Manage school profiles, branch assignments, etc.

**Key Methods Needed:**
- List all school profiles
- Add new school profile
- Assign branches to school profile
- View school-wide statistics
- Manage school settings

---

### 5. MY_Controller (`application/core/MY_Controller.php`)
**Optional Enhancement:** Add school profile info to $data array

**Add After Line 28:**
```php
$schoolProfileID = $this->application_model->get_school_profile_id();
if (!empty($schoolProfileID)) {
    $schoolProfile = $this->db->select('*')
        ->where('id', $schoolProfileID)
        ->get('school_profiles')
        ->row();
    $this->data['school_profile'] = $schoolProfile;
}
```

---

### 6. Branch Model (`application/models/Branch_model.php`)
**What to Update:** Add relationship methods

**Add Methods:**
```php
public function get_branches_by_school($school_profile_id)
{
    return $this->db->where('school_profile_id', $school_profile_id)
        ->where('status', 1)
        ->order_by('name', 'ASC')
        ->get('branch')
        ->result_array();
}

public function get_branch_with_school($branch_id)
{
    return $this->db->select('b.*, s.name as school_name, s.email as school_email')
        ->from('branch b')
        ->join('school_profiles s', 'b.school_profile_id = s.id', 'left')
        ->where('b.id', $branch_id)
        ->get()
        ->row_array();
}
```

---

### 7. Reports & Dashboards (Enhancement Opportunities)
- Add school-wide student count
- School-wide fee collection reports
- School-wide attendance reports
- Inter-branch comparisons
- Consolidated reports across all branches

---

## 📋 STRATEGY FOR ALL AFFECTED TABLES

**Important:** You do NOT need to add school_profile_id to all 150+ tables

**Join Strategy for school-level queries:**
```sql
-- Query pattern example:
WHERE branch_id IN (
    SELECT id FROM branch WHERE school_profile_id = X
)

-- Or with direct join:
JOIN branch ON branch.id = table.branch_id 
WHERE branch.school_profile_id = X
```

---

## 🚀 HOW TO RUN THE APPLICATION

### Prerequisites
- PHP 7.2+ (preferably 7.4 or 8.0)
- MySQL 5.7+ or MariaDB 10.3+
- Apache/Nginx with rewrite module enabled

### Step 1: Setup Database
```bash
# Navigate to project directory
cd D:\PROJECTS\PROFF\elimuview

# Import the v2 database (contains school_profiles table)
# Using MySQL command line:
mysql -u root -p twinsesp_edu < twinsesp_edu(v2).sql

# OR using phpMyAdmin:
# 1. Create database: twinsesp_edu
# 2. Import: twinsesp_edu(v2).sql
# 3. Choose character set: utf8mb4
```

### Step 2: Configure Database Connection
**File:** `application/config/database.php`

```php
$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'twinsesp_edu',
    'dbdriver' => 'mysqli',
    'char_set' => 'utf8mb4',
    'dbcollat' => 'utf8mb4_unicode_ci',
);
```

### Step 3: Configure Application Settings
**File:** `application/config/config.php`

```php
$config['base_url'] = 'http://localhost/elimuview/';
$config['index_page'] = '';
$config['uri_protocol'] = 'REQUEST_URI';
```

### Step 4: Set Up Web Server

**For Apache:**
Create `.htaccess` in project root:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /elimuview/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?/$1 [L]
</IfModule>
```

**For Nginx:**
```nginx
server {
    listen 80;
    server_name localhost;
    root /path/to/elimuview;
    
    location / {
        try_files $uri $uri/ /index.php?/$request_uri;
    }
    
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Step 5: Create Required Directories
```bash
mkdir -p application/logs
mkdir -p uploads
mkdir -p temp

# Set permissions (Linux/Mac)
chmod -R 755 application/logs uploads temp
```

### Step 6: Start Application

**Option A: Built-in PHP Server (Development)**
```bash
cd D:\PROJECTS\PROFF\elimuview
php -S localhost:8000
```
Access: http://localhost:8000

**Option B: Apache**
- Access: http://localhost/elimuview

**Option C: XAMPP/WAMP/LARAGON**
- Place files in htdocs/www folder
- Start Apache from control panel

### Step 7: Login
Check the `login_credential` table for default admin user, or contact system administrator for credentials.

### Step 8: Verify Setup
1. Login successfully
2. Go to Settings → Branch/School Management
3. Verify branches show assigned school profiles
4. Check that your branch shows correct school profile in session

---

## ✅ TESTING CHECKLIST

- [ ] Admin can login successfully
- [ ] Session contains `loggedin_school_profile_id`
- [ ] Dashboard loads without errors
- [ ] Branch-specific data filters correctly
- [ ] Users can only see their assigned branch data
- [ ] Super admin can view multi-school data
- [ ] All existing functionality works
- [ ] No database errors in logs

---

## 📋 IMPLEMENTATION ORDER

1. **Backup** current database
2. **Code Changes** (in this order):
   - Update `Authentication.php`
   - Update `Application_model.php`
   - Update `general_helper.php`
   - Update `MY_Controller.php` (optional)
   - Update `Branch_model.php`
3. **Switch Database** to v2
4. **Test** thoroughly
5. **Deploy** to production

---

## ⚠️ IMPORTANT NOTES

- ✅ The v2 database is backward compatible with v1 code
- ✅ All existing branch data is preserved
- ✅ No data loss during migration
- ✅ Can implement gradually, feature by feature
- 🔒 Only super admin can access cross-school data
- 🔐 Foreign keys prevent data corruption

---

## 🎯 NEXT STEPS

1. Review this guide with your development team
2. Confirm database backup strategy
3. Implement code changes (start with Authentication.php)
4. Run tests on staging environment
5. Deploy to production after sign-off
