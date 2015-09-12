# DevmachineOntheioBundle

[![Build Status](https://travis-ci.org/dev-machine/DevmachineOntheioBundle.svg?branch=master)](https://travis-ci.org/dev-machine/DevmachineOntheioBundle)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f69b2da6-d4ef-4263-a0e0-047ae3c0491e/mini.png)](https://insight.sensiolabs.com/projects/f69b2da6-d4ef-4263-a0e0-047ae3c0491e)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dev-machine/DevmachineOntheioBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/dev-machine/DevmachineOntheioBundle/?branch=master)

[onthe.io](https://i.onthe.io) image cloud API integration.

## Installation

Install this bundle using Composer. Add the following to your composer.json:

```javascript
{
    "require": {
        "devmachine/ontheio-bundle": "~1.0"
    }
}
```

Register bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...

        new Devmachine\Bundle\OntheioBundle\DevmachineOntheioBundle(),
        new Sensio\Bundle\BuzzBundle\SensioBuzzBundle(),
    );
}
```

Update config:

```yaml
devmachine_ontheio:
    image:
        key: "your-key"
        secret: "your-secret"
```

## Example usage

```php
/**
 * Demonstrates usage of:
 *
 *   - image client to upload images,
 *   - image helper to render hosted URLs.
 */
class MyController extends Controller
{
    /**
     * Upload remote URL to the cloud.
     */
    public function uploadUrlAction(Request $request)
    {
        // Get URL from request.
        $url = $request->query->get('url');
    
        // Upload image using URL.
        $result = $this->get('devmachine_ontheio.client.image')->uploadByUrl($url);
        
        // Key from image API - you can save this in DB.
        $key = $result->getKey();
        
        // Width of uploaded image.
        $width = $result->getWidth();
        
        // Height of uploaded image.
        $height = $result->getHeight();
        
        // Check if same URL was uploaded before.
        $new = $result->isNew();
        
        // You can render hosted URLs with image helper.
        return $this->render('PathToTemplate.html.twig', [
            // Hosted URL of original image
            'url' => $this->get('devmachine_ontheio.helper.image')->url($key),
            
            // Resize image into 200x150
            'thumbnail_url' => $this->get('devmachine_ontheio.helper.image')->resizeUrl($key, 200, 150),
            
            // Crop image into 150x150 starting from (50, 50)
            'avatar_url' => $this->get('devmachine_ontheio.helper.image')->cropUrl($key, 150, 150, 50, 50),
        ]);
    }
    
    /**
     * Upload image from file i.e. convert local file to hosted image.
     */
    public function uploadFileAction()
    {
        // Assuming $filepath is set.
        $result = $this->get('devmachine_ontheio.client.image')->uploadByFile($filepath);
    }
}
```

#### Twig helper

```twig
{# PathToTemplate.html.twig #}

Original:  <img src="{{ key | devmachine_ontheio_image_url }}" alt=""><br>
Thumbnail: <img src="{{ key | devmachine_ontheio_image_url(200, 150) }}" alt=""><br>
Avatar:    <img src="{{ key | devmachine_ontheio_image_url(150, 150, 50, 50) }}" alt="">
```

#### Note

The API docs suggests you can rotate and delete images. Albeit integration for these features was implemented, I wasn't able to achieve described functionality. You can examine `ImageClient::rotate()` and `ImageClient::delete()` methods.

## Form integration

You can integrate image uploads right into your form.

```php
/**
 * Example form type with images collection.
 */
class MyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('foo', 'text')
            ->add('bar', 'text')
            ->add('images', 'devmachine_ontheio_image_gallery')
        ;
    }
}
```

Bootstrap 3 theme:

![Gallery](https://raw.githubusercontent.com/dev-machine/DevmachineOntheioBundle/master/Resources/doc/gallery.jpg)

_Only image uploads by URL is supported at the moment._

Gallery form type assumes following Javascript and CSS code is present:

 - [Bootbox](http://bootboxjs.com)
 - [Magnific popup](http://dimsemenov.com/plugins/magnific-popup)

Example `bower.json`:

```javascript
{
    "dependencies": {
        "bootbox": "~4.4",
        "magnific-popup": "~1.0"
    }
}
```
