<?php

use Faker\Factory as FakerFactory;
use yii\db\Migration;

/**
 * Class m230209_173424_faker_authors
 */
class m230209_173424_faker_authors extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = FakerFactory::create('en');
        for ($i = 0; $i < 50; $i++) {
            $model = new \app\models\Author();
            $model->name = $faker->firstName.' '.$faker->lastName;
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
        echo "m230209_173424_faker_authors cannot be reverted.\n";

        return false;
    }
    */
}
