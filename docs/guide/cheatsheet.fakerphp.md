---
layout: cheatsheet
title: Faker
source: http://fakerphp.org/formatters/
---


- http://fakerphp.org/

## Available Formatters - FakerPHP / Faker

### `Faker\Provider\en_US\Person`[#](http://fakerphp.org/formatters/#fakerprovideren_usperson "Permanent link")

```php
title($gender = null|'male'|'female') // 'Ms.' titleMale() // 'Mr.' titleFemale() // 'Ms.' suffix() // 'Jr.' name($gender = null|'male'|'female') // 'Dr. Zane Stroman' firstName($gender = null|'male'|'female') // 'Maynard' firstNameMale() // 'Maynard' firstNameFemale() // 'Rachel' lastName() // 'Zulauf'
```

### `Faker\Provider\en_US\Address`[#](http://fakerphp.org/formatters/#fakerprovideren_usaddress "Permanent link")

```php
cityPrefix() // 'Lake' secondaryAddress() // 'Suite 961' state() // 'NewMexico' stateAbbr() // 'OH' citySuffix() // 'borough' streetSuffix() // 'Keys' buildingNumber() // '484' city() // 'West Judge' streetName() // 'Keegan Trail' streetAddress() // '439 Karley Loaf Suite 897' postcode() // '17916' address() // '8888 Cummings Vista Apt. 101, Susanbury, NY 95473' country() // 'Falkland Islands (Malvinas)' latitude($min = -90, $max = 90) // 77.147489 longitude($min = -180, $max = 180) // 86.211205
```

### `Faker\Provider\en_US\PhoneNumber`[#](http://fakerphp.org/formatters/#fakerprovideren_usphonenumber "Permanent link")

```php
phoneNumber() // '827-986-5852' phoneNumberWithExtension() // '201-886-0269 x3767' tollFreePhoneNumber() // '(888) 937-7238' e164PhoneNumber() // '+27113456789'
```

### `Faker\Provider\en_US\Company`[#](http://fakerphp.org/formatters/#fakerprovideren_uscompany "Permanent link")

```php
catchPhrase() // 'Monitored regional contingency' bs() // 'e-enable robust architectures' company() // 'Bogan-Treutel' companySuffix() // 'and Sons' jobTitle() // 'Cashier'
```

### `Faker\Provider\en_US\Text`[#](http://fakerphp.org/formatters/#fakerprovideren_ustext "Permanent link")

```php
realText($maxNbChars = 200, $indexSize = 2) // "And yet I wish you could manage it?) 'And what are they made of?' Alice asked in a shrill, passionate voice. 'Would YOU like cats if you were never even spoke to Time!' 'Perhaps not,' Alice replied." realTextBetween($minNbChars = 160, $maxNbChars = 200, $indexSize = 2) // "VERY short remarks, and she ran across the garden, and I had not long to doubt, for the end of the bottle was NOT marked 'poison,' it is right?' 'In my youth,' Father William replied to his ear."
```

## Numbers and Strings - FakerPHP / Faker

[](https://github.com/FakerPHP/fakerphp.github.io/edit/main/docs/formatters/numbers-and-strings.md "Edit this page")

## `randomDigit`[#](http://fakerphp.org/formatters/numbers-and-strings/#randomdigit "Permanent link")

Generates a random integer from 0 until 9.

```php
echo $faker->randomDigit(); // an integer between 0 and 9
```

## `randomDigitNot`[#](http://fakerphp.org/formatters/numbers-and-strings/#randomdigitnot "Permanent link")

Generates a random integer from 0 until 9, excluding a given number.

```php
echo $faker->randomDigitNot(2); // 0, 1, 3, 4, 5, 6, 7, 8 or 9
```

## `randomDigitNotNull`[#](http://fakerphp.org/formatters/numbers-and-strings/#randomdigitnotnull "Permanent link")

Generates a random integer from 1 until 9.

```php
echo $faker->randomDigitNotNull(); // an integer between 1 and 9
```

## `randomNumber`[#](http://fakerphp.org/formatters/numbers-and-strings/#randomnumber "Permanent link")

Generates a random integer, containing between 0 and `$nbDigits` amount of digits. When the `$strict` parameter is `true`, it will only return integers with $nbDigits amount of digits.

```php
echo $faker->randomNumber(5, false); // 123, 43, 19238, 5, or 1203 echo $faker->randomNumber(5, true); // 12643, 42931, or 32919
```

## `randomFloat`[#](http://fakerphp.org/formatters/numbers-and-strings/#randomfloat "Permanent link")

Generates a random float. Optionally it's possible to specify the amount of decimals.

The second and third parameters optionally specify a lower and upper bound respectively.

```php
echo $faker->randomFloat(); // 12.9830, 2193.1232312, 102.12 echo $faker->randomFloat(2); // 43.23, 1203.49, 3428.93 echo $faker->randomFloat(1, 20, 30); // 21.7, 27.2, 28.1
```

## `numberBetween`[#](http://fakerphp.org/formatters/numbers-and-strings/#numberbetween "Permanent link")

Generates a random integer between `$min` and `$max`. By default, an integer is generated between `0` and `2,147,483,647` (32-bit integer).

```php
echo $faker->numberBetween(); // 120378987, 182, 102310983 echo $faker->numberBetween(0, 100); // 32, 87, 91, 13, 75
```

## `randomLetter`[#](http://fakerphp.org/formatters/numbers-and-strings/#randomletter "Permanent link")

Generates a random character from the alphabet.

```php
echo $faker->randomLetter(); // 'h', 'i', 'q'
```

## `randomElements`[#](http://fakerphp.org/formatters/numbers-and-strings/#randomelements "Permanent link")

Returns `$count` amount of random element from the given array, traversable, or enum. By default, the `$count` parameter is set to 1, when `null` a random number of elements is returned.

```php
echo $faker->randomElements(['a', 'b', 'c', 'd', 'e']); // ['c'] echo $faker->randomElements(['a', 'b', 'c', 'd', 'e'], null); // ['c', 'a', 'e'] echo $faker->randomElements(new \ArrayIterator(['a', 'b', 'c', 'd', 'e'])); // ['c'] enum Bar { case A = 'a'; case B = 'b'; case C = 'c'; case D = 'd'; case E = 'e'; } echo $faker->randomElements(Bar::class); // ['c'] echo $faker->randomElements(['a', 'b', 'c', 'd', 'e'], 3); // ['a', 'd', 'e']
```

## `randomElement`[#](http://fakerphp.org/formatters/numbers-and-strings/#randomelement "Permanent link")

Returns a random element from the given array, traversable, or enum.

```php
echo $faker->randomElement(['a', 'b', 'c', 'd', 'e']); // 'c' echo $faker->randomElement(new \ArrayIterator(['a', 'b', 'c', 'd', 'e'])); // 'c' enum Bar { case A = 'a'; case B = 'b'; case C = 'c'; case D = 'd'; case E = 'e'; } echo $faker->randomElement(Bar::class); // 'c'
```

## `randomKey`[#](http://fakerphp.org/formatters/numbers-and-strings/#randomkey "Permanent link")

Returns a random key from the given array.

```php
echo $faker->randomKey(['a' => 1, 'b' => 2, 'c' => 3]); // 'b'
```

## `shuffle`[#](http://fakerphp.org/formatters/numbers-and-strings/#shuffle "Permanent link")

Returns a shuffled version of either an array or string.

```php
echo $faker->shuffle('hello-world'); // 'lrhoodl-ewl' echo $faker->shuffle([1, 2, 3]); // [3, 1, 2]
```

## `numerify`[#](http://fakerphp.org/formatters/numbers-and-strings/#numerify "Permanent link")

Generate a string where all `#` characters are replaced by digits between 0 and 9. By default, `###` is used as input.

```php
echo $faker->numerify(); // '912', '271', '109', '674' echo $faker->numerify('user-####'); // 'user-4928', 'user-3427', 'user-1280'
```

## `lexify`[#](http://fakerphp.org/formatters/numbers-and-strings/#lexify "Permanent link")

Generate a string where all `?` characters are replaces with a random letter from the Latin alphabet. By default, `????` is used as input.

```php
echo $faker->lexify(); // 'sakh', 'qwei', 'adsj' echo $faker->lexify('id-????'); // 'id-xoqe', 'id-pqpq', 'id-zpeu'
```

## `bothify`[#](http://fakerphp.org/formatters/numbers-and-strings/#bothify "Permanent link")

Generate a string where `?` characters are replaced with a random letter, and `#` characters are replaces with a random digit between 0 and 9. By default, `## ??` is used as input.

```php
echo $faker->bothify(); // '46 hd', '19 ls', '75 pw' echo $faker->bothify('?????-#####'); // 'lsadj-10298', 'poiem-98342', 'lcnsz-42938'
```

## `asciify`[#](http://fakerphp.org/formatters/numbers-and-strings/#asciify "Permanent link")

Generate a string where `*` characters are replaced with a random character from the ASCII table. By default, `****` is used as input.

```php
echo $faker->asciify(); // '%Y+!', '{<"B', 'kF^a' echo $faker->asciify('user-****'); // 'user-ntwx', 'user-PK`A', 'user-n`,X'
```

## `regexify`[#](http://fakerphp.org/formatters/numbers-and-strings/#regexify "Permanent link")

Generate a random string based on a regex. By default, an empty string is used as input.

```php
echo $faker->regexify(); // '' echo $faker->regexify('[A-Z]{5}[0-4]{3}'); // 'DRSQX201', 'FUDPA404', 'CQVIU411'
```
