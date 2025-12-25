---
title: HTML-DOM
layout: cheatsheet
---

## Resource

### Online

    Official Website
    DOM Enlightenment

### Download

    W3C DOM in one page
    XPath, CSS, DOM and Selenium: The Rosetta Stone [table .pdf]
    XPath, CSS, DOM and Selenium: The Rosetta Stone [groups .pdf]

### Related

    CSS
    DTD
    HTML
    Selenium
    XHTML
    XML
    XML Schema
    XPath
    XSL
    XSLT

## DOM Events

### Mouse Events

    click
    dblclick
    mousedown
    mousemove
    mouseover
    mouseout
    mouseup

### Keyboard Events

    keydown
    keypress
    keyup

### Frame Events

    abort
    error
    load
    resize
    scroll
    unload

### Form Events

    blur
    change
    focus
    reset
    select
    onsubmit

### Event Object Constant

    AT_TARGET
    BUBBLING_PHASE
    CAPTURING_PHASE

### Event Object Properties

    bubbles
    cancelable
    currentTarget
    eventPhase
    target
    timeStamp
    type

### Event Object Methods

    initEvent()
    preventDefault()
    stopPropagation()

### EventTarget Object

    addEventListener()
    dispatchEvent()
    removeEventListener()

### EventListener Object

    handleEvent()

### MouseEvent/KeyboardEvent Object

    altKey
    button
    clientX
    clientY
    ctrlKey
    keyIdentifier
    keyLocation
    metaKey
    relatedTarget
    screenX
    screenY
    shiftKey

### MouseEvent/KeyboardEvent Methods

    initMouseEvent()
    initKeyboardEvent()

## HTML DOM

### Elements Properties

    accessKey
    className
    clientHeight
    clientWidth
    dir
    id
    innerHTML
    lang
    offsetHeight
    offsetLeft
    offsetParent
    offsetTop
    offsetWidth
    scrollHeight
    scrollLeft
    scrollTop
    scrollWidth
    style
    tabIndex
    title

### Elements Methods

    toString()

### Document Properties

    anchors
    applets
    body
    cookie
    documentMode
    domain
    forms
    images
    lastModified
    links
    readyState
    referrer
    title
    URL

### Document Methods

    close()
    getElementsByName()
    open()
    write()
    writeln()

### HTML Object Properties

    align
    archive
    border
    code
    codeBase
    codeType
    data
    declare
    form
    height
    hspace
    name
    standby
    type
    useMap
    vspace
    width

### Area Object Properties

    alt
    coords
    shape
    target

### Base Object Properties

    href
    hash
    host
    hostname
    href
    noHref
    pathname
    port
    protocol
    search

### Body Object Properties

    aLink
    background
    bgColor
    link
    text
    vLink

### Frame Object Properties

    align
    contentDocument
    frameBorder
    height
    longDesc
    marginHeight
    marginWidth
    name
    noResize
    scrolling
    src
    width

### Meta Properties

    content
    httpEquiv
    name
    scheme

## DOM Input

### Button Properties

    disabled
    form
    name
    type
    value

### Checkbox Properties

    disabled
    checked
    form
    name
    type
    value

### File Properties

    disabled
    accept
    form
    name
    type
    value

### Hidden Properties

    form
    name
    type
    value

### Password Properties

    defaultValue
    disabled
    form
    maxLength
    name
    readOnly
    size
    type
    value

### Password Methods

    select()

### Radio Properties

    checked
    defaultChecked
    disabled
    form
    name
    type
    value

### Reset Properties

    disabled
    form
    name
    type
    value

### Submit Properties

    disabled
    form
    name
    type
    value

### Text Properties

    defaultValue
    disabled
    form
    maxLength
    name
    readOnly
    size
    type
    value

### Text Methods

    select()

## Dom Elements

### Anchor Object Properties

    charset
    href
    hreflang
    name
    rel
    rev
    target
    type

### Button Object Properties

    disabled
    form
    name
    type
    value

### Form Object Properties

    acceptCharset
    action
    enctype
    length
    method
    name
    target

### Form Object Methods

    reset()
    submit()

### Form Object Events

    onreset
    onsubmit

### Image Object Properties

    align
    alt
    border
    complete
    height
    hspace
    longDesc
    lowsrc
    name
    src
    useMap
    vspace
    width

### Image Object Events

    onabort
    onerror
    onload

### Link Properties

    charset
    href
    hreflang
    media
    rel
    rev
    type

### Option Properties

    defaultSelected
    disabled
    form
    index
    selected
    text
    value

### Select Properties

    disabled
    form
    length
    multiple
    name
    selectedIndex
    size
    type

### Select Methods

    add()
    remove()

### Textarea Properties

    cols
    defaultValue
    disabled
    form
    name
    readOnly
    rows
    type
    value

## Dom Style

### Background Properties

    background
    backgroundAttachment
    backgroundColor
    backgroundImage
    backgroundPosition
    backgroundRepeat

### Border/Outline Properties

    border
    borderBottom
    borderBottomColor
    borderBottomStyle
    borderBottomWidth
    borderColor
    borderLeft
    borderLeftColor
    borderLeftStyle
    borderLeftWidth
    borderRight
    borderRightColor
    borderRightStyle
    borderRightWidth
    borderStyle
    borderTop
    borderTopColor
    borderTopStyle
    borderTopWidth
    borderWidth
    outline
    outlineColor
    outlineStyle
    outlineWidth

### Generated Content Properties

    content
    counterIncrement
    counterReset

### List Properties

    listStyle
    listStyleImage
    listStylePosition
    listStyleType

### Margin/Padding Properties

    margin
    marginBottom
    marginLeft
    marginRight
    marginTop
    padding
    paddingBottom
    paddingLeft
    paddingRight
    paddingTop

### Misc Properties

    cssText

### Positioning Properties

    bottom
    clear
    clip
    cssFloat
    cursor
    display
    height
    left
    maxHeight
    maxWidth
    minHeight
    minWidth
    overflow
    position
    right
    top
    verticalAlign
    visibility
    width
    zIndex

### Printing Properties

    orphans
    pageBreakAfter
    pageBreakBefore
    pageBreakInside
    widows

### Table Properties

    borderCollapse
    borderSpacing
    captionSide
    emptyCells
    tableLayout

### Text Properties

    color
    direction
    font
    fontFamily
    fontSize
    fontSizeAdjust
    fontStyle
    fontVariant
    fontWeight
    letterSpacing
    lineHeight
    quotes
    textAlign
    textDecoration
    textIndent
    textShadow
    textTransform
    unicodeBidi
    whiteSpace
    wordSpacing

## Dom Table

### Table Object Collections

    cells
    rows
    tBodies

### Table Properties

    caption
    cellPadding
    cellSpacing
    frame
    rules
    summary
    tFoot
    tHead

### Table Methods

    createCaption()
    createTFoot()
    createTHead()
    deleteCaption()
    deleteRow()
    deleteTFoot()
    deleteTHead()
    insertRow()

### Td/Th Properties

    abbr
    axis
    cellIndex
    ch
    chOff
    colSpan
    headers
    rowSpan
    vAlign

### Tr Properties

    abbr
    axis
    cellIndex
    ch
    chOff
    colSpan
    headers
    rowSpan
    vAlign
