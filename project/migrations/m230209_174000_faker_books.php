<?php

use Faker\Factory as FakerFactory;
use yii\db\Migration;

/**
 * Class m230209_174000_faker_books
 */
class m230209_174000_faker_books extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = FakerFactory::create('en');
        for ($i = 0; $i < 50; $i++) {
            $model = new \app\models\Book();
            $model->name = $faker->company;
            $model->year = mt_rand(2021, date('Y'));
            $model->authors = [mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50), mt_rand(1, 50)];
            $model->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230209_174000_faker_books cannot be reverted.\n";

        return false;
    }
    */
}
