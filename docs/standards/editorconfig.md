---
---

# Standard.EditorConfig

```ini
# /.editorconfig

# EditorConfig is awesome: https://EditorConfig.org

# top-most EditorConfig file
root = true

[*]
indent_style = space
indent_size = 4
end_of_line = crlf
charset = utf-8
trim_trailing_whitespace = false
insert_final_newline = false

[*.md]
trim_trailing_whitespace = false
max_line_length = 3600

[*.{yml,yaml,html,css,js,php}]
indent_size = 2

[docker-compose.yml]
indent_size = 4
```
