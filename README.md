# api
REST api for squarezone.pl

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

## 