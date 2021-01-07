#!/bin/bash

git_name=`git config user.name`;
git_email=`git config user.email`;

read -p "Author name ($git_name): " author_name
author_name=${author_name:-$git_name}

read -p "Author email ($git_email): " author_email
author_email=${author_email:-$git_email}

username_guess=${author_name//[[:blank:]]/}
read -p "Author username ($username_guess): " author_username
author_username=${author_username:-$username_guess}

current_directory=`pwd`
current_directory=`basename $current_directory`
read -p "Package name ($current_directory): " package_name
package_name=${package_name:-$current_directory}
package_name_php=$(echo $package_name | sed -E 's/[^a-z]+([a-z])/\U\1/gi;s/^([A-Z])/\l\1/')

read -p "Package description: " package_description

echo
echo -e "Author: $author_name ($author_username, $author_email)"
echo -e "Package: $package_name <${package_name_php^}>"

echo
echo "This script will replace the above values in all files in the project directory and reset the git repository."
read -p "Are you sure you wish to continue? (n/y) " -n 1 -r

echo
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    [[ "$0" = "$BASH_SOURCE" ]] && exit 1 || return 1
fi

echo

echo "Scaffolding package"

find . -type f -not -path "./.git/*" -not -path "./vendor/*" -not -path "./setup.sh" -exec sed -i -e "s/:author_name/$author_name/g" {} \;
find . -type f -not -path "./.git/*" -not -path "./vendor/*" -not -path "./setup.sh" -exec sed -i -e "s/:author_username/$author_username/g" {} \;
find . -type f -not -path "./.git/*" -not -path "./vendor/*" -not -path "./setup.sh" -exec sed -i -e "s/:author_email/$author_email/g" {} \;
find . -type f -not -path "./.git/*" -not -path "./vendor/*" -not -path "./setup.sh" -exec sed -i -e "s/:package_name_php/${package_name_php^}/g" {} \;
find . -type f -not -path "./.git/*" -not -path "./vendor/*" -not -path "./setup.sh" -exec sed -i -e "s/:package_name/$package_name/g" {} \;
find . -type f -not -path "./.git/*" -not -path "./vendor/*" -not -path "./setup.sh" -exec sed -i -e "s/:package_description/$package_description/g" {} \;

sed -i -e "/^\*\*Note:\*\* Replace/d" README.md

echo "Renaming files"

mv "./routes/package.php" "./routes/$package_name_php.php"
mv "./src/Package.php" "./src/${package_name_php^}.php"
mv "./src/PackageFacade.php" "./src/${package_name_php^}Facade.php"
mv "./src/PackageServiceProvider.php" "./src/${package_name_php^}ServiceProvider.php"

if [[ -d "vendor" ]]
then
    echo "Composer dependencies already installed. Dumping autoload"
    composer dump-autoload
else
    echo "Composer dependencies not installed. Installing them"
    composer install
fi

if [ "$current_directory" != "package-starter" ]
then
    rm -- "$0"

    git add .
    git commit -m ":sparkles: Configure Package";
    git pull
    git push

    echo "Replaced all values and commited, self destructing in 3... 2... 1..."
else
    echo "Replaced all values"
fi

echo
printf "\033[0;32mBuild something awesome!"
