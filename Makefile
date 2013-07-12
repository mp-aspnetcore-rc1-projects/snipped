git:
	git add .
	git commit -am"update"
	git push github master | git push heroku master

.PHONY: git