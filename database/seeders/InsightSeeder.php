<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Insight;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InsightSeeder extends Seeder
{
    public function run()
    {
        // Create a user with random data
        $user = User::firstOrCreate([
            'email' => 'support@ekilie.com',
        ], [
            'name' => "Sasi W Sasi",
            'password' => bcrypt('tachy2004'),
        ]);

        // Get all categories and tags
        $categories = Category::all()->keyBy('name');
        $tags = Tag::all()->keyBy('name');

        // Create realistic insights with proper content-tag-category matching
        $realInsights = [
            // Technology Category
            [
                'category' => 'Technology',
                'title' => 'The Future of Web Development: Trends to Watch in 2024',
                'content' => '<h2>Introduction</h2><p>Web development continues to evolve rapidly, with new technologies and frameworks emerging every year. As we look ahead to 2024, several key trends are shaping the future of how we build and interact with web applications.</p><h2>Progressive Web Apps (PWAs)</h2><p>Progressive Web Apps are becoming increasingly important, offering native app-like experiences through web browsers. They provide offline functionality, push notifications, and improved performance, making them an attractive alternative to traditional mobile apps.</p><h2>AI Integration</h2><p>Artificial Intelligence is being integrated into web development workflows, from code generation tools to automated testing and optimization. This is revolutionizing how developers approach problem-solving and productivity.</p><h2>Conclusion</h2><p>The future of web development is exciting, with these trends promising to make applications faster, more accessible, and more intelligent. Staying updated with these developments is crucial for any web developer.</p>',
                'tags' => ['JavaScript', 'API', 'Best Practices', 'Tutorial']
            ],
            [
                'category' => 'Web Development',
                'title' => 'Building Your First React Application: A Complete Guide',
                'content' => '<h2>Getting Started with React</h2><p>React has become one of the most popular JavaScript libraries for building user interfaces. In this comprehensive guide, we\'ll walk through creating your first React application from scratch.</p><h2>Setting Up Your Environment</h2><p>Before we begin, you\'ll need Node.js installed on your system. We\'ll use Create React App to bootstrap our project quickly and efficiently.</p><pre><code>npx create-react-app my-first-app\ncd my-first-app\nnpm start</code></pre><h2>Understanding Components</h2><p>React applications are built using components - reusable pieces of code that return JSX. Components can be functional or class-based, with functional components being the modern standard.</p><h2>State Management</h2><p>Managing state in React is crucial for building interactive applications. We\'ll explore useState hook and how to handle user interactions effectively.</p><h2>Next Steps</h2><p>Once you\'ve mastered the basics, consider exploring React Router for navigation, Context API for state management, and testing with Jest and React Testing Library.</p>',
                'tags' => ['React', 'JavaScript', 'Tutorial', 'Best Practices']
            ],
            [
                'category' => 'Web Development',
                'title' => 'Laravel Best Practices: Writing Clean and Maintainable Code',
                'content' => '<h2>Why Code Quality Matters</h2><p>Writing clean, maintainable code in Laravel isn\'t just about following conventions—it\'s about creating applications that scale, perform well, and are easy for teams to work with over time.</p><h2>Follow Laravel Conventions</h2><p>Laravel provides excellent conventions out of the box. Use Eloquent relationships properly, follow naming conventions for routes, controllers, and models, and leverage Laravel\'s built-in features rather than reinventing the wheel.</p><h2>Service Layer Pattern</h2><p>Implement a service layer to keep your controllers thin and business logic organized. This makes your code more testable and maintainable.</p><pre><code>class UserService\n{\n    public function createUser(array $data): User\n    {\n        return User::create([\n            \'name\' => $data[\'name\'],\n            \'email\' => $data[\'email\'],\n            \'password\' => Hash::make($data[\'password\'])\n        ]);\n    }\n}</code></pre><h2>Testing is Essential</h2><p>Write tests for your application. Laravel provides excellent testing tools with PHPUnit integration. Feature tests, unit tests, and browser tests all play important roles in maintaining code quality.</p>',
                'tags' => ['Laravel', 'PHP', 'Best Practices', 'Tutorial']
            ],
            [
                'category' => 'Software Engineering',
                'title' => 'Understanding Database Design Principles',
                'content' => '<h2>Database Design Fundamentals</h2><p>Good database design is the foundation of any successful application. Poor design decisions early on can lead to performance issues, data inconsistency, and maintenance nightmares down the road.</p><h2>Normalization</h2><p>Database normalization helps eliminate data redundancy and ensures data integrity. Understanding the different normal forms (1NF, 2NF, 3NF) is crucial for creating efficient database schemas.</p><h2>Indexing Strategy</h2><p>Proper indexing can dramatically improve query performance. However, over-indexing can slow down write operations. Understanding when and how to create indexes is essential for database optimization.</p><h2>Relationships and Constraints</h2><p>Define clear relationships between tables using foreign keys and constraints. This ensures data integrity and helps prevent orphaned records and inconsistent data states.</p><h2>Performance Considerations</h2><p>Consider query patterns, expected data volume, and access patterns when designing your database schema. Sometimes denormalization is necessary for performance reasons.</p>',
                'tags' => ['Database', 'Best Practices', 'Performance']
            ],
            [
                'category' => 'Cybersecurity',
                'title' => 'Web Application Security: Common Vulnerabilities and Prevention',
                'content' => '<h2>The Importance of Web Security</h2><p>Web application security is more critical than ever. With cyber attacks becoming increasingly sophisticated, developers must be proactive in identifying and preventing common vulnerabilities.</p><h2>SQL Injection Prevention</h2><p>SQL injection remains one of the most common attacks. Always use parameterized queries or prepared statements, and never concatenate user input directly into SQL queries.</p><h2>Cross-Site Scripting (XSS)</h2><p>XSS attacks occur when malicious scripts are injected into web pages. Prevent XSS by properly sanitizing and escaping user input, using Content Security Policy headers, and validating data on both client and server sides.</p><h2>Authentication and Authorization</h2><p>Implement strong authentication mechanisms, use secure session management, and ensure proper authorization checks at every level of your application.</p><h2>HTTPS and Data Encryption</h2><p>Always use HTTPS for data transmission, encrypt sensitive data at rest, and implement proper key management practices.</p>',
                'tags' => ['Security', 'Best Practices', 'API']
            ],
            
            // Life Category
            [
                'category' => 'Life',
                'title' => 'The Art of Work-Life Balance in the Tech Industry',
                'content' => '<h2>The Challenge of Balance</h2><p>Working in technology often means long hours, tight deadlines, and the pressure to constantly learn new skills. Finding balance between professional growth and personal well-being is crucial for long-term success and happiness.</p><h2>Setting Boundaries</h2><p>Learn to set clear boundaries between work and personal time. This includes having dedicated work hours, creating a separate workspace if working from home, and learning to disconnect from work-related communications after hours.</p><h2>The Importance of Continuous Learning</h2><p>While it\'s important to stay current with technology trends, balance learning with rest and recreation. Allocate specific time for skill development rather than feeling pressured to learn constantly.</p><h2>Building Meaningful Relationships</h2><p>Don\'t let career ambitions overshadow personal relationships. Invest time in friendships, family, and romantic relationships. These connections provide support, perspective, and joy that career success alone cannot provide.</p><h2>Mental Health Awareness</h2><p>Recognize the signs of burnout and stress. Practice mindfulness, exercise regularly, and don\'t hesitate to seek professional help when needed. Your mental health is just as important as your career.</p>',
                'tags' => ['Life Style', 'Mental Health', 'Tips']
            ],
            [
                'category' => 'Health & Fitness',
                'title' => 'Staying Healthy as a Software Developer',
                'content' => '<h2>The Developer\'s Health Challenge</h2><p>Software development often involves long hours sitting at a desk, which can lead to various health issues including back pain, eye strain, and repetitive stress injuries. Taking proactive steps to maintain your health is essential.</p><h2>Ergonomic Workspace Setup</h2><p>Invest in a good chair that supports proper posture, position your monitor at eye level to prevent neck strain, and use an ergonomic keyboard and mouse to reduce the risk of repetitive stress injuries.</p><h2>The 20-20-20 Rule</h2><p>Every 20 minutes, look at something 20 feet away for at least 20 seconds. This simple practice can help reduce eye strain and prevent computer vision syndrome.</p><h2>Regular Exercise</h2><p>Incorporate physical activity into your daily routine. This could be morning workouts, evening walks, or even short movement breaks during the workday. Exercise improves both physical and mental health.</p><h2>Proper Nutrition</h2><p>Avoid the trap of constantly snacking or relying on caffeine and sugar for energy. Plan healthy meals and snacks, stay hydrated, and consider meal prep to maintain consistent nutrition.</p>',
                'tags' => ['Life Style', 'Tips', 'Mental Health']
            ],
            [
                'category' => 'Productivity',
                'title' => 'Time Management Techniques for Developers',
                'content' => '<h2>The Developer\'s Time Dilemma</h2><p>Between coding, debugging, meetings, and learning new technologies, developers often struggle with time management. Implementing effective techniques can dramatically improve productivity and reduce stress.</p><h2>The Pomodoro Technique</h2><p>Work in focused 25-minute intervals followed by 5-minute breaks. After four pomodoros, take a longer 15-30 minute break. This technique helps maintain focus and prevents burnout.</p><h2>Time Blocking</h2><p>Dedicate specific blocks of time to different types of work. For example, reserve mornings for deep coding work, afternoons for meetings and code reviews, and late afternoons for learning and documentation.</p><h2>Task Prioritization</h2><p>Use frameworks like the Eisenhower Matrix to categorize tasks by importance and urgency. Focus on important tasks first, and learn to delegate or eliminate less critical activities.</p><h2>Minimizing Distractions</h2><p>Identify your main distractions and create strategies to minimize them. This might involve using website blockers, setting specific times for checking email, or finding a quiet workspace.</p>',
                'tags' => ['Tips', 'Best Practices', 'Life Style']
            ],
            
            // Love Category
            [
                'category' => 'Love',
                'title' => 'Building Meaningful Relationships in the Digital Age',
                'content' => '<h2>Love in the Time of Technology</h2><p>Technology has fundamentally changed how we meet, connect, and maintain relationships. While digital tools offer new opportunities for connection, they also present unique challenges for building meaningful relationships.</p><h2>Authentic Communication</h2><p>In a world of texts and emojis, authentic communication becomes more valuable. Practice active listening, express emotions clearly, and don\'t be afraid to have difficult conversations face-to-face when possible.</p><h2>Quality Time vs. Screen Time</h2><p>Balance digital interaction with real-world connection. Plan activities that don\'t involve screens, practice being present during conversations, and create tech-free zones in your relationship.</p><h2>Trust in Digital Spaces</h2><p>Building trust requires transparency and consistency, both online and offline. Be honest about your digital habits, respect privacy boundaries, and maintain the same values across all platforms.</p><h2>Growing Together</h2><p>Relationships require intentional effort to grow and evolve. Support each other\'s goals, share new experiences, and be willing to adapt as both individuals and as a couple.</p>',
                'tags' => ['Relationships', 'Love Stories', 'Tips']
            ],
            [
                'category' => 'Love',
                'title' => 'Dating as a Software Developer: Tips and Insights',
                'content' => '<h2>The Unique Challenges of Developer Dating</h2><p>Dating as a software developer comes with unique challenges and opportunities. From explaining what you do to finding someone who appreciates your passion for technology, here are insights for navigating the dating world.</p><h2>Explaining Your Work</h2><p>Learn to explain your work in simple, relatable terms. Focus on the impact of what you build rather than the technical details. Share your excitement about solving problems and creating solutions that help people.</p><h2>Finding Compatible Partners</h2><p>Look for partners who appreciate intellectual curiosity, problem-solving, and continuous learning, even if they\'re not in tech. Shared values and interests matter more than shared professions.</p><h2>Work-Life Balance in Dating</h2><p>Don\'t let work consume your dating life. Set boundaries around work hours, be present during dates, and make time for relationship-building activities that don\'t involve computers.</p><h2>Embracing Your Unique Perspective</h2><p>Your analytical thinking, attention to detail, and problem-solving skills are attractive qualities. Don\'t hide your passion for technology—find someone who appreciates and supports your interests.</p>',
                'tags' => ['Dating', 'Relationships', 'Tips']
            ],
            
            // Technology Category - More Python/Node.js content
            [
                'category' => 'Technology',
                'title' => 'Python vs Node.js: Choosing the Right Backend Technology',
                'content' => '<h2>The Backend Technology Decision</h2><p>Choosing between Python and Node.js for your backend development can be challenging. Both have their strengths and are suited for different types of applications and team preferences.</p><h2>Python Advantages</h2><p>Python excels in data science, machine learning, and scientific computing. Its clean syntax makes it beginner-friendly, and frameworks like Django and Flask provide robust web development capabilities. The extensive library ecosystem is unmatched.</p><h2>Node.js Advantages</h2><p>Node.js shines in real-time applications, APIs, and when you want to use JavaScript across your entire stack. Its event-driven, non-blocking I/O model makes it excellent for handling concurrent requests efficiently.</p><h2>Performance Considerations</h2><p>Node.js generally offers better performance for I/O intensive applications, while Python may perform better for CPU-intensive tasks, especially with libraries like NumPy that are implemented in C.</p><h2>Making the Choice</h2><p>Consider your team\'s expertise, project requirements, performance needs, and ecosystem requirements when making this decision. Both are excellent choices for different scenarios.</p>',
                'tags' => ['Python', 'Node.js', 'API', 'Best Practices']
            ],
            [
                'category' => 'Web Development',
                'title' => 'Building RESTful APIs: Best Practices and Common Pitfalls',
                'content' => '<h2>RESTful API Design Principles</h2><p>REST (Representational State Transfer) has become the standard for web API design. Understanding and implementing REST principles correctly is crucial for building maintainable and scalable APIs.</p><h2>HTTP Methods and Status Codes</h2><p>Use HTTP methods appropriately: GET for retrieval, POST for creation, PUT for updates, DELETE for removal. Always return appropriate status codes: 200 for success, 201 for creation, 404 for not found, 500 for server errors.</p><h2>Resource Naming Conventions</h2><p>Use nouns for resources, not verbs. Keep URLs simple and intuitive: /users for user collections, /users/123 for specific users. Use plural nouns consistently.</p><h2>Authentication and Security</h2><p>Implement proper authentication (JWT, OAuth) and authorization. Always use HTTPS, validate input data, and implement rate limiting to prevent abuse.</p><h2>Documentation and Versioning</h2><p>Provide comprehensive API documentation and implement versioning strategy from the beginning. Tools like OpenAPI/Swagger can help maintain up-to-date documentation.</p>',
                'tags' => ['API', 'Best Practices', 'Security', 'Tutorial']
            ],
            [
                'category' => 'Technology',
                'title' => 'Complete Markdown Guide: Syntax Highlighting and Advanced Features Demo',
                'content' => file_get_contents(__DIR__ . '/markdown-demo-content.md'),
                'tags' => ['Tutorial', 'Best Practices', 'API', 'JavaScript']
            ]
        ];

        // Create insights with proper tag relationships
        foreach ($realInsights as $insightData) {
            $category = $categories->get($insightData['category']);
            
            if (!$category) {
                continue; // Skip if category doesn't exist
            }

            $insight = Insight::create([
                'title' => $insightData['title'],
                'content' => $insightData['content'],
                'slug' => Str::slug($insightData['title']) . '-' . uniqid(),
                'user_id' => $user->id,
                'category_id' => $category->id,
            ]);

            // Attach relevant tags
            $tagIds = collect($insightData['tags'])
                ->map(fn($tagName) => $tags->get($tagName))
                ->filter()
                ->pluck('id')
                ->toArray();

            if (!empty($tagIds)) {
                $insight->tags()->attach($tagIds);
            }

            // Add realistic comments
            $comments = [
                'Great article! This really helped me understand the concepts better.',
                'Thanks for sharing this insight. Very well explained.',
                'I had similar challenges and this approach worked perfectly.',
                'Looking forward to more content like this.',
                'This is exactly what I was looking for. Thank you!',
            ];

            Comment::create([
                'comment' => $comments[array_rand($comments)],
                'user_id' => $user->id,
                'insight_id' => $insight->id,
            ]);
        }
    }
}
