<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Webklex\PHPIMAP\Exceptions\AuthFailedException;
use Exception;

class EmailController extends Controller
{
    private function getClient(): \Webklex\PHPIMAP\Client
    {
        $cm = new ClientManager(config('imap'));
        $client = $cm->account('titan');
        $client->connect();
        return $client;
    }

    public function inbox(Request $request)
    {
        $messages = collect();
        $error = null;
        $titanUrl = env('TITAN_WEBMAIL_URL', 'https://mail.titan.email');
        $page = max(1, (int) $request->query('page', 1));
        $perPage = 20;
        $total = 0;

        try {
            $client = $this->getClient();
            $folder = $client->getFolder('INBOX');
            $allMessages = $folder->messages()->all()->setFetchOrder('desc')->get();
            $total = $allMessages->count();
            $messages = $allMessages->forPage($page, $perPage);
            $client->disconnect();
        } catch (ConnectionFailedException | AuthFailedException $e) {
            $error = 'Could not connect to the email server. Please check your IMAP credentials in the .env file.';
        } catch (Exception $e) {
            $error = 'Email error: ' . $e->getMessage();
        }

        return view('admin.email.inbox', compact('messages', 'error', 'titanUrl', 'page', 'perPage', 'total'));
    }

    public function sent(Request $request)
    {
        $messages = collect();
        $error = null;
        $titanUrl = env('TITAN_WEBMAIL_URL', 'https://mail.titan.email');
        $page = max(1, (int) $request->query('page', 1));
        $perPage = 20;
        $total = 0;

        try {
            $client = $this->getClient();
            $sentFolder = config('imap.options.common_folders.sent', 'Sent');
            $folder = $client->getFolder($sentFolder);
            $allMessages = $folder->messages()->all()->setFetchOrder('desc')->get();
            $total = $allMessages->count();
            $messages = $allMessages->forPage($page, $perPage);
            $client->disconnect();
        } catch (ConnectionFailedException | AuthFailedException $e) {
            $error = 'Could not connect to the email server. Please check your IMAP credentials in the .env file.';
        } catch (Exception $e) {
            $error = 'Email error: ' . $e->getMessage();
        }

        return view('admin.email.sent', compact('messages', 'error', 'titanUrl', 'page', 'perPage', 'total'));
    }

    public function drafts(Request $request)
    {
        $messages = collect();
        $error = null;
        $titanUrl = env('TITAN_WEBMAIL_URL', 'https://mail.titan.email');
        $page = max(1, (int) $request->query('page', 1));
        $perPage = 20;
        $total = 0;

        try {
            $client = $this->getClient();
            $draftsFolder = config('imap.options.common_folders.draft', 'Drafts');
            $folder = $client->getFolder($draftsFolder);
            $allMessages = $folder->messages()->all()->setFetchOrder('desc')->get();
            $total = $allMessages->count();
            $messages = $allMessages->forPage($page, $perPage);
            $client->disconnect();
        } catch (ConnectionFailedException | AuthFailedException $e) {
            $error = 'Could not connect to the email server. Please check your IMAP credentials in the .env file.';
        } catch (Exception $e) {
            $error = 'Email error: ' . $e->getMessage();
        }

        return view('admin.email.drafts', compact('messages', 'error', 'titanUrl', 'page', 'perPage', 'total'));
    }

    public function show(int $uid, string $folder)
    {
        $message = null;
        $error = null;
        $titanUrl = env('TITAN_WEBMAIL_URL', 'https://mail.titan.email');
        $folderName = match($folder) {
            'sent'   => config('imap.options.common_folders.sent', 'Sent'),
            'drafts' => config('imap.options.common_folders.draft', 'Drafts'),
            default  => 'INBOX',
        };

        try {
            $client = $this->getClient();
            $imapFolder = $client->getFolder($folderName);
            $message = $imapFolder->messages()->getMessageByUid($uid);
            $client->disconnect();
        } catch (ConnectionFailedException | AuthFailedException $e) {
            $error = 'Could not connect to the email server. Please check your IMAP credentials in the .env file.';
        } catch (Exception $e) {
            $error = 'Could not load the message: ' . $e->getMessage();
        }

        return view('admin.email.show', compact('message', 'error', 'titanUrl', 'folder'));
    }
}
