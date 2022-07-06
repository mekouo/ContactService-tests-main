<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;

require __DIR__.'/../../src/ContactService.php';

/**
 * * @covers invalidInputException
 * @covers \ContactService
 *
 * @internal
 */
final class ContactServiceIntegrationTest extends TestCase
{

    
    private $contactService;

    public function __construct(string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->contact = new ContactService();
    }

    public function testInit()
    {
        // $this->createDB();
        $this->contact = new ContactService();
        static::assertTrue($this->contact->init('contactsTest.sqlite'));
    }

    // test de suppression de toute les données, nécessaire pour nettoyer la bdd de tests à la fin
    public function testDeleteAll()
    {
        $this->Init('contactsTest.sqlite');
        static::assertTrue($this->contact->createContact('testNom', 'testPrenom'));
        static::assertTrue($this->contact->createContact('testNom2', 'testPrenom2'));

        $this->contact->deleteAllContact();
        // on vérifie que la suppression de tous les contacts a fonctionné
        
        static::assertSame(0, count($this->contact->getAllContacts()));
    }

    public function Init()
    {
        // $this->createDB();
        $this->contact = new ContactService();
        $this->contact->init('contactsTest.sqlite');
    }


    public function testCreationContact()
    {
        $this->Init('contactsTest.sqlite');
        static::assertTrue($this->contact->createContact('testNom', 'testPrenom'));
        $data = $this->contact->getAllContacts();
        // echo "Creation contact :";
        // echo var_dump($data);
        static::assertSame('testNom', $data[0]['nom']);
        static::assertSame('testPrenom', $data[0]['prenom']);
        $this->id = $data[0]['id'];
    }

    public function testSearchContact()
    {
        $this->Init('contactsTest.sqlite');
        $this->testCreationContact();
        static::assertSame(1, count($this->contact->searchContact('testNom')));
    }

    public function testModifyContact()
    {
        $this->Init('contactsTest.sqlite');
        $this->testCreationContact();
        static::assertTrue($this->contact->updateContact($this->id, 'testUpNom', 'testUpNom'));
        $data = $this->contact->getContact($this->id);
        // echo "modify contact : ";
        // echo var_dump($data);
        static::assertSame('testUpNom', $data['nom']);
        static::assertSame('testUpNom', $data['prenom']);
    }

    public function testDeleteContact()
    {
        $this->Init('contactsTest.sqlite');
        $this->contact->deleteContact(0);
        static::assertSame(0, count($this->contact->getAllContacts()));
    }

}
