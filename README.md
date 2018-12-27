# Api Responses [![Build Status](https://travis-ci.org/mahmoud-birdsol/laravel-api-responses.svg?branch=master)](https://travis-ci.org/mahmoud-birdsol/laravel-api-responses)

This package is a response helper classes for laravel api developers to use with transformers the package we use for transformers is [spatie/laravel-fractal](https://github.com/spatie/laravel-fractal) you will find some helper classes in this package for all rest api end points but the try value is in the Index response.

- Index Response
- Show Response


- Updated Response
- Deleted Response
- Created Response


### Installation
```$xslt
composer require mahmoud-birdsol/api-responses
```
**Config**
Paginator adapter can be configured, as well as the paginate request key.

```$xslt
/**
 * Pagination config variables.
 */
'pagination_adapter' 	 	  => \League\Fractal\Pagination\IlluminatePaginatorAdapter::class,
'pagination_request_key' 	  => 'paginate',
```

### Usage

**Index Response**

To return an index response from your controller you can just return a new instance of the class and pass through an eloquent model query builder and transformer.
It's specifically designed that way so you can add any default queries you need to run on the model for example an authorization restriction scope that needs to exist on the model query level or a multi-tenant application in the same db you would filter the class from the backend.

```$xslt
return new IndexResponse(User::query(), new UserTransformer());
```

**Front end usage**
You can use request params to manipulate this response through some ready made functions.

- **Pagination** you can send a paginate=10 to get a paginated response from the api.
- **Filters** you can use eloquent scopes to filter for example filter by user id and you have a scope method on your model `public function scopeUser($query, $userId)` you can easily use this from your frontend by sending a request with `user={id}`.
- **Sorting** You can sort response data also from your frontend by just passing through `latest=true` or `sortAsc=email` or `sortDesc=id` and just sort using any attribute you would like to use.

**Show Response**

A show response is just a simple class that will transform your data using fractal and return it to the user.

```$xslt
return new ShowResponse($model, new ModelTransformer());
```

**Updated Response**

The updated response is very similar to the show response except that will refresh the updated model behind the scene so you can do something like this in your controller method easily.

```$xslt
public function update($request, User $user)
{
    $user->update($request->all());
    
    return new UpdatedResponse($user, new UserTransformer());
}
```

### License
The MIT License (MIT). Please see [License File](https://github.com/spatie/laravel-fractal/blob/master/LICENSE.md) for more information.

 
