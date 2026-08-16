---
name: loop-engineering
description: Runs a persistent, autonomous generate-verify-fix loop for coding and refactoring work that needs to keep going across many steps without re-prompting — large refactors, "build this feature end to end," "keep working until it's done/passes," unattended or overnight coding sessions, or any multi-step implementation where self-reported "done" isn't trustworthy on its own. Enforces independent verification (a generator never approves its own work), persists progress to AGENTS.md so work survives interruption, and won't declare completion without an independent pass. Use this whenever the goal is complex enough that a single generate-and-done pass is likely to miss defects, regressions, or unmet acceptance criteria.
compatibility: Best with a subagent/task-spawning tool (e.g. Claude Code's Task tool, Cowork subagents) so Generator and Verifier run in isolated contexts. Without one, degrade gracefully per "Roles without subagents" below — don't skip verification.
---

# Loop Engineering

Don't plan every implementation step up front. Instead, run the loop below, one small task at a time, until the goal is verifiably met. The loop *is* the plan — planning happens inside it, iteration by iteration, so it can react to what verification actually finds.

The whole point of this skill is that "the generator says it's done" is not evidence. Every claim of progress has to survive an independently-run check before it counts.

## The loop

Repeat this cycle until the stopping conditions below are met:

1. **Orient.** Read `AGENTS.md` (create it if absent — see State Persistence). Confirm the objective and acceptance criteria are still accurate; if this is the first iteration, write them down before doing anything else.
2. **Pick the next task.** Choose the smallest unit of work that moves toward the goal — not the whole feature at once. Small tasks are easier for the Verifier to check meaningfully and cheaper to redo if wrong.
3. **Generate.** Hand that one task, plus only the context it needs (task description, acceptance criteria, relevant file paths), to the Generator. Larger context windows tempt the Generator into scope creep; keep it scoped.
4. **Verify independently.** Hand the same task and acceptance criteria to the Verifier, separately from whatever the Generator reported. The Verifier re-derives its own evidence (runs tests, reads the diff, checks behavior) rather than trusting the Generator's summary — see Roles below for how to keep this independent in your environment.
5. **Decide.** 
   - Verifier passes → mark the task complete in `AGENTS.md`, move to the next task.
   - Verifier fails → log the specific findings in `AGENTS.md`, send them back to the Generator as the next task (a fix, not a restart), and increment that task's local retry count.
6. **Update the ledger.** Write the new state to `AGENTS.md` before starting the next cycle — see State Persistence.
7. **Check overall completion.** The goal is done only when every planned task is verified complete, there are no unresolved Verifier findings, and nothing was skipped. If so, do one final full Verifier pass against the original acceptance criteria (not just the last task) before declaring Complete.
8. **Check the stopping conditions** below before starting the next cycle.

## Stopping conditions

Runaway loops waste resources and can quietly thrash on a task the model can't actually solve. Apply caps and mean them:

* **Per-task retries:** if the same task fails Verifier review 3 times in a row, stop retrying it blindly. Summarize what's been tried and why it's still failing in `AGENTS.md`, and either try a materially different approach or pause and surface the blocker to the user — don't attempt a 4th near-identical fix.
* **Whole-loop budget:** agree on (or reasonably assume) a rough iteration or time budget for the overall goal. If you're going to blow through it, check in with the user rather than continuing silently — they may want to redirect, descope, or extend the budget.
* **No silent success declarations:** never mark `AGENTS.md` as Complete because progress stalled and continuing seemed unproductive. A stalled loop's honest end state is "blocked," not "complete."

## Roles

* **Orchestrator (you):** owns the loop above — sequences tasks, maintains `AGENTS.md`, interprets Generator and Verifier output, and decides whether to continue, retry, or stop. The Orchestrator never writes the implementation itself; that's the Generator's job, kept separate so the same reasoning isn't grading its own work.
* **Generator:** implements one scoped task at a time — writes code, fixes issues the Verifier raised, nothing more. Its own claim that something works is an input to verification, never a substitute for it.
* **Verifier:** independently checks the Generator's work against the actual acceptance criteria — runs or evaluates tests, reads the real diff, looks for regressions and omissions the Generator didn't mention. Gives a pass/fail with evidence, not a vibe check.

### Running roles as subagents

If a subagent/task-spawning tool is available, use it to give the Generator and Verifier genuinely separate contexts — pass each only its task and the relevant acceptance criteria, not your full orchestration history. Isolation is what makes the Verifier's judgment worth anything; if it inherits the Generator's framing of what happened, it tends to rubber-stamp rather than check.

### Roles without subagents

If no subagent tool is available, you can't get true context isolation, but you can still keep the discipline that matters: finish the Generator work and treat that reasoning as closed, then explicitly start a fresh Verifier pass that re-derives its evidence from the actual code, tests, or output — not from re-reading what the Generator said it did. Narrating the switch ("switching to Verifier: ignoring the above summary, checking the diff directly") helps keep the two passes honest.

## State Persistence

`AGENTS.md` at the project root is the loop's memory. It's how the workflow survives interruption without losing context, and how a resumed session (or a human checking in) can see what's actually happened.

**Before touching it, check whether it already exists for another purpose.** `AGENTS.md` is an increasingly common convention for repo-level instructions to coding agents in general (build steps, conventions, etc.), so an existing one may hold content that has nothing to do with this loop. Don't overwrite it. Instead, keep any existing content untouched and manage your own state inside a clearly delimited section:

```markdown
<!-- BEGIN LOOP-ENGINEERING STATE (auto-managed by loop-engineering skill) -->
## Objective
...
## Acceptance criteria
...
## Phase
Understanding | Planning | Building | Testing | Verifying | Fixing | Blocked | Complete
## Tasks
- [x] Completed task — verified iteration 2
- [ ] Active task — attempt 1
- [ ] Planned task
## Verifier findings (unresolved)
...
## Fixes attempted
...
## Iteration count
...
## Final verification status
...
<!-- END LOOP-ENGINEERING STATE -->
```

Update this section after every meaningful transition in the loop above (task picked up, Verifier verdict received, task completed, blocker hit) — not just at the end. If the loop is interrupted, the next session should be able to read this section alone and know exactly where things stand.

## Guardrails

* **The Generator never has final say over its own work** — pass/fail always comes from an independently-run Verifier pass, because a model checking its own output tends to confirm what it already believes it did.
* **"Code compiles" and "tests pass" are not the same as "task verified"** — the Verifier should still check the result against the actual acceptance criteria, since passing tests don't guarantee the tests covered the right thing.
* **Don't silently drop failed tests or unresolved Verifier findings** — carry them forward in `AGENTS.md` until something explicitly resolves them, so nothing gets lost between iterations.
* **Prefer several small, independently-verified changes over one large unverified one** — smaller diffs are easier for the Verifier to check meaningfully and cheaper to roll back if wrong.
* **Preserve existing project conventions** (style, structure, tooling choices) and avoid touching code unrelated to the current task — unrelated changes make it harder for the Verifier to isolate what actually changed and why.
* **If the loop truly can't make progress, say so plainly in `AGENTS.md`** — an honest "blocked, here's why, here's what was tried" is far more useful to whoever picks this up next than a false "complete."
