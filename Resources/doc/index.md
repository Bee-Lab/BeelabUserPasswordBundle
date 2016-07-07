BeelabUserPasswordBundle Documentation
======================================

1. [Install Bundle](#1-install-bundle)
2. [Configuration](#2-configuration)
3. [Customizations](#3-customizations)
4. [Events](#4-events)

### 1. Install Bundle

Run from terminal:

```bash
$ composer require beelab/user-password-bundle
```

Enable bundle in the kernel:

```php
<?php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Beelab\UserBundle\BeelabUserPasswordBundle(),
    );
}
```

If you didn't already installted [BeelabUserBundle](https://github.com/Bee-Lab/BeelabUserBundle), that bundle needs to
be activated also. Please refer to BeelabUserBundle documentation.

### 2. Configuration

Create a `ResetPassword` entity class.
Example:

```php
<?php

namespace AppBundle\Entity;

use Beelab\UserPasswordBundle\Entity\ResetPassword as BaseResetPassword;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class ResetPassword extends BaseResetPassword
{
    /**
     * @var User (adapt this to your actual User entity)
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;
}

```

Insert in main configuration:

```yaml
# app/config/config.yml

# BeelabUserPassword Configuration
beelab_user_password:
    password_reset_class: AppBundle\Entity\ResetPassword
    email_parameters:
        # following values need to be customized
        template: '::email_reset_password.html.twig'
        subject: Your reset password mail subject
        sender: noreply@example.com
```

### 3. Customization

You can extends bundle forms, then add to configuration:

```yaml
# app/config/config.yml

beelab_user_password:
    password_reset_form_type: AppBundle\Form\Type\PasswordResetFormType
    new_password_form_type:   AppBundle\Form\Type\NewPasswordFormType
```

### 4. Events

Bundle exposes two events: `beelab_user.new_password` and `beelab_user.change_password`.

First event is used internally by bundle, and is fired when user asks for a password reset.

Second event is fired when user chooses a new password: you can listen to it, if you need to perform some special
actions at this point.
