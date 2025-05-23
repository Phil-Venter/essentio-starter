<?php

namespace Action;

use Essentio\Core\HttpException;
use Essentio\Core\Response;

class Home
{
    public static function view(): Response
    {
        return view(base("template/home.tmpl.php"));
    }

    public static function nameAction(): Response
    {
        $rules = [
            "name" => [
                cast()->string(true),
                validate()->minLength(3, "Name must be more than 3 characters long."),
                validate()->alpha("Name should only contain letters."),
            ],
        ];

        $data = sanitize($rules, function ($errors) {
            $body = render(base("template/errors.tmpl.php"), compact("errors"));
            throw HttpException::new(400, $body);
        });

        return redirect(sprintf("/%s", $data["name"]));
    }

    public static function nameView(): Response
    {
        return view(base("template/home.tmpl.php"), ["name" => request()->get("name")]);
    }
}
