

## About Cloud app

For running app:
1. docker-compose build
2. docker-compose up


#  WebApp


### Installing


`docker exec <container-name> composer webcloud:install:prod`

or

`composer webcloud:install:prod`

```
	Edit .env
	-----------
	APP_ENV=production
	APP_DEBUG=false

```


## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
