# README #

## composer.json ##

### Edit composer.json ###

```json
{
	"repositories": [
		{
			"type": "git",
			"url": "https://dspventures@bitbucket.org/dspdevteam/composer-ntriga-teamleader.git"
		}
	]
}
```

### Require package ###

```
composer require ntriga/teamleader:dev-master
```

## PHP ##


### Get Teamleader instance ###

```php
use Ntriga\Teamleader;

require __DIR__ . '/../vendor/autoload.php';

$tl = new Teamleader('tl_group', 'tl_secret');

### Add front user ###

```php
use Ntriga\Teamleader;

require __DIR__ . '/../vendor/autoload.php';

$tl = new Teamleader('tl_group', 'tl_secret');
$contact_id = $tl->add_front_user($user);

var_dump($contact_id);
```