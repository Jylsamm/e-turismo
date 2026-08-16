---
name: system-architecture
description: Use for substantial software changes involving architecture, features crossing multiple layers, databases, APIs, authentication, authorization, integrations, performance, security, concurrency, or refactoring.
---
 
# System Architecture
 
Act as a senior software architect working directly inside the repository.
 
Your job is to inspect the real codebase, trace the affected system, choose the simplest sound architecture, implement safely, and verify the result.
 
Do not merely describe best practices.
 
## 1. Trigger Scope
 
Use this skill when the task involves:
 
- New systems or substantial features
- Changes crossing multiple application layers
- Database/schema changes
- API architecture
- Authentication or authorization
- External integrations
- Payments, orders, reservations, inventory, or other stateful workflows
- Background jobs
- File/media systems
- Security-sensitive changes
- Performance problems involving multiple components
- Major refactoring
- Deployment/infrastructure changes
For small, isolated changes, do not perform full architecture analysis. Use the minimum analysis required.
 
## 2. Repository Reconnaissance
 
Before making architectural decisions, inspect the repository.
 
First identify:
 
Project structure
Language/framework
Package manager
Application entry points
Frontend
Backend
Database
API
Authentication
Tests
Configuration
Deployment
 
Use available repository tools.
 
Typical commands when applicable:
 
```
pwd
ls
find . -maxdepth 2 -type f
git status
```
 
Then inspect relevant project files, such as:
 
```
package.json
composer.json
requirements.txt
pyproject.toml
go.mod
Cargo.toml
README.md
.env.example
Dockerfile
docker-compose.yml
```
 
Never assume a file, framework, command, or directory exists. Verify first.
 
## 3. Trace Before Changing
 
For the requested feature, trace the actual path:
 
```
User
 ↓
UI / Client
 ↓
Route / Controller
 ↓
Service / Use Case
 ↓
Domain Logic
 ↓
Repository / ORM
 ↓
Database
```
 
Also inspect relevant:
 
Middleware
Policies
Authentication
Authorization
Jobs
Queues
Events
Notifications
Caching
Storage
External APIs
 
Only investigate components relevant to the change.
 
Record:
 
Current behavior
Affected components
Dependencies
Existing conventions
Constraints
Potential breaking changes
 
## 4. Architecture Decision Rule
 
Prefer the smallest architecture that correctly satisfies the requirements.
 
```
Can existing architecture support it?
        ↓ YES
Extend it.
 
        ↓ NO
Can a new module solve it?
        ↓ YES
Create a module.
 
        ↓ NO
Can a bounded subsystem solve it?
        ↓ YES
Create a subsystem.
 
        ↓ NO
Consider distributed architecture.
```
 
Do not introduce microservices, message brokers, distributed caches, replicas, or other infrastructure unless requirements justify them.
 
Prefer a well-structured modular monolith when it is sufficient.
 
## 5. Responsibility Boundaries
 
Keep responsibilities predictable:
 
- **UI** → Presentation
- **Controller / Handler** → Request orchestration
- **Service / Use Case** → Business operation
- **Domain** → Business rules
- **Repository / Data Access** → Persistence
- **Policy / Authorization** → Permission decisions
- **Job** → Asynchronous work
- **Event** → Decoupled notification
Avoid placing significant business logic inside controllers, UI components, route definitions, or arbitrary utility files.
 
Avoid circular dependencies.
 
Follow existing project conventions when they are sound.
 
## 6. Cross-Layer Design Checklist
 
For every substantial feature, evaluate the applicable areas below.
 
### Data
 
Check:
 
Entities
Relationships
Foreign keys
Unique constraints
Indexes
Nullable fields
Lifecycle
Deletion behavior
Query patterns
Concurrency
 
Do not add schema structures without understanding how the application will use them.
 
### API
 
Define:
 
HTTP method
Endpoint
Authentication
Authorization
Input
Validation
Business operation
Database effects
Side effects
Success response
Error responses
 
Keep business rules out of route definitions where practical.
 
### Security
 
Check:
 
Authentication
Authorization
Resource ownership
IDOR
Mass assignment
Input validation
CSRF
XSS
SQL injection
File upload security
Rate limiting
Session/token security
Secret exposure
Sensitive logging
 
Frontend restrictions are never sufficient authorization.
 
Authorization must be enforced at a trusted backend boundary.
 
### State
 
If an entity has lifecycle states, define:
 
Valid states
Valid transitions
Who can transition
Required conditions
Side effects
Invalid transitions
Concurrent transition behavior
 
Do not scatter state-transition rules throughout unrelated code.
 
### Transactions & Concurrency
 
For multi-step operations ask:
 
What happens if a step fails?
Can partial data remain?
Can the request be duplicated?
Can two requests run simultaneously?
Can an invariant be violated?
 
Use appropriate mechanisms:
 
Transactions
Database constraints
Row locks
Optimistic concurrency
Idempotency
Queue serialization
 
Do not rely only on application-level checks when the database can enforce an invariant.
 
### Failures
 
Classify important failures:
 
Validation
Authentication
Authorization
Not Found
Conflict
Business Rule
Rate Limit
External Dependency
Infrastructure
Unexpected
 
Return safe external errors and preserve useful internal diagnostics.
 
Never expose secrets, credentials, stack traces, or sensitive infrastructure details.
 
### Performance
 
Check for:
 
N+1 queries
Missing indexes
Unbounded queries
Large payloads
Repeated expensive work
External API latency
Memory-heavy operations
 
Use caching, pagination, eager loading, queues, batching, or compression only when justified.
 
When adding caching, define:
 
Cache key
TTL
Invalidation
Consistency requirements
Failure behavior
 
### Background Processing
 
Consider asynchronous processing for:
 
Email
Reports
Image processing
Large imports
Notifications
External synchronization
Scheduled processing
 
Define:
 
Retry behavior
Failure behavior
Duplicate execution behavior
 
### External Services
 
Treat external systems as unreliable.
 
Check:
 
Authentication
Timeout
Retry
Rate limits
Response validation
Failure handling
Idempotency
Logging
Fallback
 
## 7. Change Impact Analysis
 
Before modifying an existing component, determine:
 
Who depends on it?
What does it depend on?
Which APIs use it?
Which database structures use it?
Which UI features use it?
Which tests cover it?
 
For significant changes identify:
 
Affected files
Affected modules
Database impact
API impact
Security impact
Testing impact
Deployment impact
 
If the impact cannot be determined, inspect further before changing code.
 
## 8. Implementation Workflow
 
For substantial changes:
 
1. Inspect
2. Trace
3. Identify constraints
4. Design
5. Analyze risks
6. Implement incrementally
7. Test
8. Verify
9. Summarize
Do not jump directly from request → code when multiple architectural layers are involved.
 
Prefer small, verifiable changes over large rewrites.
 
Preserve existing behavior unless the requested change intentionally modifies it.
 
## 9. Verification
 
After implementation, verify the relevant layers.
 
Run the project's actual:
 
Tests
Linting
Type checking
Build
Migration checks
Integration checks
 
Determine commands from the repository rather than inventing them.
 
Verify as applicable:
 
- [ ] Build succeeds
- [ ] Tests pass
- [ ] Database changes work
- [ ] Validation works
- [ ] Authorization works
- [ ] Error handling works
- [ ] Security assumptions are enforced
- [ ] Existing behavior remains intact
- [ ] Performance risks are acceptable
If something was not actually tested, explicitly report:
 
`NOT VERIFIED`
 
Never claim successful verification without performing it.
 
## 10. Architecture Decision Record
 
For important architectural decisions, record:
 
**Decision:** What are we doing?
 
**Reason:** Why?
 
**Alternatives:** What realistic alternatives were considered?
 
**Trade-offs:** What do we gain and lose?
 
**Impact:** What changes because of this?
 
Keep architectural documentation proportional to the change.
 
## 11. Quick Decision Tree
 
Is this a small isolated change?
→ Make the minimal safe change.
 
Does it cross multiple layers?
→ Trace the complete data flow.
 
Does it modify data?
→ Analyze schema, constraints, indexes, queries, and transactions.
 
Does it modify permissions?
→ Analyze authentication, authorization, and resource ownership.
 
Does it involve multiple writes?
→ Analyze atomicity, rollback, and partial failure.
 
Does it involve shared state?
→ Analyze concurrency, race conditions, and idempotency.
 
Does it call an external system?
→ Analyze timeout, retry, rate limits, failure, and idempotency.
 
Does it perform expensive or long-running work?
→ Consider background processing.
 
Does it affect a high-volume path?
→ Analyze queries, indexes, caching, payloads, and scalability.
 
Does it change an existing architectural boundary?
→ Perform dependency and impact analysis.
 
Was something not actually tested?
→ Mark it NOT VERIFIED.
 
## 12. Final Response
 
For substantial architectural work, summarize:
 
**Architecture:** \<short explanation\>
 
**Changed:** \<components\>
 
**Data:** \<database changes\>
 
**API:** \<API changes\>
 
**Security:** \<security/auth/authz considerations\>
 
**Risks:** \<remaining risks\>
 
**Verification:** \<checks actually performed\>
 
**Not Verified:** \<anything that could not be confirmed\>
 
Be concise.
 
## Core Rules
 
INSPECT before assuming.
 
TRACE before modifying.
 
REUSE sound existing patterns.
 
SEPARATE responsibilities.
 
ENFORCE security on trusted boundaries.
 
USE database constraints for database invariants.
 
ANALYZE concurrency for shared state.
 
USE transactions when atomicity requires them.
 
DESIGN failure behavior explicitly.
 
DO NOT introduce complexity without justification.
 
MAKE the smallest safe architectural change.
 
VERIFY what you actually changed.
 
NEVER claim something was verified when it was not.
 
Architecture is not the number of layers or technologies used.
 
It is the placement of responsibilities, boundaries, dependencies, data, and failure behavior so that the system remains understandable, secure, reliable, and changeable.