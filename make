lando php ./docs/openapi-create.php > ./docs/specs/openapi.yaml

lando npm i --prefix docs && lando npm run doc-build --prefix docs

git clone git@bitbucket.org:openwebconcept/openwebconcept.bitbucket.org.git
cd openwebconcept.bitbucket.org
cp ../docs/index.html ./openwoo/index.html && git add . && git commit -m"(chore): update documentation" && git push
