@props([
    '__name' => 'SummerNote',
    '__slug' => 'jsoneditor',
    '__dscription' => null,
    '__github' => 'josdejong/jsoneditor',
    '__version' => null,
    '__author' => null,
    '__document' => 'https://github.com/josdejong/jsoneditor/',
    'name' => null,
    'slug' => null,
    'value' => null,
])

<div id="jsoneditor"></div>

@once
  @push('styles')
    <x-source :slug="$__slug" path="public/plugins/jsoneditor/10.2.0/img/jsoneditor-icons.svg" src="https://unpkg.com/jsoneditor@10.2.0/dist/img/jsoneditor-icons.svg" />
    <x-style :slug="$__slug" path="public/plugins/jsoneditor/10.2.0/jsoneditor.min.css" src="https://unpkg.com/jsoneditor@10.2.0/dist/jsoneditor.min.css" />
  @endpush

  @push('scripts')
    <!-- summernote -->
    <x-script :slug="$__slug" path="public/plugins/jsoneditor/10.2.0/jsoneditor.min.js" src="https://unpkg.com/jsoneditor@10.2.0/dist/jsoneditor.min.js" />
  @endpush
@endonce


@push('scripts')
  <script>
    $(function() {
      // create the editor
      const jsonEditor = new JSONEditor(document.getElementById("jsoneditor"), {
        escapeUnicode: false, // If true, unicode characters are escaped and displayed as their hexadecimal code (like \u260E) instead of the character itself (like ☎). false by default.
        sortObjectKeys: false, // If true, object keys in 'tree', 'view' or 'form' mode list be listed alphabetically instead by their insertion order. Sorting is performed using a natural sort algorithm, which makes it easier to see objects that have string numbers as keys. false by default.
        limitDragging: false, // If false, nodes can be dragged from any parent node to any other parent node. If true, nodes can only be dragged inside the same parent node, which effectively only allows reordering of nodes. By default, limitDragging is true when no JSON schema is defined, and false otherwise.
        history: false, // Enables history, adds a button Undo and Redo to the menu of the JSONEditor. true by default. Only applicable when mode is 'tree', 'form', or 'preview'.
        allowSchemaSuggestions: false, // Enables autocomplete suggestions based on the JSON schema.
        search: false, // Enables a search box in the upper right corner of the JSONEditor.
        mainMenuBar: false, // Adds main menu bar - Contains format, sort, transform, search etc. functionality.
        navigationBar: false, // Adds navigation bar to the menu - the navigation bar visualize the current position on the tree structure as well as allows breadcrumbs navigation.
        statusBar: false, // Adds status bar to the bottom of the editor - the status bar shows the cursor position and a count of the selected characters.
      })
      // set json
      const initialJson = {
        "Array": [1, 2, 3],
        "Boolean": true,
        "Null": null,
        "Number": 123,
        "Object": {
          "a": "b",
          "c": "d"
        },
        "String": "Hello World"
      }
      jsonEditor.set(@json($value))

      // get json
      const updatedJson = jsonEditor.get()
    })
  </script>
@endpush
