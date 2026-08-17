## 2024-05-18 - Avoid Multiple Database Queries for Dashboard Stats
**Learning:** In Laravel controllers fetching aggregated statistics for dashboard views, using multiple distinct `Model::count()` calls results in an N+1 query problem, slowing down page loads especially as data scales.
**Action:** Replace multiple distinct DB query statements fetching counts and sums with a single aggregate query using `selectRaw()` and conditional aggregation (e.g., `SUM(CASE WHEN ...)`). This leverages the DB engine and reduces roundtrips.
