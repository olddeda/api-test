<?php

namespace app\enum;

enum UserStatus: int
{
    case DELETED    = 0;
    case ACTIVE     = 10;
}