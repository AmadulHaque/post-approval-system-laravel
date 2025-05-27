<?php

use App\Jobs\ArchiveUnreviewedPosts;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('archive:unreviewed', function () {
    (new ArchiveUnreviewedPosts())->handle();
})->purpose('Archive unreviewed posts');
