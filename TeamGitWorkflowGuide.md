# UOVT Student Management System

## Team Git Workflow Guide

This guide defines how the team should use Git to keep work organized, reduce merge conflicts, and maintain a clean development flow.

## Branch Structure

We use three branch types:

| Branch | Purpose | Notes |
|---|---|---|
| main | Final production code | Only the project lead merges here. Do not work directly on this branch. |
| dev | Shared development branch | All completed features are merged here. |
| feature/* | Personal working branches | Every task should be developed in a feature branch. |

Examples:

- feature/anuradha-login-system
- feature/lakmali-ui-design
- feature/charith-database-procedures

## Daily Workflow

### 1. Sync first

```bash
git checkout dev
git pull origin dev
```

This ensures your local branch includes the latest team changes.

### 2. Create a feature branch

```bash
git checkout -b feature/your-name-feature
```

Example:

```bash
git checkout -b feature/lakmali-dashboard-ui
```

### 3. Work on the feature

Implement your changes in PHP, SQL, UI, or any other required area.

### 4. Commit your work

```bash
git add .
git commit -m "feat: add student dashboard UI"
```

Commit message rules:

- feat: new feature
- fix: bug fix
- refactor: code improvement
- docs: documentation update

### 5. Push the branch

```bash
git push origin feature/your-branch-name
```

### 6. Open a pull request

In GitHub, create a pull request using:

- Base branch: dev
- Compare branch: feature/your-branch

This means: “Please review my work and add it to the project.”

### 7. Review and merge

The team lead should:

- Check code quality
- Review database queries
- Confirm there are no errors
- Approve the pull request

Then merge into dev.

### 8. Clean up after merge

After the branch is merged:

```bash
git branch -d feature/your-branch
git push origin --delete feature/your-branch
```

## Rules

- Do not push directly to main
- Do not work directly on dev
- Always pull latest changes before starting work
- Do not mix multiple features in one branch

## Before Starting a New Task

Always sync again:

```bash
git checkout dev
git pull origin dev
```

## Quick Workflow Summary

1. `git checkout dev`
2. `git pull`
3. `git checkout -b feature/your-feature`
4. Code your feature
5. `git add` and commit
6. `git push`
7. Create PR to dev
8. Team lead merges

## Team Understanding Model

| Term | Meaning |
|---|---|
| dev | Shared team workspace |
| feature | Your personal workspace |
| PR | Request to merge work into the team codebase |
| merge | Official integration into the shared branch |

## Goal

- No code conflicts
- Clean collaboration
- Easy debugging
- Professional development practice
- Industry-standard workflow
