<?php

namespace Rey\Easy;

use Rey\Easy\Lib\RawSql;

/**
 * Adds methods to create, modift tables easily
 */
trait EasyMigration
{
  public function id()
  {
    $this->db->disableForeignKeyChecks();
    $this->forge->addField('id');
  }

  public function nanoid()
  {
    $this->string('nanoid', false);
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
        'constraint' => 190,
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

  public function intWithFK(string $fieldName, bool $nullable = false, string $foreignField, string $foreignTable)
  {
    $this->int($fieldName, $nullable);
    $this->forge->addForeignKey($fieldName, $foreignTable,  $foreignField);
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

  public function datetime(string $fieldName, bool $nullable = false, array $options = [])
  {
    $this->forge->addField([
      $fieldName => array_merge([
        'type' => 'DATETIME',
        'null' => $nullable,
      ], $options)
    ]);
  }
  public function createTable()
  {
    $this->forge->createTable($this->tableName);
  }

  public function dropTable()
  {
    $this->forge->dropTable($this->tableName);
  }
}
