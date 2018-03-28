<?php

use Dockent\enums\TableName;
use Phalcon\Db\Column;
use Vados\MigrationRunner\migration\Migration;

class m1522261807_notifications extends Migration
{
    public function up(): bool
    {
        return $this->getDbConnection()->createTable(TableName::NOTIFICATIONS, null, [
            'columns' => [
                new Column('id', [
                    'type' => Column::TYPE_INTEGER,
                    'primary' => true
                ]),
                new Column('text', [
                    'type' => Column::TYPE_TEXT,
                    'notNull' => true
                ]),
                new Column('viewed', [
                    'type' => Column::TYPE_BOOLEAN,
                    'default' => false
                ]),
                new Column('status', [
                    'type' => Column::TYPE_INTEGER,
                    'notNull' => true
                ])
            ]
        ]);
    }

    public function down(): bool
    {
        return $this->getDbConnection()->dropTable(TableName::NOTIFICATIONS);
    }
}