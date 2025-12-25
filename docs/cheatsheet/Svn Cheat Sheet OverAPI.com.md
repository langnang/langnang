---
created: 2023-03-07T19:42:25 (UTC +08:00)
tags: []
source: https://overapi.com/svn
author: OverAPI
---

# Svn Cheat Sheet | OverAPI.com

> ## Excerpt
> OverAPI.com is a site collecting all the cheatsheets,all!

---
## Resource

### Online

-   [Official Website](http://subversion.apache.org/)

### Download

-   [Subversion Cheat Sheet \[.pdf\]](https://overapi.com/static/cs/subversion-cheat-sheet-v1.pdf)
-   [SVN Quick Reference Card \[.pdf\]](https://overapi.com/static/cs/svn-refcard.pdf)
-   [Cheat Sheet Subversion \[.pdf\]](https://overapi.com/static/cs/Cheat%20Sheet%20Subversion.pdf)

### Related

-   [Bazaar](https://overapi.com/bazaar "Bazaar Cheat Sheet")
-   [CVS](https://overapi.com/cvs "CVS Cheat Sheet")
-   [Git](https://overapi.com/git "Git Cheat Sheet")

## Component

-   svn
-   Command line program
-   svnversion
-   Revision of working copy
-   svnlook
-   Inspect repository
-   svnadmin
-   Repository administration
-   svndumpfilter
-   Filter repository stream
-   mod\_dav\_svn
-   Apache module
-   svnserve
-   SVN server (SVN protocol)
-   svnsync
-   Mirror repository

## Checkout & Help

### Checkout Working Copy

-   $ svn checkout "/path/to/repository"
-   Checkout working copy into current folder
-   $ svn checkout "/path/to/repository" "/path/to/folder"
-   Checkout working copy into target folder

### SVN Help

-   $ svn help
-   $ svn help import
-   Show help for "import" command

## Commit

-   $ svn commit "/path"
-   Commit changes to path
-   $ svn commit -m "Message" "/path"
-   Commit with log message
-   $ svn commit -N "/path"
-   Commit without recursion
-   $ svn import "/path/to/folder" "/path"
-   Import and commit local folder

## Update

-   $ svn update "/path"
-   Update path
-   $ svn update -r9 "/path"
-   Update path to revision 9

## Diff / Revert / Merge

### Differences Between Files

-   $ svn diff "/path/file"
-   $ svn diff "/path/file@2" "/path/file@7"
-   $ svn diff -r 2:7 "/path/folder"

### Revert

-   $ svn revert "/path"
-   Revert changes to path
-   $ svn revert -R "/path"
-   Revert changes recursively

### Merge Changes

-   $ svn merge -r2:7 "item" "/path"
-   Apply diff between revisions 2 and 7 of "item" to path
-   $ svn merge "url1" "url2" "/path"
-   Apply diff between "url1" and "url2" to path

## Add / Delete

### Add Files / Folders

-   $ svn add \*
-   Add all items, recursively
-   $ svn add itemname
-   Add itemname (if folder, adds recursively)
-   $ svn add \* --force
-   Force recursion into versioned directories

### Deleteing Copying Moving

-   $ svn delete "/path"
-   Delete path
-   $ svn -m "Delete message" delete "/path"
-   Delete with log message
-   $ svn copy "/source" "/target"
-   Copy source to target
-   $ svn move "/source" "/target"
-   Move source to target

## Logs and Blame

-   $ svn log "/path"
-   Show log messages for path
-   $ svn blame "/path"
-   Show commits for path

## Protocols

-   file://
-   Local machine
-   http://
-   HTTP (Apache)
-   https://
-   HTTPS (SSL)
-   svn://
-   SVN (svnserve)
-   svn+ssh://
-   SVN over SSH

## Repo Admin

-   $ svnadmin create "/path/to/repository"
-   Create new repository
-   $ svnadmin setlog "/path" r 7 message.txt
-   Change log message for revision 7 to contents of file message.txt
-   $ svnadmin dump "/path/to/repository" > filename
-   Dump repository to file (backup)
-   $ svnadmin load "/path/to/repository" < filename
-   Load repository from file (restore)

## Miscellaneous

-   $ svn resolve "/path"
-   Resolve conflict
-   $ svn cleanup "/path"
-   Remove locks and complete operations
-   $ svn lock "/path"
-   Lock path
-   $ svn unlock "/path"
-   Unlock path
-   $ svn status "/path"
-   Get path status
-   $ svn cat "/path"
-   View file contents

## Item and Property Statuses

-   No modifications (blank)
-   A
-   Addition
-   D
-   Deletion
-   M
-   Modified
-   R
-   Item replaced
-   C
-   In conflict
-   X
-   Externals definition
-   I
-   Ignored
-   ?
-   Not in repository
-   !
-   Item missing
-   ~
-   Object type changed

## Argument Shortcuts

-   \-m "Message"
-   \--message
-   \-q
-   \--quiet
-   \-v
-   \--verbose
-   \-r
-   \--revision
-   \-c
-   \--change
-   \-t
-   \--transaction
-   \-R
-   \--recursive
-   \-N
-   \--non-recursive
