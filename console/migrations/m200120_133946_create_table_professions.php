<?php

use ruskid\csvimporter\CSVImporter;
use ruskid\csvimporter\CSVReader;
use ruskid\csvimporter\MultipleImportStrategy;
use yii\db\Migration;

/**
 * Class m200120_133946_create_table_professions
 */
class m200120_133946_create_table_professions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('professions', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'slug' => $this->string(255),
            'genitive' => $this->string(255),
            'instrumental' => $this->string(255),
        ]);

        //Импортируем профессии
        $handle = fopen(Yii::getAlias('@frontend/web') . '/csv/prof.csv', "r");
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            if(!empty($data[0])){
                $model = new \common\models\Professions();
                $model->title = $data[0];
                $model->save();
            }
        }
        fclose($handle);

        //Генерируем слаг
        $p = new \yii\db\Query();
        $p = $p->from('professions')->all();
        foreach ($p as $item){
            $this->update('professions', ['slug'=>\common\classes\LocoTranslitFilter::cyrillicToLatin($item['title'], 100, true)], ['id'=>$item['id']]);
        }

        //Генерируем падежи
        foreach (\common\models\Professions::find()->all() as $item){
            $item->genitive = morphos\Russian\NounDeclension::getCase($item->title, 'родительный');
            $item->instrumental = morphos\Russian\NounDeclension::getCase($item->title, 'творительный');
            $item->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('professions');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200120_133946_create_table_professions cannot be reverted.\n";

        return false;
    }
    */
}
