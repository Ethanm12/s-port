# Boilerplate Website


## Installation

1. Clone the repository from the remote repo into a folder named for your project:

    ```bash
    git clone git@github.com:tdcreative/boilerplate.git new-project
    ```

2. Install all composer dependencies.

    ```bash
    composer install
    ```

3. Copy the `.env.example` to `.env` and update the environment variables.

    ```bash
    cp .env.example .env
    ```

4. Update the MAIL `.env` variables from your `mailtrap.io` account.

5. Update the `/path/to/my/node` with the result of `which node` (e.g. `/usr/local/bin/node`)

6. Generate the application key.

    ```bash
    php artisan key:generate
    ```

7. Install node dependancies

    ```bash
    npm i
    ```


## Development

### Securing Installation (with `valet`)

1. Install valet if you haven't already, and park it in your sites directory. There is [extensive documentation](https://laravel.com/docs/7.x/valet#installation) for this on the laravel website.

2. Run `valet secure` from the site's root directory. You may need to input your sudo password.


3. Make sure that the APP_URL defined in `.env` reflects the url your site is being served from under valet.

4. Make sure to use the SSL build commands detailed below.

### Build

For a development build, simply run 

```bash
npm run dev
```

To have the site rebuilt after every change you make, run

```bash
npm run watch
```

And for hot module replacement, making any changes in place in the browser (Recommended)

```bash
npm run hot
```

If you are using `valet secure` to test over https, you will need to run the SSL version of these commands:

```bash
npm run devssl
npm run watchssl
npm run hotssl
```

For a production build

```bash
npm run prod
```

For insights into sources of bloat or to identify packages to remove or move to the vendor bundle, you can also build in analysis mode

```bash
npm run analyse
```

or for css analysis

```bash
npm run analyse-css
```


## Taking ownership of Boilerplate

### Delete the following sections from this readme once you are up and running

1. Unlink the git repository running `npm run claim`

2. On github, create a new repository for your project and follow instructions to push initial commit.

3. Globally search for all instances of the word boilerplate; replace with your app name as necessary (you can't just do global replace though)

Take note of instances of 'boilerplate' that you will need to come back and address (eg: `boilerplate_logo.png`)

### Contact Form

Edit `Requests/ContactRequest` to have the appropriate fields/rules
Edit `Notifications/InboxMessage.php` to have appropriate fields

> TODO: custom html template for emailed message

### Recaptcha

This boilerplate has it's own recaptcha keys which work when serving as `boilerplate.test`

You will need to set up recaptcha keys for your given site and copy these into `.env`

### Maps

A `Maps.vue` component is included with a wide range of options implemented.

> TODO: basic instructions for setting up and customising map - see comments within the `Maps.vue` component

## Routing

### Backend 

All pages are defined in the `PageController@webView` method. This is because they are all client-side rendered. They will all return `welcome.blade.php` and Vue will render the correct page once it is initiallised and has fetched all data it needs.

---

### Frontend

All of the routing heavy lifting is done by the front end. Clinet-side routing is carried out by [vue-router](https://router.vuejs.org/), with routes defined in `resources/assets/js/routes.js`.

Any asynchronous data needed in a route should be fetched in the `asyncData` hook. This is a method declared in the root of the component declaration:

```js
data: () => ({
    ...
}),

asyncData(store) {
    return cms.getPage("page").then($response => {
        store.commit("pageLoad", $response);
    });
},
```

This should either be an `async` method, or return a promise that won't resolve until all the async data has been fetched.

This method is invoked in the [beforeEach](https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards) router hook, meaning that the component won't have been instantiated yet, and `this` won't be availible. For this reason, the data itself should be stored in [vuex](https://vuex.vuejs.org/guide/). These can then be injected into the component instance using [mapState](https://vuex.vuejs.org/guide/state.html#the-mapstate-helper):

```js
computed: {
    ...mapState({
        yourNameHere: 'pageData'
    })
},
```

The boilerplate just uses the `pageData` field, but you can extend the vuex store as needed. It is defined in `resources/assets/js/store/store.js`.

> Note: The `asyncData` hook will currently only be called on components associated with a route in `routes.js`, and only when they are matched to a target route.

## Cockpit

The boilerplate is designed to integrate fully with Cockpit using a custom built PHP library that can be found at `vendor/tdcreative/cockpit-php`.

Collections for Home and Contact are currently implemented. Use these as a guide for how to pull in from Cockpit.

Access boilerplate cms at `cms.boilerplate.tdinternal.nz` to see structure of current collections.

Follow [these instructions](https://wiki.tdinternal.nz/doku.php?id=internal:server-config:cockpit) to make a new cms instance for your app. This boiler plate requires you to have the following collections from the outset:

1) Contact (Fields:  title, contact_details, published)
2) Pages (Fields: name, published, route, meta_title)
3) Home (Fields: title, published, boiler_copy)

You can of course change these fields as required once you know where they are.

---

### Backend

The Cockpit library in integrated by including 

```php
Cockpit\ServiceProvider::class
```

in the providers array of `config/app.php`. The configuration for the Cockpit integration is described in `config/cockpit.php`.

This file defines the following `.env` fields:

```bash
CMS_URI=https://cms.boilerplate.tdinternal.nz # Base URL for the Cockpit installation.
CMS_KEY=758c6e7c1c34a0359626676eb8b53d # API key for the Cockpit installation.
CMS_CACHE=true # True if the CMS should use a cache. Defaults to true if not specified.
CMS_CACHE_LENGTH=1000 # Time the cached responses should be kept in DAYS. Defaults to 1000.
```

> NOTE: If you are going to copy the above fields, remember to remove the comments.

Most importantly, this config defines the collections that the app knows about in this section:

```php
'resources' => [
    'pages'     => '/api/collections/get/pages',
    'contact'   => '/api/collections/get/contact',
    'home'      => '/api/collections/get/home',
],
```

Each key is a name for a collection that can be used when interacting with the Cockpit library, and the values are URI fragments to be appended to `CMS_URI` to fetch the resource. If you add or remove any collections from Cockpit, it is important that you update this array accordingly.

> TODO: This config file also defines a `processors` array. At time of writing I don't know what this is for...

---

The Cockpit provider can be injected into the constructor of laravel controllers etc.

```php
protected $cockpit;

public function __construct(Cockpit $cockpit)
{
    $this->cockpit = $cockpit;
}
```

This is already done in the base Controller class so all controllers have access to it by default.

```php
$this->cockpit->all();
```

returns all collections defined by the `resources` array, keyed by their name defined there. It also accepts an array of strings to exclude collections by name.

```php
$this->cockpit->get('name');
```

gets a single collection by name.

```php
$this->cockpit->refresh();
```

Clears the cache of responses and then *refetches and re-caches* all resources.

The library registers a post route `/webhooks/cockpit/collections/save` to call this method so you can add this to be called on the `collections.save.after` event in Cockpit to automatically flush the cache.

> TODO: This route currently has no authorisation defined at all, so it should probably be rewritten or retired at some point soon. 

The base controller also includes a convenience method 

```php
$this->published('name')
```

That returns the named collection, filtered to only include entries with `published: true`. If you want to use it on a new collection, make sure that you add a boolean property `published` to the collection.

---

The `PageController` appends a JSON object to the document in the variable `__state__`. This contains all of the CMS data that may be needed by the frontend to perform the initial render. The content of this object is determined by the `getCmsContent()` method and defaults to the result of `cockpit->all()` with the `pages` collection filtered to include only those with `published: true`. This method can be edited or inherited as needed. It is important that it always be kept up to date with all the data needed by the frontend (and also exluding non-public data).

Any data required by the frontend should also be availible via an endpoint. These endpoints are defined in `routes/api.php`.

---

### Frontend

The frontend uses an abstraction layer defined in `resources/assets/js/cms.js` to access the CMS. This is attached to the window, so can be accessed form anywhere:

```js
cms.getCollection("name");
```

The CMS url is declared here as well, but should point to the API endpoints that use `CmsController` so it shouldn't need to be updated. By default, it includes two methods: `getCollection` which retrieves an entire collection by its name as decleared in `cockpit.php`, and `getPage` which retrieves an item from the `pages` collection with the matching `name` field.

This layer can be extended or modified as needed, with the provision that all methods should be able to return synchronously from `__state__` on initial load.

The data retrieved from `__state__` is cleared in the [afterEach](https://router.vuejs.org/guide/advanced/navigation-guards.html#global-after-hooks) hook, meaning during initial load it can be queried by multiple components, so CMS data to control, say, nav items can be retrieved before this hook to load synchronously.

All methods that might be asynchronous should always return a promise event in the case that they resolve synchronously, as another method may try to call `then()` on the result. An easy way to be sure of this is to use `async` methods.


> NOTE: For images to be pulled from CMS, you need to add `.path` (e.g. `<img :src=“service.image.path”>` where `image` is the name of the cms field).


## Metadata

### Definition

The boilerplate allows for the dynamic resolution of metadata from the custom `metaData` option. This is declared as a function at the component level, much like `asyncData`.

```js
data: () => ({
    ...
}),

asyncData(store) {
    return cms.getPage("page").then($response => {
        store.commit("pageLoad", $response);
    });
},

metaData() {
    return {
        title: this.page.title,
        description: 'Description placeholder'
    };
}
```

Metadata should be a synchronous function returning a metadata options object. It is called from the `mounted` hook of the root component, and in the `afterEach` hook of each subsequent route, meaning that the component instance and the asyncData can be assumed to be resolved.

If a change to the metadata needs to be signaled at any other time, calling 

```js
this.$root.updateMeta();
```

Will trigger a reevaluation.

Currently the `metaData` option is only respected on the root component, and any matched route component (including those of both parent and child routes).

### Options

The metadata util provides a convenient shorthand for adding the most common meta tags. The properties `title`, `description`, and `image` can be declared in the object and will result in the approriate OpenGraph and Twitter tags being generated.

```js
metaData() {
    return {
        title: 'Page Title',
        description: 'Description placeholder',
        image: 'https://example.com/image.jpeg'
    };
}
```

Will result in 

```html
<meta name="title" content="Page Title">
<meta name="twitter:title" content="Page Title">
<meta name="description" content="Description placeholder">
<meta name="twitter:description" content="Description placeholder">
<meta name="twitter:image" content="https://example.com/image.jpeg">
<meta property="og:title" content="Page Title">
<meta property="og:description" content="Description placeholder">
<meta property="og:image" content="https://example.com/image.jpeg">
```

If no title is provided, the title field will be filled with the value of `document.title` by default. If it is provided, `dodument.title` will be set to its value.

By default, the following will also be added:

```html
<meta name="twitter:card" content="summary">
<meta property="og:type" content="website">
```

All tags created by this util will have the `data-vue-router-controlled` attribute set to track them so that they can be removed as needed. If using this attribute conflicts with any other functionality, it can be changed at the start of the `meta.js` file.

Futher OpenGraph and Twitter tags, as well as other tags with the same format, can be added using the `name` and `property` fields:

```js
metaData() {
    return {
        name: {
            key: 'value'
        },
        property: {
            key1: 'value1',
            key2: 'value2'
        }
    };
}
```
```html
<meta name="key" content="value">
<meta property="key1" content="value1">
<meta property="key2" content="value2">
```

More generic tags can be specified using the `tags` property.

```js
metaData() {
    return {
        tags: {
            key: {
                type: 'script',
                attributes: {
                    type: "text/javascript"
                },
                content: 'console.log("Hello, World");'
            }
        }
    };
}
```
```html
<script type="text/javascript">console.log("Hello, World");</script>
```

The key here is used to control inheritance, and should be something meaningful and unique.

Finally, there is the `schema` property for creating [schema.org](https://schema.org/) JSON-LD style structured data.

```js
metaData() {
    return {
        schema: {
            '@type': 'Article',
            author: 'T&D Creative',
            name: 'Boilerplate README'
        }
    };
}
```
```html
<script type="application/ld+json">{
  "@context": "https://schema.org/",
  "@type": "Article",
  "author": "T&D Creative",
  "name": "Boilerplate README"
}</script>
```

If you are using structured data, be sure to check out Google's [Understanding structured data](https://developers.google.com/search/docs/guides/intro-structured-data), [Structured data guidelines](https://developers.google.com/search/docs/guides/sd-policies)

> TODO: guide form publishing. For now, see the [wiki go-live checklist](https://wiki.tdinternal.nz/doku.php?id=web:processes:go-live)

> TODO: styling guide including scss post processors

> TODO SSR config