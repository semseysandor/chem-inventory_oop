# Chem Inventory

## Overview

This is a chemical inventory suitable for a medium-sized company.
A very similar system is actually used in the industry.

Like any inventory, this system is designed to answer two questions:
1. **WHAT** we have
2. **WHERE** it is

Chemicals are structured in categories/subcategories. There are *compound*s,
a compound can have *batch*es and a batch can have many *pack*s.
Locationwise you can design *laboratories* (rooms), inside laboratories different
*storages* (like cabinets, cupboards, fridges, etc.) and inside storages some *sub-
storages* (e.g. shelves of a cupboard). Anyway, you can use any logic, nevertheless
there is a pre-defined 3-tier location system.

Compound, batch and pack management is through the web interface.
Locations & manufacturers are stored in the database as well as user right levels,
so you can manipulate them with a database management software or plain SQL.

Barcodes are assigned to each pack, so you can use labels for identification
in the lab. (barcode printing is not implemented yet in this application)

Adding and editing batches and packs is only allowed for admins.
Users can add/edit compounds and upload documents, whereas guests only can view
and search the database.

## Features

* Three user access levels (guest/user/admin)
* Add/edit compounds, batches and packs (Partially implemented in this edition)
* Inactivate packs when getting empty (Not implemented in this edition)
* Changelog for audit trails (Not implemented in this edition)
* Search chemicals with autocomplete (Not implemented in this edition)
* Generate barcodes (Not implemented in this edition)
* Drawing chemical structures (Not implemented in this edition)

## Technical Details
* Fully OOP
* Custom-made core framework:
    - Routing
    - Session Management
    - Controllers
    - DataBase Handling
    - Exception handling
    - Rendering
    - etc.
* Backend: PHP
* Template engine: Smarty
* jQuery
* Not all inventory feature implemented

## Installation

1. Clone or download repository
1. Set `/public` directory to be the web server document root
1. Setup a MySQL server and **import DB_structure.sql**
1. **Edit config.php** with your credentials (database)
1. (optional) Load the database with sample data (DB_sample_data.sql)

## License

[MIT license](LICENSE)

This is a free software ;)

## Contact

If you need more information feel free to contact me:

Sandor Semsey

<semseysandor@gmail.com>
