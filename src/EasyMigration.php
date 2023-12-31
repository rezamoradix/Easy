<?php

namespace Rey\Easy;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\RawSql;

/**
 * Adds methods to create, modift tables easily
 */
trait EasyMigration
{
  public function id()
  {
    $this->db->disableForeignKeyChecks();
    $this->forge->addField([
      'id' => [
        'type' => 'int',
        'constraint' => 11,
        'unsigned' => true,
        'auto_increment' => true
      ],
    ]);
    $this->getDbForge()->addPrimaryKey('id');
  }

  public function nanoid()
  {
    $this->string('nanoid', false);
    $this->getDbForge()->addKey('nanoid');
  }

  public function timestamps()
  {
    $this->forge->addField([
      'created_at' => [
        'type'    => 'TIMESTAMP',
        'default' => new RawSql('CURRENT_TIMESTAMP'),
      ],
      'updated_at' => [
        'type'    => 'TIMESTAMP',
        'default' => new RawSql('CURRENT_TIMESTAMP'),
      ],
      'deleted_at' => [
        'type'    => 'TIMESTAMP',
        'default' => null,
      ],
    ]);
  }

  public function string(string $fieldName, bool $nullable = false)
  {
    $this->forge->addField([
      $fieldName => [
        'type' => 'varchar',
        'constraint' => 255,
        'null' => $nullable
      ]
    ]);
  }

  public function text(string $fieldName, bool $nullable = false)
  {
    $this->forge->addField([
      $fieldName => [
        'type' => 'text',
        'null' => $nullable
      ]
    ]);
  }

  public function int(string $fieldName, bool $nullable = false)
  {
    $this->forge->addField([
      $fieldName => [
        'type' => 'int',
        'null' => $nullable
      ]
    ]);
  }

  public function unsignedInt(string $fieldName, bool $nullable = false)
  {
    $this->forge->addField([
      $fieldName => [
        'type' => 'int',
        'null' => $nullable,
        'unsigned' => true,
      ]
    ]);
  }

  public function tinyint(string $fieldName, bool $nullable = false)
  {
    $this->forge->addField([
      $fieldName => [
        'type' => 'TINYINT',
        'null' => $nullable
      ]
    ]);
  }

  public function float(string $fieldName, bool $nullable = false)
  {
    $this->_addField(
      $fieldName,
      [
        'type' => 'FLOAT',
        'null' => $nullable
      ]
    );
  }

  public function double(string $fieldName, bool $nullable = false)
  {
    $this->_addField(
      $fieldName,
      [
        'type' => 'DOUBLE',
        'null' => $nullable
      ]
    );
  }

  public function intWithFK(string $fieldName, bool $nullable = false, string $foreignField, string $foreignTable, string $onUpdate = '', string $onDelete = '')
  {
    $this->unsignedInt($fieldName, $nullable);
    $this->getDbForge()->addForeignKey($fieldName, $foreignTable, $foreignField, $onUpdate, $onDelete);
  }

  public function userId(bool $nullable = false)
  {
    $this->intWithFK('user_id', $nullable, 'id', 'users');
  }

  public function createdBy(bool $nullable = false)
  {
    $this->intWithFK('created_by', $nullable, 'id', 'users');
  }

  public function bool(string $fieldName, bool $nullable = false, bool $defaultValue = false)
  {
    $this->forge->addField([
      $fieldName => [
        'type' => 'TINYINT',
        'null' => $nullable,
        'default' => $defaultValue
      ]
    ]);
  }

  // Alias
  public function boolean(string $fieldName, bool $nullable = false, bool $defaultValue = false)
  {
    return $this->bool($fieldName, $nullable, $defaultValue);
  }

  public function datetime(string $fieldName, bool $nullable = false, array $options = [])
  {
    $this->forge->addField([
      $fieldName => array_merge([
        'type' => 'DATETIME',
        'null' => $nullable,
      ], $options)
    ]);
  }


  public function modifyAddField(string $tableName, array $field)
  {
    $this->getDbForge()->addColumn($tableName, $field);
  }

  public function modifyEditField(string $tableName, array $field)
  {
    $this->getDbForge()->modifyColumn($tableName, $field);
  }

  public function modifyDropField(string $tableName, string $fieldName)
  {
    $this->getDbForge()->dropColumn($tableName, $fieldName);
  }


  public function getDbForge(): Forge
  {
    return $this->forge;
  }

  public function createTable()
  {
    $this->forge->createTable($this->tableName);
  }

  public function dropTable()
  {
    $this->forge->dropTable($this->tableName);
  }

  // Private methods
  private function _addField($fieldName, $attributes)
  {
    $this->forge->addField([
      $fieldName => $attributes
    ]);
  }
}
