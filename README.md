# api
REST api for squarezone.pl

## Requirements

* Vagrant
* vagrant-host-manager plugin

## Setup

Boot Vagrant machine login and go to the project directory:

```
vagrant up
vagrant ssh
cd /vagrant
```

Install the dependencies:
```
composer install
```

Application is now available under ```http://squarezone-api.local```

## API

http://api.squarezone.pl/web


## Endpoints

	GET /api/v1/news - list of news
	GET /api/v1/news?year=2015 - list of news for specific year
	GET /api/v1/news?year=2015&month=11 - list of news for specific year and month
	GET /api/v1/news/:year/:month/:day/:slug - single news for specific date and slug

	GET /api/v1/articles-categories - list of articles categories
	GET /api/v1/stories-categories - list of stories categories
	GET /api/v1/galleries-categories - list of galleries categories

	GET /api/v1/articles - list of articles
	GET /api/v1/articles/:category/:article - single article for specific category
	GET /api/v1/articles/:category/:article/comments - list of comments for specifc article in category
	GET /api/v1/articles/:category/:article/comments/:comment - single comment for specific article in category
	categories/:category/articles
	articles/:article/comments

	GET /api/v1/users - list of users
	GET /api/v1/users/:user - single user
	GET /api/v1/users/:user/comments - list of comments for specific user

	GET /api/v1/cups - list of cups
	GET /api/v1/cups/:slug - single cup
	GET /api/v1/cups/:slug/battles - list of battles for specific cup
	GET /api/v1/cups/:slug/players - list of players for specific cup 
	GET /api/v1/cups/:slug/groups - current ranking in group for specific cup
	POST /api/v1/cups/:slug/battles/:date/vote/:player - vote for player in battle in specific date for specific cup

## 
