<?php


namespace CoralMedia\Component\Resource\Model;


interface StatusInterface
{
    const STATUS_DRAFT = 0;
    const STATUS_NEW = 1;
    const STATUS_OPEN = 2;
    const STATUS_SUBMITTED = 3;
    const STATUS_ACCEPTED = 4;
    const STATUS_PENDING = 5;
    const STATUS_COMPLETED = 6;
    const STATUS_CLOSED = 7;
    const STATUS_REJECTED = 8;
    const STATUS_CANCELLED = 9;
}