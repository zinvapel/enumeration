# BaseEnumeration class
Usage examples:
- Own enum:
```php
<?php

namespace App\Status;

use Zinvapel\Enumeration\BaseEnumeration;

class Status extends BaseEnumeration
{
    public const ACTIVE = 'active';
    
    public const INACTIVE = 'inactive';
    
    protected $names = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive', 
    ];
    
    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->eq(self::ACTIVE);        
    }
}
```

- In code:
```php
...
$status = new Status(Status::INACTIVE);

if ($status->neq(new Status(Status::ACTIVE))) {
    // do something with not active status
}
...
```

- With static constructors:
```php
<?php

namespace App\Status;

use Zinvapel\Enumeration\BaseEnumeration;

class Status extends BaseEnumeration
{
    public const ACTIVE = 'active';
    
    protected $names = [
        self::ACTIVE => 'Active', 
    ];
    
    /**
     * @return Status
     */
    public static function active(): Status
    {
        return new self(self::ACTIVE);        
    }
}
```
