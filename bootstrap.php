<?php

# CONTAINER

use Essentio\Core\Extra\Query;
use Essentio\Core\HttpException;
use Essentio\Core\Request;

once(PDO::class, fn() => new PDO("sqlite:" . base_path("database.sqlite")));
bind(Query::class, fn() => new Query(app(PDO::class)));

# ERROR LOGGING MIDDLEWARE
middleware(function (Request $req, $next) {
    try {
        return $next($req);
    } catch (Throwable $e) {
        error_log("[{$req->method}] /{$req->path} - {$e->getMessage()} {$e->getFile()}:{$e->getLine()}");
        throw $e;
    }
});

# CSRF MIDDLEWARE
middleware(function (Request $req, $next) {
    if (
        $req->contentType !== "application/json" &&
        in_array($req->method, ["POST", "PUT", "PATCH", "DELETE"]) &&
        !csrf(input("_csrf") ?? ($req->headers["X-CSRF-TOKEN"] ?? ""))
    ) {
        throw HttpException::create(403, "CSRF token mismatch");
    }

    return $next($req);
});

# JWT MIDDLEWARE ON api/
middleware(function (Request $req, $next) {
    if ($req->contentType === "application/json" && str_starts_with($req->path, "api/")) {
        try {
            jwt(trim(str_replace("Bearer ", "", $req->headers["Authorization"] ?? "")));
        } catch (Throwable) {
            throw HttpException::create(401, "Unauthorized");
        }

        return app(Response::class)->addHeaders(["Content-Type" => "application/json"]);
    }

    return $next($req);
});

# SECURITY HEADERS
middleware(function (Request $req, $next) {
    return $next($req)->addHeaders([
        "X-Content-Type-Options" => "nosniff",
        "X-Frame-Options" => "DENY",
        "X-XSS-Protection" => "1; mode=block",
        "Referrer-Policy" => "strict-origin-when-cross-origin",
        "Content-Security-Policy" => "default-src 'self'; object-src 'none'; frame-ancestors 'none';",
    ]);
});
