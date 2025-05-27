<?php

namespace App\Enum;

enum PostStatus :int
{

    case  DRAFT = 0;
    case PUBLISHED = 1;
    case ARCHIVED = 2;
    case REJECTED = 3;


    public static function all() :array
    {
        return [
            self::DRAFT->value => 'Draft',
            self::PUBLISHED->value => 'Published',
            self::ARCHIVED->value => 'Archived',
            self::REJECTED->value => 'Rejected',
        ];
    }

    public static function find(int $status) :string
    {
        return match ($status) {
            self::DRAFT->value => 'Draft',
            self::PUBLISHED->value => 'Published',
            self::ARCHIVED->value => 'Archived',
            self::REJECTED->value => 'Rejected',
            default => 'Unknown',
        };
    }

    public static function color(int $status)
    {
        return match ($status) {
            self::DRAFT->value => 'red',
            self::PUBLISHED->value => 'green',
            self::ARCHIVED->value => 'blue',
            self::REJECTED->value => 'red',
            default => 'gray',
        };
    }

}
