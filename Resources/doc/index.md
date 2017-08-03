BeelabUserPasswordBundle Documentation
======================================

1. [Installation](#1-installation)
2. [Configuration](#2-configuration)
3. [Customizations](#3-customizations)
4. [Events](#4-events)

### 1. Installation

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
    $bundles = [
        // ...
        new Beelab\UserPasswordBundle\BeelabUserPasswordBundle(),
    ];
}
```

If you didn't already installed [BeelabUserBundle](https://github.com/Bee-Lab/BeelabUserBundle), that bundle needs to
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

# BeelabUserPassword configuration
beelab_user_password:
    password_reset_class: AppBundle\Entity\ResetPassword
    email_parameters:
        # following values need to be customized
        template: '::email_reset_password.html.twig'  # accept 'user' and 'url' parameters
        subject: Your reset password mail subject
        sender: noreply@example.com
        bcc: youremail@example.com  # this is the only option that is not required
```

Add routes:

```yaml
# app/config/routing.yml

beelab_user_password:
    resource: '@BeelabUserPasswordBundle/Controller/'
    type: annotation
```

In case your firewall is requiring an authenticated user for whole application, don't forget to
add a security rule for the routes of this bundle, since the password reset procedure is supposed
to be performed by an anonymous user.

For example:

```yaml
# app/config/security.yml

security:
    access_control:
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/password, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/, roles: ROLE_USER }

```

### 3. Customization

You can extends bundle forms, then add to configuration:

```yaml
# app/config/config.yml

beelab_user_password:
    password_reset_form_type: AppBundle\Form\Type\PasswordResetFormType
    new_password_form_type: AppBundle\Form\Type\NewPasswordFormType
```

The following is an example of template for `email_parameters` options (see above)

```html+jinja
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta content="telephone=no" name="format-detection" />
	<title>Password reset</title>
	<style type="text/css" media="screen">
		body { padding:0 !important; margin:0 !important; display:block !important; -webkit-text-size-adjust:none; background:.background-body }
		a { color:#ec008c; text-decoration:underline }
		p { padding:0 !important; margin:0 !important }
	</style>
</head>
<body class="body" style="padding:0 !important; margin:0 !important; display:block !important; -webkit-text-size-adjust:none; background: #f9f9f9">
    <p>You requested a password reset for the following user: {{ user }}.</p>
    <p>If you did not request a reset, you can discard this message.</p>
    <p>Otherwhise, click on the following link to reset your password:</p>
    <p><a href="{{ url }}">{{ url }}</a></p>
</body>
</html>
```

### 4. Events

Bundle exposes two events: `beelab_user.new_password` and `beelab_user.change_password`.

First event is used internally by bundle, and is fired when user asks for a password reset.

Second event is fired when user chooses a new password: you can listen to it, if you need to perform some special
actions at this point.
