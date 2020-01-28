<?php

use yii\db\Migration;

/**
 * Class m200128_110502_alter_soc_nets
 */
class m200128_110502_alter_soc_nets extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        echo "Resumes\n";
        echo "<=============================================================================>\n";
        /** @var \common\models\Resume $resume */
        foreach (\common\models\Resume::find()->each() as $resume) {
            if($resume->instagram){
                echo $resume->instagram . " -> ";
                if(strpos($resume->instagram, "https://instagram.com/")!==false){
                    $resume->instagram = str_replace("https://instagram.com/", '', $resume->instagram);
                    echo $resume->instagram;
                } elseif(strpos($resume->instagram, "https://www.instagram.com/")!==false) {
                    $resume->instagram = str_replace("https://www.instagram.com/", '', $resume->instagram);
                    echo $resume->instagram;
                } else {
                    $resume->instagram = null;
                    echo "empty";
                }
                echo "      Instagram \n";
            }

            if($resume->facebook) {
                echo $resume->facebook . " -> ";
                if(strpos($resume->facebook, "https://facebook.com/")!==false){
                    $resume->facebook = str_replace("https://facebook.com/", '', $resume->facebook);
                    echo $resume->facebook;
                } elseif(strpos($resume->facebook, "https://www.facebook.com/")!==false) {
                    $resume->facebook = str_replace("https://www.facebook.com/", '', $resume->facebook);
                    echo $resume->facebook;
                } else {
                    $resume->facebook = null;
                    echo "empty";
                }
                echo "      Facebook \n";
            }

            if($resume->vk) {
                echo $resume->vk . " -> ";
                if(strpos($resume->vk, "https://vk.com/")!==false){
                    $resume->vk = str_replace("https://vk.com/", '', $resume->vk);
                    echo $resume->vk;
                } elseif(strpos($resume->vk, "https://www.vk.com/")!==false) {
                    $resume->vk = str_replace("https://www.vk.com/", '', $resume->vk);
                    echo $resume->vk;
                } else {
                    $resume->vk = null;
                    echo "empty";
                }
                echo "      VK \n";
            }

            $resume->save();
        }


        echo "Companies\n";
        echo "<=============================================================================>\n";
        /** @var \common\models\Company $company */
        foreach (\common\models\Company::find()->each() as $company) {
            if($company->instagram) {
                echo $company->instagram . " -> ";
                if(strpos($company->instagram, "https://instagram.com/")!==false){
                    $company->instagram = str_replace("https://instagram.com/", '', $company->instagram);
                    echo $company->instagram;
                } elseif(strpos($company->instagram, "https://www.instagram.com/")!==false) {
                    $company->instagram = str_replace("https://www.instagram.com/", '', $company->instagram);
                    echo $company->instagram;
                } else {
                    $company->instagram = null;
                    echo "empty";
                }
                echo "      Instagram \n";
            }

            if($company->facebook) {
                echo $company->facebook . " -> ";
                if(strpos($company->facebook, "https://facebook.com/")!==false){
                    $company->facebook = str_replace("https://facebook.com/", '', $company->facebook);
                    echo $company->facebook;
                } elseif(strpos($company->facebook, "https://www.facebook.com/")!==false) {
                    $company->facebook = str_replace("https://www.facebook.com/", '', $company->facebook);
                    echo $company->facebook;
                } else {
                    $company->facebook = null;
                    echo "empty";
                }
                echo "      Facebook \n";
            }

            if($company->vk) {
                echo $company->vk . " -> ";
                if(strpos($company->vk, "https://vk.com/")!==false){
                    $company->vk = str_replace("https://vk.com/", '', $company->vk);
                    echo $company->vk;
                } elseif(strpos($company->vk, "https://www.vk.com/")!==false) {
                    $company->vk = str_replace("https://www.vk.com/", '', $company->vk);
                    echo $company->vk;
                } else {
                    $company->vk = null;
                    echo "empty";
                }
                echo "      VK \n";
            }

            $company->save();
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
