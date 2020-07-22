<?php

namespace LiveStream\Resources;

/**
 * Account Object
 * 
 * @property int $id The integer representation of the unique identifier for this account.
 * @property string $description Nullable. The user-defined account description as a UTF-8 string.
 * @property string $email The registered email ID with the account.
 * @property string $timezone The timezone identifier string.
 * @property \LiveStream\Resources\Picture $picture An object containing the urls of the account owner’s pictures.
 * @property object $follower An object containing a single property, total, which indicates the number of accounts who are following this account.
 * @property object $following An object containing a single property, total, which indicates the number of accounts being followed by this account.
 * @property string $fullName The user-defined full name for the account as a UTF-8 string.
 * @property string $shortName Nullable. The user-defined short name of the account as a UTF-8 string consisting only of letters and numbers.
 * @property string $createdAt Account creation date and time as a string in ISO 8601 date time format.
 * @property object $draftEvents An object containing a single property, total, which indicates the number of draft events this account has created.
 * @property object $privateEvents An object containing a single property, total, which indicates the number of private events this account has created.
 * @property object $upcomingEvents An object containing a single property, total, which indicates the number of upcoming events for this account.
 * @property object $pastEvents An object containing a single property, total, which indicates the number of past events for this account.
 */
class Account extends Resource
{
    public static function fromObject(object $object): Resource
    {
        $instance = parent::fromObject($object);

        $instance->picture = Picture::fromObject($instance->picture);

        return $instance;
    }
}
