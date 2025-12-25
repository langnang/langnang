---
created: 2023-03-07T19:42:33 (UTC +08:00)
tags: []
source: https://overapi.com/html
author: OverAPI
---

# HTML Cheat Sheet | OverAPI.com

> ## Excerpt
> OverAPI.com is a site collecting all the cheatsheets,all!

---
## Formatting

### Format

-   [<acronym>](https://developer.mozilla.org/en-US/docs/HTML/Element/acronym "Defines an acronym")
-   [<abbr>](https://developer.mozilla.org/en-US/docs/HTML/Element/abbr "Defines an abbreviation")
-   [<address>](https://developer.mozilla.org/en-US/docs/HTML/Element/address "Defines contact information for the author/owner of a document")
-   [<b>](https://developer.mozilla.org/en-US/docs/HTML/Element/b "Defines bold text")
-   [<bdo>](https://developer.mozilla.org/en-US/docs/HTML/Element/bdo "Overrides the current text direction")
-   [<big>](https://developer.mozilla.org/en-US/docs/HTML/Element/big "Defines big text")
-   [<blockquote>](https://developer.mozilla.org/en-US/docs/HTML/Element/blockquote "Defines a long quotation")
-   [<center>](https://developer.mozilla.org/en-US/docs/HTML/Element/center "Deprecated.Defines centered text")
-   [<cite>](https://developer.mozilla.org/en-US/docs/HTML/Element/cite "Defines a citation")
-   [<code>](https://developer.mozilla.org/en-US/docs/HTML/Element/code "Defines a piece of computer code")
-   [<del>](https://developer.mozilla.org/en-US/docs/HTML/Element/del "Defines text that has been deleted from a document")
-   [<dfn>](https://developer.mozilla.org/en-US/docs/HTML/Element/dfn "Defines a definition term")
-   [<em>](https://developer.mozilla.org/en-US/docs/HTML/Element/em "Defines emphasized text ")
-   [<font>](https://developer.mozilla.org/en-US/docs/HTML/Element/font "Deprecated.Defines font, color, and size for text")
-   [<i>](https://developer.mozilla.org/en-US/docs/HTML/Element/i "Defines italic text")
-   [<ins>](https://developer.mozilla.org/en-US/docs/HTML/Element/ins "Defines text that has been inserted into a document")
-   [<kbd>](https://developer.mozilla.org/en-US/docs/HTML/Element/kbd "Defines keyboard input")
-   [<pre>](https://developer.mozilla.org/en-US/docs/HTML/Element/pre "Defines preformatted text")
-   [<q>](https://developer.mozilla.org/en-US/docs/HTML/Element/q "Defines a short quotation")
-   [<s>](https://developer.mozilla.org/en-US/docs/HTML/Element/s "Deprecated.Defines strikethrough text")
-   [<samp>](https://developer.mozilla.org/en-US/docs/HTML/Element/samp "Defines sample output from a computer program")
-   [<small>](https://developer.mozilla.org/en-US/docs/HTML/Element/small "Defines smaller text")
-   [<strike>](https://developer.mozilla.org/en-US/docs/HTML/Element/strike "Deprecated.Defines strikethrough text")
-   [<strong>](https://developer.mozilla.org/en-US/docs/HTML/Element/strong "Defines strong text")
-   [<sub>](https://developer.mozilla.org/en-US/docs/HTML/Element/sub "Defines subscripted text")
-   [<sup>](https://developer.mozilla.org/en-US/docs/HTML/Element/sup "Defines superscripted text")
-   [<tt>](https://developer.mozilla.org/en-US/docs/HTML/Element/tt "Defines teletype text")
-   [<u>](https://developer.mozilla.org/en-US/docs/HTML/Element/u "Deprecated.Defines underlined text")
-   [<var>](https://developer.mozilla.org/en-US/docs/HTML/Element/var "Defines a variable")
-   <xmp>

## Others

## Attributes

## HTML Events

### <body>Events

-   onload
-   Script to be run when a document unload

### Form Events

-   onblur
-   onchange
-   onfocus
-   onreset
-   onselect
-   onsubmit

### Mouse Events

-   onclick
-   ondblclick
-   onmousedown
-   onmousemove
-   onmouseout
-   onmouseover
-   onmouseup

## Entities

### Character

-   " &#34;
-   & &#38;
-   < &#60;
-   \> &#62;
-   @ &#64;
-   € &#128;
-   • &#149;
-   ™ &#153;
-   £ &#163;
-     &#160;
-   © &#169;

## Status 1XX

### 1XX:Information

-   100 Continue
-   The server has received the request headers, and the client should proceed to send the request body
-   101 Switching Protocols
-   The requester has asked the server to switch protocols
-   103 Checkpoint
-   Used in the resumable requests proposal to resume aborted PUT or POST requests

## Status 2XX

### 2XX:Successful

-   200 OK
-   The request is OK (this is the standard response for successful HTTP requests)
-   201 Created
-   The request has been fulfilled, and a new resource is created
-   202 Accepted
-   The request has been accepted for processing, but the processing has not been completed
-   203 Non-Authoritative Information
-   The request has been successfully processed, but is returning information that may be from another source
-   204 No Content
-   The request has been successfully processed, but is not returning any content
-   205 Reset Content
-   The request has been successfully processed, but is not returning any content, and requires that the requester reset the document view
-   206 Partial Content
-   The server is delivering only part of the resource due to a range header sent by the client

## Status 3XX

### 3XX:Redirection

-   300 Multiple Choices
-   A link list. The user can select a link and go to that location. Maximum five addresses
-   301 Moved Permanently
-   The requested page has moved to a new URL
-   302 Found
-   The requested page has moved temporarily to a new URL
-   303 See Other
-   The requested page can be found under a different URL
-   304 Not Modified
-   Indicates the requested page has not been modified since last requested
-   306 Switch Proxy
-   _No longer used_
-   307 Temporary Redirect
-   The requested page has moved temporarily to a new URL
-   308 Resume Incomplete
-   Used in the resumable requests proposal to resume aborted PUT or POST requests

## Status 4XX

### 4XX:Client Error

-   400 Bad Request
-   The request cannot be fulfilled due to bad syntax
-   401 Unauthorized
-   The request was a legal request, but the server is refusing to respond to it. For use when authentication is possible but has failed or not yet been provided
-   402 Payment Required
-   Reserved for future use
-   403 Forbidden
-   The request was a legal request, but the server is refusing to respond to it
-   404 Not Found
-   The requested page could not be found but may be available again in the future
-   405 Method Not Allowed
-   A request was made of a page using a request method not supported by that page
-   406 Not Acceptable
-   The server can only generate a response that is not accepted by the client
-   407 Proxy Authentication Required
-   The client must first authenticate itself with the proxy
-   408 Request Timeout
-   The server timed out waiting for the request
-   409 Conflict
-   The request could not be completed because of a conflict in the request
-   410 Gone
-   The requested page is no longer available
-   411 Length Required
-   The "Content-Length" is not defined. The server will not accept the request without it
-   412 Precondition Failed
-   The precondition given in the request evaluated to false by the server
-   413 Request Entity Too Large
-   The server will not accept the request, because the request entity is too large
-   414 Request-URI Too Long
-   The server will not accept the request, because the URL is too long. Occurs when you convert a POST request to a GET request with a long query information
-   415 Unsupported Media Type
-   The server will not accept the request, because the media type is not supported
-   416 Requested Range Not Satisfiable
-   The client has asked for a portion of the file, but the server cannot supply that portion
-   417 Expectation Failed
-   The server cannot meet the requirements of the Expect request-header field

## Status 5XX

### 5XX:Server Error

-   500 Internal Server Error
-   A generic error message, given when no more specific message is suitable
-   501 Not Implemented
-   The server either does not recognize the request method, or it lacks the ability to fulfill the request
-   502 Bad Gateway
-   The server was acting as a gateway or proxy and received an invalid response from the upstream server
-   503 Service Unavailable
-   The server is currently unavailable (overloaded or down)
-   504 Gateway Timeout
-   The server was acting as a gateway or proxy and did not receive a timely response from the upstream server
-   505 HTTP Version Not Supported
-   The server does not support the HTTP protocol version used in the request
-   511 Network Authentication Required
-   The client needs to authenticate to gain network access
