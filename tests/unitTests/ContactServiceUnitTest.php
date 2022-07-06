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

require __DIR__ . '/../../src/ContactService.php';

/**
 * * @covers invalidInputException
 * @covers \ContactService
 *
 * @internal
 */
final class ContactServiceUnitTest extends TestCase {
    private $contactService;

    public function __construct(string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->contactService = new ContactService();
    }

    public function testCreationContactWithoutAnyText() {
        $contact = new contacts();
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage('renseignez le nom et le prenom svp');
        $contact->createContact('', '');
    }

    public function testCreationContactWithoutPrenom() {
        $contact = new contacts();
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage('renseignez le nom et le prenom svp');
        $contact->createContact('nom', '');
    }

    public function testCreationContactWithoutNom() {
        $contact = new contacts();
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage('renseignez le nom et le prenom svp');
        $contact->createContact('', 'prenom');
    }

    public function testSearchContactWithNumber() {
        $contact = new contacts();
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage('Veuillez spécifier une recherche');
        $contact->searchContact(0);
    }

    public function testModifyContactWithInvalidId() {
        $contact = new contacts();
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");
        static::assertTrue($contact->updateContact(-456, 'ff', 'ff'));
    }

    public function testDeleteContactWithTextAsId() {
        $contact = new contacts();
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");
        $contact->deleteContact('efdofod');
    }
}
