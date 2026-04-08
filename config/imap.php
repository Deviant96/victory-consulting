<?php

return [
    'date_format' => 'd-M-Y',
    'default' => 'titan',
    'accounts' => [
        'titan' => [
            'host'           => env('TITAN_IMAP_HOST', 'imap.titan.email'),
            'port'           => env('TITAN_IMAP_PORT', 993),
            'protocol'       => 'imap',
            'encryption'     => env('TITAN_IMAP_ENCRYPTION', 'ssl'),
            'validate_cert'  => true,
            'username'       => env('TITAN_IMAP_USERNAME', ''),
            'password'       => env('TITAN_IMAP_PASSWORD', ''),
            'authentication' => null,
            'proxy' => [
                'socket'          => null,
                'request_fulluri' => false,
                'username'        => null,
                'password'        => null,
            ],
            'timeout'    => 30,
            'extensions' => [],
        ],
    ],
    'options' => [
        'delimiter'   => '/',
        'fetch'       => \Webklex\PHPIMAP\IMAP::FT_PEEK,
        'sequence'    => \Webklex\PHPIMAP\IMAP::ST_UID,
        'fetch_body'  => true,
        'fetch_flags' => true,
        'soft_fail'   => true,
        'rfc822'      => true,
        'debug'       => false,
        'uid_cache'   => true,
        'boundary'    => '/boundary=(.*?(?=;)|(.*))/i',
        'message_key' => 'list',
        'fetch_order' => 'desc',
        'dispositions' => ['attachment', 'inline'],
        'common_folders' => [
            'root'  => 'INBOX',
            'junk'  => 'INBOX/Junk',
            'draft' => env('TITAN_DRAFTS_FOLDER', 'Drafts'),
            'sent'  => env('TITAN_SENT_FOLDER', 'Sent'),
            'trash' => 'Trash',
        ],
        'decoder' => [
            'message'    => 'utf-8',
            'attachment' => 'utf-8',
        ],
        'open' => [],
    ],
    'flags'  => ['recent', 'flagged', 'answered', 'deleted', 'seen', 'draft'],
    'events' => [
        'message' => [
            'new'      => \Webklex\PHPIMAP\Events\MessageNewEvent::class,
            'moved'    => \Webklex\PHPIMAP\Events\MessageMovedEvent::class,
            'copied'   => \Webklex\PHPIMAP\Events\MessageCopiedEvent::class,
            'deleted'  => \Webklex\PHPIMAP\Events\MessageDeletedEvent::class,
            'restored' => \Webklex\PHPIMAP\Events\MessageRestoredEvent::class,
        ],
        'folder' => [
            'new'    => \Webklex\PHPIMAP\Events\FolderNewEvent::class,
            'moved'  => \Webklex\PHPIMAP\Events\FolderMovedEvent::class,
            'deleted' => \Webklex\PHPIMAP\Events\FolderDeletedEvent::class,
        ],
    ],
    'masking' => [
        'message'    => \Webklex\PHPIMAP\Support\Masks\MessageMask::class,
        'attachment' => \Webklex\PHPIMAP\Support\Masks\AttachmentMask::class,
    ],
    'webmail_url' => env('TITAN_WEBMAIL_URL', 'https://mail.titan.email'),
];
