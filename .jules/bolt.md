
## 2024-05-18 - Dashboard Statistical Queries Optimization
**Learning:** Laravel's `where()->count()` pattern is frequently used to build statistical summaries, which creates multiple separate count queries. By converting these into a single query using `selectRaw()` with conditional `SUM(CASE WHEN ... THEN 1 ELSE 0 END)` statements, we can collapse multiple round-trips into a single query execution.
**Action:** Always look for multiple adjacent `count()` queries on the same table or scoped by the same constraints in Dashboard controllers or API endpoints, and refactor them into a single raw aggregation.
