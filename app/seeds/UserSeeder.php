<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $this->getAdapter()->beginTransaction();
        try {
        $this->getAdapter()->execute('SET FOREIGN_KEY_CHECKS = 0');
        $user_data = array(
            array(
                'username' => 'admin',
                'password' => '$2y$13$KMeDSeYnVeQSwP7JxEx04uU5NzWAMU9vTHZmrboH79HzBWoSKfEnq',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            )
        );
        $users = $this->table('user');
        $users->truncate();
        $users->insert($user_data)->save();
        } catch (PDOException $e) {
            $this->getAdapter()->execute('SET FOREIGN_KEY_CHECKS = 1');
            $this->getAdapter()->rollbackTransaction();
            throw $e;
        }
        $this->getAdapter()->execute('SET FOREIGN_KEY_CKECKS = 1');
        $this->getAdapter()->commitTransaction();
    }
}
