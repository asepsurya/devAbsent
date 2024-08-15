<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
  <div class="p-6 text-gray-900">
        {{ __("You're logged in!") }}
    </div>
    @can('menu')
       INI ADALAH MENU 
    @endcan
    @can('create student')
    You can CREATE ARTICLES.
    @endcan
    @can('update student')
    You can EDIT ARTICLES.
    <button>edit</button>
    @endcan
    @can('delete student')
    You can Delete ARTICLES.
    @endcan
    @can('read student')
    You can Read ARTICLES.
    @endcan
    @can('only super-admins can see this section')
    Congratulations, you are a super-admin!
    @endcan
</body>
</html>