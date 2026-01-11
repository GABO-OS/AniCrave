# AniCrave Database ERD

This document provides a visual representation of the AniCrave database structure and the relationships between its tables.

## Entity Relationship Diagram

```mermaid
erDiagram
    USERS ||--o{ FAVORITES : "has"
    ANIME ||--o{ FAVORITES : "is favorited by"
    ANIME ||--o{ CHARACTERS : "has"

    USERS {
        int id PK "Unique User ID"
        string username "Unique login name"
        string email "Unique email address"
        string password_hashed "Secured password"
        string gender "User gender"
        date birthday "User birthdate"
        string contact "Phone/Contact number"
        text bio "User biography"
        string profile_picture "Path to avatar"
        timestamp created_at "Account creation time"
    }

    ANIME {
        int id PK "Unique Anime ID"
        string title "Anime name"
        string cover_image "Portrait image URL"
        string banner_image "Landscape image URL"
        text description "Synopsis/Summary"
        string genres "List of categories"
        int year "Release year"
        string season "Release season"
        string type "Format (TV, Movie)"
        enum status "Airing status"
    }

    FAVORITES {
        int id PK "Favorite ID"
        int user_id FK "References USER(id)"
        int anime_id FK "References ANIME(id)"
        string anime_title "Denormalized title"
        timestamp added_at "Timestamp added"
    }

    CHARACTERS {
        int id PK "Character ID"
        int anime_id FK "References ANIME(id)"
        string name "Character name"
        string char_role "Character role (Main/Supp)"
        string image_url "Portrait image URL"
    }
```

## Relationship Details

### 1. Users (USER) to Favorites

- **Type**: One-to-Many (`1:N`)
- **Description**: A single user can have multiple entries in the favorites table.
- **Constraint**: `favorites.user_id` references `user.id`.

### 2. Anime to Favorites

- **Type**: One-to-Many (`1:N`)
- **Description**: A single anime can appear in many users' favorite lists.
- **Constraint**: `favorites.anime_id` references `anime.id`.

### 3. Anime to Characters

- **Type**: One-to-Many (`1:N`)
- **Description**: Each anime series has a collection of characters associated with it.
- **Constraint**: `characters.anime_id` references `anime.id`.

---

> [!TIP]
> This diagram uses the **Mermaid** syntax. You can view it rendered in VS Code, GitHub, or any Mermaid-compatible markdown viewer.
