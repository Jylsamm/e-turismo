## 2026-07-28 - Conditional Aggregation Optimization
**Learning:** Multiple `count()` or simple aggregate queries on the same table with different conditions can lead to an N+1 query-like bottleneck, increasing roundtrips.
**Action:** Used conditional aggregation (`SUM(CASE WHEN condition THEN 1 ELSE 0 END)`) via `selectRaw` to consolidate multiple queries into a single query.
