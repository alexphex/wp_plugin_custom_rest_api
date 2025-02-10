# wp_plugin_custom_rest_api
# made by me & Copilot

# Custom Posts REST API Plugin

This WordPress plugin adds a custom REST API endpoint to fetch all published posts with optional filters for categories, tags, authors, and publication dates.

## Features

- Fetch all published posts.
- Filter posts by category, tag, author, and publication dates.
- Returns data in JSON format.

## Installation

1. Download the plugin files.
2. Upload the plugin folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

### Endpoint

- `/wp-json/custom/v1/posts`

### Query Parameters

- `category`: Filter posts by category name.
- `tag`: Filter posts by tag name.
- `author`: Filter posts by author ID.
- `after`: Filter posts published after a specific date (format: `YYYY-MM-DD`).
- `before`: Filter posts published before a specific date (format: `YYYY-MM-DD`).
