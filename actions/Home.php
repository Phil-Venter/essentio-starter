<?php

namespace Action;

use Essentio\Core\Extra\Cast;
use Essentio\Core\Extra\Validate;
use Essentio\Core\HttpException;
use Essentio\Core\Response;

class Home
{
    public static function view(): Response
    {
        return view(base_path("template/home.tmpl.php"));
    }

    public static function nameAction(): Response
    {
        $rules = [
            "name" => [
                Cast::string(true),
                Validate::minLength(3, "Name must be more than 3 characters long."),
                Validate::alpha("Name should only contain letters."),
            ],
        ];

        $data = sanitize($rules, function ($errors) {
            $body = render(base_path("template/errors.tmpl.php"), compact("errors"));
            throw HttpException::create(400, $body);
        });

        return redirect(sprintf("/%s", $data["name"]));
    }

    public static function nameView(): Response
    {
        return view(base_path("template/home.tmpl.php"), ["name" => request("name")]);
    }
}
