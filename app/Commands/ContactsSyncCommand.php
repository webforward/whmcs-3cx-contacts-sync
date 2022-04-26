<?php

namespace App\Commands;

use App\Phonebook;
use DarthSoup\WhmcsApi\Client;
use http\Exception\RuntimeException;
use LaravelZero\Framework\Commands\Command;

class ContactsSyncCommand extends Command
{

    const CHUNK = 100; // Number of records to chunk, reduces ram usage but may take longer

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'contacts:sync';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Synchronize Contacts from WHMCS to 3CX';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $whmcs = new Client();
        $whmcs->authenticate(config('whmcs.identifier'), config('whmcs.secret'), Client::AUTH_API_CREDENTIALS);
        $whmcs->url(config('whmcs.url'));

        // Test Access
        $whmcs->client()->getClients();
        $this->call(ContactsWipeCommand::class);

        // Clients
        $this->task('Importing Clients', function() use ($whmcs) {
            $clients = $whmcs->client()->getClients(['limitnum' => self::CHUNK]);
            $clientsTotal = $clients['totalresults'];

            for ($clientsOffset = 0; $clientsOffset <= $clientsTotal; $clientsOffset += self::CHUNK) {
                if ($clientsOffset > 0) {
                    $clients = $whmcs->client()->getClients(['limitstart' => $clientsOffset, 'limitnum' => self::CHUNK]);
                }
                foreach ($clients['clients']['client'] as $client) {
                    $clientDetails = $whmcs->custom()->GetClientsDetails(['clientid' => $client['id']]);
                    if (!empty($clientDetails['phonenumber']))
                        Phonebook::create([
                            'firstname' => $clientDetails['firstname'] ?? '',
                            'lastname' => $clientDetails['lastname'] ?? '',
                            'company' => $clientDetails['companyname'] ?? '',
                            'pv_an5' => $clientDetails['email'] ?? '',
                            'phonenumber' => $clientDetails['phonenumber'] ?? '',
                        ]);
                    echo '.';
                }
            }
        });

        // Contacts
        $this->task('Importing Contacts', function() use ($whmcs) {
            $contacts = $whmcs->client()->getContacts(['limitnum' => self::CHUNK]);
            $contactsTotal = $contacts['totalresults'];
            for ($contactsOffset = 0; $contactsOffset <= $contactsTotal; $contactsOffset += self::CHUNK) {
                if ($contactsOffset > 0) {
                    $contacts = $whmcs->client()->getContacts(['limitstart' => $contactsOffset, 'limitnum' => self::CHUNK]);
                }

                foreach ($contacts['contacts']['contact'] as $contact) {
                    if (!empty($contact['phonenumber']))
                        Phonebook::create([
                            'firstname' => $contact['firstname'] ?? '',
                            'lastname' => $contact['lastname'] ?? '',
                            'company' => $contact['companyname'] ?? '',
                            'pv_an5' => $contact['email'] ?? '',
                            'phonenumber' => $contact['phonenumber'] ?? '',
                        ]);
                    echo '.';
                }

            }
        });

        unset($contacts, $contactsTotal);


    }

}
