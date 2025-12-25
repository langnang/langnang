---
created: 2022-11-16T10:54:02 (UTC +08:00)
tags: []
source: https://overapi.com/mysql
author: OverAPI
---

# MySQL Cheat Sheet | OverAPI.com

> ## Excerpt
> OverAPI.com is a site collecting all the cheatsheets,all!

---
## Resource

## Data Types

### Types

-   CHAR
-   String (0 - 255)
-   VARCHAR
-   String (0 - 255)
-   TINYTEXT
-   String (0 - 255)
-   TEXT
-   String (0 - 65535)
-   BLOB
-   String (0 - 65535)
-   MEDIUMTEXT
-   String (0 - 16777215)
-   MEDIUMBLOB
-   String (0 - 16777215)
-   LONGTEXT
-   String (0 - 429496-7295)
-   LONGBLOB
-   String (0 - 429496-7295)
-   TINYINT x
-   Integer (-128 to 127)
-   SMALLINT x
-   Integer (-32768 to 32767)
-   MEDIUMINT x
-   Integer (-8388608 to 8388607)
-   INT x
-   Integer (-2147-483648 to 214748-3647)
-   BIGINT x
-   Integer (-9223-372-036-854-775808 to 922337-203-685-477-5807)
-   FLOAT
-   Decimal (precise to 23 digits)
-   DOUBLE
-   Decimal (24 to 53 digits)
-   DECIMAL
-   "-DOU-BLE-" stored as string
-   DATE
-   YYYY-MM-DD
-   DATETIME
-   YYYY-MM-DD HH:MM:SS
-   TIMESTAMP
-   YYYYMM-DDH-HMMSS
-   TIME
-   HH:MM:SS
-   ENUM
-   One of preset options
-   SET
-   Selection of preset options

## String

### String Functions

-   [ASCII()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_ascii "Return numeric value of left-most character")
-   [BIN()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_bin "Return a string representation of the argument")
-   [BIT\_LENGTH()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_bit-length "Return length of argument in bits")
-   [CHAR\_LENGTH()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_char-length "Return number of characters in argument")
-   [CHAR()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_char "Return the character for each integer passed")
-   [CHARACTER\_LENGTH()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_character-length "A synonym for CHAR_LENGTH()")
-   [CONCAT\_WS()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_concat-ws "Return concatenate with  separator")
-   [CONCAT()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_concat "Return concatenated string")
-   [ELT()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_elt "Return string at index number")
-   [EXPORT\_SET()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_export-set "Return a string such that for every bit set in the value  bits, you get an on string and for every unset bit, you get an off string")
-   [FIELD()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_field "Return the index (position) of the first argument  in the subsequent arguments")
-   [FIND\_IN\_SET()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_find-in-set "Return the index position of  the first argument within the second argument")
-   [FORMAT()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_format "Return a number formatted to specified number of decimal places")
-   [HEX()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_hex "Return a hexadecimal representation of a  decimal or string value")
-   [INSERT()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_insert "Insert a substring at the specified position up to  the specified number of characters")
-   [INSTR()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_instr "Return the index of the first occurrence of substring")
-   [LCASE()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_lcase "Synonym for LOWER() ")
-   [LEFT()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_left "Return the leftmost number of characters as specified")
-   [LENGTH()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_length "Return the length of a string in bytes")
-   [LIKE](http://dev.mysql.com/doc/refman/5.5/en/string-comparison-functions.html#operator_like "Simple pattern matching")
-   [LOAD\_FILE()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_load-file "Load the named file")
-   [LOCATE()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_locate "Return the position of the first occurrence  of substring")
-   [LOWER()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_lower "Return the argument in lowercase ")
-   [LPAD()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_lpad "Return the string argument, left-padded  with the specified string")
-   [LTRIM()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_ltrim "Remove leading spaces")
-   [MAKE\_SET()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_make-set "Return a set of comma-separated strings  that have the corresponding bit in bits set")
-   [MATCH](http://dev.mysql.com/doc/refman/5.5/en/fulltext-search.html#function_match "Perform full-text search")
-   [MID()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_mid "Return a substring starting from the specified position")
-   [NOT LIKE](http://dev.mysql.com/doc/refman/5.5/en/string-comparison-functions.html#operator_not-like "Negation of simple pattern matching")
-   [NOT REGEXP](http://dev.mysql.com/doc/refman/5.5/en/regexp.html#operator_not-regexp "Negation of REGEXP")
-   [OCTET\_LENGTH()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_octet-length "A synonym for LENGTH()")
-   [ORD()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_ord "Return character code for leftmost character of the  argument")
-   [POSITION()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_position "A synonym for LOCATE()")
-   [QUOTE()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_quote "Escape the argument for use in an SQL statement")
-   [REGEXP](http://dev.mysql.com/doc/refman/5.5/en/regexp.html#operator_regexp "Pattern matching using regular expressions")
-   [REPEAT()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_repeat "Repeat a string the specified number of times")
-   [REPLACE()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_replace "Replace occurrences of a specified string")
-   [REVERSE()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_reverse "Reverse the characters in a string")
-   [RIGHT()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_right "Return the specified rightmost number of characters")
-   [RLIKE](http://dev.mysql.com/doc/refman/5.5/en/regexp.html#operator_regexp "Synonym for REGEXP")
-   [RPAD()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_rpad "Append string the specified number of times")
-   [RTRIM()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_rtrim "Remove trailing spaces")
-   [SOUNDEX()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_soundex "Return a soundex string")
-   [SOUNDS LIKE](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#operator_sounds-like "Compare sounds")
-   [SPACE()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_space "Return a string of the specified number of spaces")
-   [STRCMP()](http://dev.mysql.com/doc/refman/5.5/en/string-comparison-functions.html#function_strcmp "Compare two strings")
-   [SUBSTR()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_substr "Return the substring as specified")
-   [SUBSTRING\_INDEX()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_substring-index "Return a substring from a  string before the specified number of occurrences of the delimiter")
-   [SUBSTRING()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_substring "Return the substring as specified")
-   [TRIM()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_trim "Remove leading and trailing spaces")
-   [UCASE()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_ucase "Synonym for UPPER()")
-   [UNHEX()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_unhex "Convert each pair of hexadecimal digits  to a character")
-   [UPPER()](http://dev.mysql.com/doc/refman/5.5/en/string-functions.html#function_upper "Convert to uppercase")

## Date

### Date and Time

-   [ADDDATE()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_adddate "Add time values (intervals) to a date value")
-   [ADDTIME()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_addtime "Add time")
-   [CONVERT\_TZ()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_convert-tz "Convert from one timezone to another")
-   [CURDATE()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_curdate "Return the current date")
-   [CURRENT\_DATE(), CURRENT\_DATE](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_current-date "Synonyms for CURDATE()")
-   [CURRENT\_TIME(), CURRENT\_TIME](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_current-time "Synonyms for CURTIME()")
-   [CURRENT\_TIMESTAMP(), CURRENT\_TIMESTAMP](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_current-timestamp "Synonyms for NOW()")
-   [CURTIME()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_curtime "Return the current time")
-   [DATE\_ADD()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_date-add "Add time values (intervals) to a date value")
-   [DATE\_FORMAT()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_date-format "Format date as specified")
-   [DATE\_SUB()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_date-sub "Subtract a time value (interval) from a date")
-   [DATE()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_date "Extract the date part of a date or datetime expression")
-   [DATEDIFF()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_datediff "Subtract two dates")
-   [DAY()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_day "Synonym for DAYOFMONTH()")
-   [DAYNAME()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_dayname "Return the name of the weekday")
-   [DAYOFMONTH()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_dayofmonth "Return the day of the month (0-31)")
-   [DAYOFWEEK()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_dayofweek "Return the weekday index of the argument")
-   [DAYOFYEAR()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_dayofyear "Return the day of the year (1-366)")
-   [EXTRACT()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_extract "Extract part of a date")
-   [FROM\_DAYS()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_from-days "Convert a day number to a date")
-   [FROM\_UNIXTIME()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_from-unixtime "Format UNIX timestamp as a date")
-   [GET\_FORMAT()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_get-format "Return a date format string")
-   [HOUR()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_hour "Extract the hour")
-   [LAST\_DAY](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_last-day "Return the last day of the month for the argument")
-   [LOCALTIME(), LOCALTIME](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_localtime "Synonym for NOW()")
-   [LOCALTIMESTAMP, LOCALTIMESTAMP()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_localtimestamp "Synonym for NOW()")
-   [MAKEDATE()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_makedate "Create a date from the year and day of year")
-   [MAKETIME](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_maketime "MAKETIME()")
-   [MICROSECOND()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_microsecond "Return the microseconds from argument")
-   [MINUTE()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_minute "Return the minute from the argument")
-   [MONTH()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_month "Return the month from the date passed")
-   [MONTHNAME()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_monthname "Return the name of the month")
-   [NOW()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_now "Return the current date and time")
-   [PERIOD\_ADD()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_period-add "Add a period to a year-month")
-   [PERIOD\_DIFF()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_period-diff "Return the number of months between periods")
-   [QUARTER()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_quarter "Return the quarter from a date argument")
-   [SEC\_TO\_TIME()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_sec-to-time "Converts seconds to 'HH:MM:SS' format")
-   [SECOND()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_second "Return the second (0-59)")
-   [STR\_TO\_DATE()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_str-to-date "Convert a string to a date")
-   [SUBDATE()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_subdate "A synonym for DATE_SUB() when invoked with three arguments")
-   [SUBTIME()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_subtime "Subtract times")
-   [SYSDATE()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_sysdate "Return the time at which the function executes")
-   [TIME\_FORMAT()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_time-format "Format as time")
-   [TIME\_TO\_SEC()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_time-to-sec "Return the argument converted to seconds")
-   [TIME()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_time "Extract the time portion of the expression passed")
-   [TIMEDIFF()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_timediff "Subtract time")
-   [TIMESTAMP()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_timestamp "With a single argument, this function returns the date or  datetime expression; with two arguments, the sum of the arguments")
-   [TIMESTAMPADD()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_timestampadd "Add an interval to a datetime expression")
-   [TIMESTAMPDIFF()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_timestampdiff "Subtract an interval from a datetime expression")
-   [TO\_DAYS()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_to-days "Return the date argument converted to days")
-   [TO\_SECONDS()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_to-seconds "Return the date or datetime argument converted to seconds since  Year 0")
-   [UNIX\_TIMESTAMP()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_unix-timestamp "Return a UNIX timestamp")
-   [UTC\_DATE()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_utc-date "Return the current UTC date")
-   [UTC\_TIME()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_utc-time "Return the current UTC time")
-   [UTC\_TIMESTAMP()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_utc-timestamp "Return the current UTC date and time")
-   [WEEK()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_week "Return the week number")
-   [WEEKDAY()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_weekday "Return the weekday index")
-   [WEEKOFYEAR()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_weekofyear "Return the calendar week of the date (0-53)")
-   [YEAR()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_year "Return the year")
-   [YEARWEEK()](http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_yearweek "Return the year and week")

## Group

## Encrypt

## Miscellaneous

## Samples

### Select Queires

-   Returns all columns
-   SELECT \* FROM table
-   Returns all columns
-   SELECT \* FROM table1, table2, ...
-   Returns specific column
-   SELECT field1, field2, ... FROM table1, table2, ...
-   Returns rows that match condition
-   SELECT ... FROM ... WHERE condition
-   Returns with orders
-   SELECT ... FROM ... WHERE condition GROUP BY field
-   Returns withd orders and match condition
-   SELECT ... FROM ... WHERE condition GROUP BY field HAVING condition2
-   Returns first 10 rows
-   SELECT ... FROM ... WHERE condition LIMIT 10
-   Returns with no repeats
-   SELECT DISTINCT field1 FROM ...
-   Returns and joind
-   SELECT ... FROM t1 JOIN t2 ON t1.id1 = t2.id2 WHERE condition
