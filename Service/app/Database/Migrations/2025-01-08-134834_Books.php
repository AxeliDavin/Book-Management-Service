<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Books extends Migration
{
    public function up()
    {
        // Creating the books table
        $this->forge->addField([
            'id'                  => ['type' => 'VARCHAR', 'constraint' => 36, 'null' => false],
            'title'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'author'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'genre'               => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'isbn'                => ['type' => 'VARCHAR', 'constraint' => 13, 'null' => false],
            'published_date'      => ['type' => 'DATE', 'null' => false],
            'availability_status' => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => false, 'default' => 'Available'],
            'created_at'          => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'          => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        
        // Adding primary key
        $this->forge->addPrimaryKey('id');

        // Adding unique constraint on ISBN
        $this->forge->addUniqueKey('isbn');
        
        // Creating the table
        $this->forge->createTable('books');

        // Use raw SQL to set default values for timestamp fields
        $db = \Config\Database::connect();
        $db->query("ALTER TABLE books ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP");
        $db->query("ALTER TABLE books ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP");
    }

    public function down()
    {
        // Dropping the books table
        $this->forge->dropTable('books');
    }
}
