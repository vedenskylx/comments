<?php

use yii\db\Migration;

/**
 * Class m220511_101232_comments
 */
class m220506_101232_comments extends Migration
{
    const TABLE = 'comments';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id'         => $this->primaryKey(),
            'parent_id'  => $this->integer(),
            'content'    => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(self::TABLE . '__fk', self::TABLE, 'parent_id', self::TABLE, 'id',
            'CASCADE', 'CASCADE');
        $this->createIndex(self::TABLE . '_parent_idx', self::TABLE, 'parent_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(self::TABLE . '__fk', self::TABLE);
        $this->dropTable(self::TABLE);
    }
}
