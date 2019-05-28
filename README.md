<p align=center><img height=150 src="https://raw.githubusercontent.com/php-protein/docs/master/assets/protein-large.png"></p>

# Protein | Map
## Handle a repository of key-values data

### Install
---

```
composer require proteins/map
```

Require the class via :

```php
use Proteins\Map;
```


### Building a Dictionary
---

Dictionary is a behaviour class, it must be extended by another class or the value repository will be shared.

```php
class State extends Dictionary {}
```

### Setting a value
---

You can set a value from a key path via the `get` method.

A valid key path is a arbitrary deep sequence of `.` separated strings.

**Examples**

- `test`
- `alpha.beta`
- `pages.section.text_block.3`


```php
State::set('options.use_cache',false);

State::set('users.whitelist',[
	'frank.ciccio',
	'walter.submarine',
	'pepen.spacca',
]);
```

### Getting a value
---

You can get a value from a key path via the `get` method.

```php
echo State::get('users.whitelist.1'); // walter.submarine
```
You can optionally pass a default value to be returned when the requested key is not found. If a callable is passed the returned value will be used.

```php
print_r( State::get('a.test',['b'=>123]) ); // Array( [b] => 123 )
echo State::get('a.test.b'); // 123
```

### Getting all values
---

You can get all key-values as an associative array via the `all` method.

```php
$all_data = State::all();
```

Results :

```php
Array (
    [users] => Array (
        [whitelist] => Array(
            [0] => frank.ciccio
            [1] => walter.submarine
            [2] => pepen.spacca
        )
    )
)
```
### Clearing the Map
---

You can clear all values from a Map via the `clear` method.

```php
State::clear();
```

### Merging data
---
The `merge` method extends the Map with values passed via an associative array. The second optional parameter will define the if merge data from right-to-left or backwise (default is false = left-to-right ).

**Setting initial data**

```php
State::clear();
State::merge([
    'user' => [
        'name' => 'Simon',
        'role' => 'Villain',
    ],
]);
```


```php
Array (
    [user] => Array (
            [name] => Simon
            [role] => Villain
        )
)
```

**Standard merge (left-to-right)**

```php
State::merge([
    'user' => [
        'name' => 'Frank',
    ],
    'happy' => true,
]);
```


```php
Array (
    [user] => Array (
            [name] => Frank
            [role] => Villain
        )
    [happy] => 1
)
```
**Back merge (right-to-left)**

```php
State::merge([
    'user' => [
        'name' => 'Frank',
    ],
    'happy' => true,
],true);
```


```php
Array (
    [user] => Array (
            [name] => Simon
            [role] => Villain
        )
    [happy] => 1
)
```


### Getting multiple values
---

You can retrieve multiple values, minimizing function calls by passing an associative array of type :

```
DESTINATION_KEY => Map_PATH
```

**Example** :

```
MyService::init([
    'username'   =>  State::get('aws.username'),
    'password'   =>  State::get('aws.password'),
    'from'       =>  State::get('user.email'),
    'verbose'    =>  State::get('app.global.debug'),
]);
```

Can be written with a single call to `get` as :

```
MyService::init( State::get([
    'username'   =>  'aws.username',
    'password'   =>  'aws.password',
    'from'       =>  'user.email',
    'verbose'    =>  'app.global.debug',
]));
```
