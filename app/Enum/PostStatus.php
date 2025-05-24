<?php

namespace App\Enum;

enum PostStatus :int
{

    case  DRAFT = 0;
    case PUBLISHED = 1;
    case ARCHIVED = 2;


    public static function all() :array
    {
        return [
            self::DRAFT->value => 'Draft',
            self::PUBLISHED->value => 'Published',
            self::ARCHIVED->value => 'Archived',
        ];
    }

    public static function find(int $status) :string
    {
        return match ($status) {
            self::DRAFT->value => 'Draft',
            self::PUBLISHED->value => 'Published',
            self::ARCHIVED->value => 'Archived',
            default => 'Unknown',
        };
    }

    public static function color(int $status)
    {
        return match ($status) {
            self::DRAFT->value => 'red',
            self::PUBLISHED->value => 'green',
            self::ARCHIVED->value => 'blue',
            default => 'gray',
        };
    }

}
