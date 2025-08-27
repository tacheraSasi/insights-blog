# Complete Markdown Guide: Syntax Highlighting and Advanced Features Demo

## Introduction

This guide demonstrates the enhanced markdown rendering capabilities with **syntax highlighting** and full markdown features. You'll see comprehensive examples of different code languages, advanced formatting, and GitHub Flavored Markdown extensions.

> **Note:** This content showcases the power of our enhanced markdown rendering with proper syntax highlighting and full feature support!

## Code Examples with Syntax Highlighting

### JavaScript/TypeScript Examples

Here's a modern JavaScript example with async/await:

```javascript
// Modern JavaScript with async/await
class APIClient {
    constructor(baseURL) {
        this.baseURL = baseURL;
        this.token = null;
    }

    async authenticate(credentials) {
        try {
            const response = await fetch(`${this.baseURL}/auth/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(credentials)
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            this.token = data.token;
            return data;
        } catch (error) {
            console.error('Authentication failed:', error);
            throw error;
        }
    }
}

// Usage
const client = new APIClient('https://api.example.com');
await client.authenticate({ username: 'user', password: 'pass' });
```

TypeScript with advanced types:

```typescript
interface User {
    id: number;
    name: string;
    email: string;
    roles: Role[];
}

interface Role {
    id: number;
    name: string;
    permissions: Permission[];
}

type Permission = 'read' | 'write' | 'delete' | 'admin';

class UserService {
    private users: Map<number, User> = new Map();

    async createUser<T extends Partial<User>>(userData: T): Promise<User> {
        const user: User = {
            id: Date.now(),
            name: userData.name || 'Unknown',
            email: userData.email || '',
            roles: userData.roles || []
        };
        
        this.users.set(user.id, user);
        return user;
    }

    hasPermission(user: User, permission: Permission): boolean {
        return user.roles.some(role => 
            role.permissions.includes(permission)
        );
    }
}
```

### Python Examples

Here's a Python example with data science operations:

```python
import pandas as pd
import numpy as np
from typing import List, Dict, Optional
from dataclasses import dataclass
from datetime import datetime, timedelta

@dataclass
class DataProcessor:
    data: pd.DataFrame
    config: Dict[str, any]
    
    def __post_init__(self):
        self.validate_data()
    
    def validate_data(self) -> None:
        """Validate the input data structure."""
        required_columns = self.config.get('required_columns', [])
        missing_columns = set(required_columns) - set(self.data.columns)
        
        if missing_columns:
            raise ValueError(f"Missing required columns: {missing_columns}")
    
    def clean_data(self) -> pd.DataFrame:
        """Clean and preprocess the data."""
        # Remove duplicates
        self.data = self.data.drop_duplicates()
        
        # Handle missing values
        numeric_columns = self.data.select_dtypes(include=[np.number]).columns
        self.data[numeric_columns] = self.data[numeric_columns].fillna(
            self.data[numeric_columns].median()
        )
        
        # Remove outliers using IQR method
        for column in numeric_columns:
            Q1 = self.data[column].quantile(0.25)
            Q3 = self.data[column].quantile(0.75)
            IQR = Q3 - Q1
            lower_bound = Q1 - 1.5 * IQR
            upper_bound = Q3 + 1.5 * IQR
            
            self.data = self.data[
                (self.data[column] >= lower_bound) & 
                (self.data[column] <= upper_bound)
            ]
        
        return self.data

# Usage example
processor = DataProcessor(
    data=pd.read_csv('data.csv'),
    config={'required_columns': ['id', 'value', 'timestamp']}
)
clean_data = processor.clean_data()
```

### PHP/Laravel Examples

Laravel controller with service pattern:

```php
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use App\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Display a listing of users with filtering and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'search' => 'sometimes|string|max:255',
            'role' => 'sometimes|string|exists:roles,name',
            'status' => 'sometimes|in:active,inactive',
            'per_page' => 'sometimes|integer|min:1|max:100'
        ]);

        $users = $this->userService->getFilteredUsers($filters);

        return response()->json([
            'data' => UserResource::collection($users->items()),
            'meta' => [
                'current_page' => $users->currentPage(),
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage()
            ]
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->createUser($request->validated());
            
            return response()->json([
                'message' => 'User created successfully',
                'data' => new UserResource($user)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
```

### SQL Examples

Complex database queries:

```sql
-- Advanced SQL query with CTEs and window functions
WITH monthly_sales AS (
    SELECT 
        DATE_TRUNC('month', sale_date) AS month,
        product_id,
        SUM(quantity * price) AS monthly_revenue,
        COUNT(*) AS transaction_count
    FROM sales 
    WHERE sale_date >= DATE_SUB(CURRENT_DATE, INTERVAL 12 MONTH)
    GROUP BY DATE_TRUNC('month', sale_date), product_id
),
product_performance AS (
    SELECT 
        p.name AS product_name,
        p.category,
        ms.month,
        ms.monthly_revenue,
        ms.transaction_count,
        LAG(ms.monthly_revenue) OVER (
            PARTITION BY ms.product_id 
            ORDER BY ms.month
        ) AS previous_month_revenue,
        RANK() OVER (
            PARTITION BY ms.month 
            ORDER BY ms.monthly_revenue DESC
        ) AS revenue_rank
    FROM monthly_sales ms
    JOIN products p ON ms.product_id = p.id
)
SELECT 
    product_name,
    category,
    month,
    monthly_revenue,
    transaction_count,
    CASE 
        WHEN previous_month_revenue IS NULL THEN NULL
        ELSE ROUND(
            ((monthly_revenue - previous_month_revenue) / previous_month_revenue) * 100, 
            2
        )
    END AS month_over_month_growth,
    revenue_rank
FROM product_performance
WHERE revenue_rank <= 10
ORDER BY month DESC, revenue_rank ASC;
```

### Bash/Shell Scripts

DevOps automation script:

```bash
#!/bin/bash

# Deploy script with error handling and logging
set -euo pipefail

# Configuration
DEPLOY_ENV="${1:-staging}"
APP_NAME="insights-blog"
BACKUP_DIR="/backups/${APP_NAME}"
LOG_FILE="/var/log/deploy-$(date +%Y%m%d-%H%M%S).log"

# Functions
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

cleanup() {
    log "Performing cleanup..."
    # Remove temporary files
    rm -f /tmp/${APP_NAME}-*.tar.gz
}

# Set up error handling
trap cleanup EXIT

# Main deployment process
deploy() {
    log "Starting deployment to $DEPLOY_ENV environment"
    
    # Pre-deployment checks
    if ! command -v docker &> /dev/null; then
        log "ERROR: Docker not found"
        exit 1
    fi
    
    # Create backup
    log "Creating backup..."
    mkdir -p "$BACKUP_DIR"
    docker exec ${APP_NAME}_db pg_dump -U postgres ${APP_NAME} > \
        "${BACKUP_DIR}/backup-$(date +%Y%m%d-%H%M%S).sql"
    
    # Build and deploy
    log "Building application..."
    docker-compose -f docker-compose.${DEPLOY_ENV}.yml build --no-cache
    
    log "Stopping current containers..."
    docker-compose -f docker-compose.${DEPLOY_ENV}.yml down
    
    log "Starting new containers..."
    docker-compose -f docker-compose.${DEPLOY_ENV}.yml up -d
    
    # Health check
    log "Performing health check..."
    for i in {1..30}; do
        if curl -f http://localhost:8080/health &> /dev/null; then
            log "Health check passed"
            break
        fi
        
        if [ $i -eq 30 ]; then
            log "ERROR: Health check failed"
            exit 1
        fi
        
        sleep 10
    done
    
    log "Deployment completed successfully"
}

# Run deployment
deploy
```

## Advanced Markdown Features

### Tables

| Language | Performance | Learning Curve | Use Cases |
|----------|-------------|----------------|-----------|
| **JavaScript** | ⭐⭐⭐ | ⭐⭐⭐⭐ | Web development, Full-stack |
| **Python** | ⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ | Data science, AI/ML, Web APIs |
| **PHP** | ⭐⭐⭐ | ⭐⭐⭐⭐ | Web development, CMS |
| **Go** | ⭐⭐⭐⭐⭐ | ⭐⭐⭐ | Microservices, DevOps |
| **Rust** | ⭐⭐⭐⭐⭐ | ⭐⭐ | Systems programming, Performance |

### Task Lists

- [x] Enhanced syntax highlighting for 30+ languages
- [x] GitHub Flavored Markdown support
- [x] Code copy buttons and line numbers
- [x] Table styling with hover effects
- [ ] Math expressions with LaTeX support
- [ ] Mermaid diagram support
- [ ] Custom alert boxes

### Blockquotes and Callouts

> **Pro Tip:** Always use semantic versioning for your APIs and provide comprehensive documentation. This makes it easier for other developers to integrate with your services.

> **Warning:** Never store sensitive information like API keys or passwords in your source code. Use environment variables or secure configuration management systems.

### Links and References

Check out these useful resources:
- [MDN Web Docs](https://developer.mozilla.org/) for web standards
- [Laravel Documentation](https://laravel.com/docs) for PHP framework guidance
- [React Documentation](https://reactjs.org/docs) for frontend development

### Inline Code and Emphasis

Use `npm install` to install packages, or use **Ctrl+Shift+P** to open the command palette in VS Code.

### Strikethrough and Emphasis

~~Old approach~~: Manual string concatenation for SQL queries  
**New approach**: Using prepared statements and parameterized queries

### Horizontal Rules

---

## Conclusion

This enhanced markdown implementation provides comprehensive syntax highlighting for numerous programming languages, GitHub Flavored Markdown support, and advanced features like task lists, tables, and callouts. The styling maintains excellent readability while providing a professional appearance suitable for technical documentation and blog posts.

**Key Features:**
- ✅ 30+ programming languages supported
- ✅ Copy-to-clipboard functionality for code blocks
- ✅ Line numbers for longer code snippets
- ✅ Language labels on code blocks
- ✅ Responsive design for mobile devices
- ✅ Dark mode support
- ✅ GitHub-style table formatting
- ✅ Enhanced typography with Medium.com inspiration