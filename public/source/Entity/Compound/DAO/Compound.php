<?php
/**
 +-----------------------------------------------+
 | This file is part of chem-inventory.          |
 |                                               |
 | Copyright 2020 Sandor Semsey                  |
 | All rights reserved.                          |
 |                                               |
 | This work is published under the MIT License. |
 | https://choosealicense.com/licenses/mit/      |
 +-----------------------------------------------+
 */

namespace Inventory\Entity\Compound\DAO;

use Inventory\Core\DataBase\SQLDaO;

/**
 * Compound entity DataObject
 *
 * @category DataBase
 * @package  chem-inventory_oop
 * @author   Sandor Semsey <semseysandor@gmail.com>
 * @license  MIT https://choosealicense.com/licenses/mit/
 * php version 7.4
 */
class Compound extends SQLDaO
{
    /**
     * Compound ID
     *
     * @var int|null
     */
    public ?int $id;

    /**
     * Compound name
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * Compound alternative name
     *
     * @var string|null
     */
    public ?string $nameAlt;

    /**
     * Abbreviation
     *
     * @var string|null
     */
    public ?string $abbrev;

    /**
     * Chemical name
     *
     * @var string|null
     */
    public ?string $chemName;

    /**
     * IUPAC name
     *
     * @var string|null
     */
    public ?string $iupacName;

    /**
     * Chemical formula
     *
     * @var string|null
     */
    public ?string $chemFormula;

    /**
     * CAS number
     *
     * @var string|null
     */
    public ?string $cas;

    /**
     * SMILES
     *
     * @var string|null
     */
    public ?string $smiles;

    /**
     * Subcategory ID
     *
     * @var int|null
     */
    public ?int $subCategory;

    /**
     * OEB level
     *
     * @var int|null
     */
    public ?int $oeb;

    /**
     * Molar weight
     *
     * @var float|null
     */
    public ?float $molWeight;

    /**
     * Melting point
     *
     * @var string|null
     */
    public ?string $meltPoint;

    /**
     * Note
     *
     * @var string|null
     */
    public ?string $note;

    /**
     * Last modification by
     *
     * @var string|null
     */
    public ?string $lastModBy;

    /**
     * Last modification time
     *
     * @var string|null
     */
    public ?string $lastModTime;

    /**
     * Table name
     *
     * @var string
     */
    protected string $tableName = "leltar_compound";

    /**
     * Compound constructor.
     *
     * @throws \Inventory\Core\Exception\BadArgument
     */
    public function __construct()
    {
        parent::__construct();

        // Init fields
        $this->id = null;
        $this->name = null;
        $this->nameAlt = null;
        $this->abbrev = null;
        $this->chemName = null;
        $this->iupacName = null;
        $this->chemFormula = null;
        $this->cas = null;
        $this->smiles = null;
        $this->subCategory = null;
        $this->oeb = null;
        $this->molWeight = null;
        $this->meltPoint = null;
        $this->lastModBy = null;
        $this->lastModTime = null;

        // Add metadata
        $this->addMetadata('id', 'i', 'compound_id', 'Compound ID', true);
        $this->addMetadata('name', 's', 'name', 'Compound Name', true);
        $this->addMetadata('nameAlt', 's', 'name_alt', 'Compound Alternative Name');
        $this->addMetadata('abbrev', 's', 'abbrev', 'Abbreviation');
        $this->addMetadata('chemName', 's', 'chemical_name', 'Chemical Name');
        $this->addMetadata('iupacName', 's', 'iupac_name', 'IUPAC Name');
        $this->addMetadata('chemFormula', 's', 'chem_formula', 'Chemical Formula');
        $this->addMetadata('cas', 's', 'cas', 'CAS number');
        $this->addMetadata('smiles', 's', 'smiles', 'SMILES');
        $this->addMetadata('subCategory', 'i', 'sub_category_id', 'Sub Category ID', true);
        $this->addMetadata('oeb', 'i', 'oeb', 'OEB level');
        $this->addMetadata('molWeight', 'd', 'mol_weight', 'Molar Weight');
        $this->addMetadata('meltPoint', 's', 'melting_point', 'Melting Point');
        $this->addMetadata('note', 's', 'note', 'Note');
        $this->addMetadata('lastModBy', 's', 'last_mod_by', 'Last Modification By');
        $this->addMetadata('lastModTime', 's', 'last_mod_time', 'Last Modification Time');
    }
}
