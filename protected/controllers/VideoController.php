<?php

class VideoController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	// Uncomment the following methods and override them if needed
	public function filters()
	{
		return array(
			'accessControl',
		);

	}

	public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('record', 'video', 'AvcSettings', 'AvcQuality', 'UploadImage',
                	'thankyou', 'savevideo', 'AvcTranslation', 'encode' ),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
				'users'=>array('*'),
			),
        );
    }

	public function actionRecord() {
		$recordId = uniqid('wordpress_');
		$userId = Yii::app()->user->getName();
		$bandwidth = isset($GET['bandwidth']) ? $GET['bandwidth'] : '0';
		$quality = isset($GET['quality']) ? $GET['quality'] : '0';
		$this->render('record',array('recordId'=>$recordId, 'userId'=>$userId, 'bandwidth'=>$bandwidth, 'quality'=>$quality));
	}

	public function actionThankYou() {
		$this->render('thankyou');
	}

	public function actionVideos() {
		$this->render('index');
	}

	public function actionSaveVideo() {
		$video = new Videos();
		if (isset($_GET["streamName"])) { $video->name = $_GET["streamName"]; }
		if (isset($_GET["streamDuration"])) { $video->duration = $_GET["streamDuration"]; }
		if (isset($_GET["userId"])) { $video->userId = $_GET["userId"]; }
		if (isset($_GET["recorderId"])) { $video->recorderId = $_GET["recorderId"]; }
		if ($video->save()) {
			// Ffmpeg script
			exec('ffmpeg -i '.$video->name.'.flv -an -sameq -b:v 320k -y '.$video->name.'_tmp.mp4 && qt-faststart '.$video->name.'_tmp.mp4 '.$video->name.'.mp4');
			// Success
			echo "save=ok";
		} else {
			echo "save=failed";
		}
	}

	public function actionEncode() {
		if (isset($_GET["streamName"])) {
echo 'processing...<br/>';
			$stream_path = '../rawvideo/';
			$stream_name = $_GET["streamName"];
			$output = shell_exec('ffmpeg -i '.$stream_path.$stream_name.'.flv -an -sameq -b:v 320k -y '.$stream_path.$stream_name.'_tmp.mp4');
			$output2 = shell_exec('qt-faststart '.$stream_path.$stream_name.'_tmp.mp4 '.$stream_path.$stream_name.'.mp4 && rm '.$stream_path.$stream_name.'_tmp.mp4');
			echo "<pre>$output$output2</pre>";

$output = shell_exec("ls -lh $stream_path | egrep $stream_name");
echo "<pre>$output</pre>";

		} else {
			echo 'Error: no stream name!';
		}
	}


	public function actionUploadImage() {

		//videorecorder.swf sends the name of the stream via the GET variable named "name"
		$photoName = $_GET["name"];

		//the recorderId var contais the value of the recorderId fash var sent from VideoRecorder.html to the swf file
		$recorderId= $_GET["recorderId"];

		//we make the snapshots folder if it does not exists
		if(!is_dir("snapshots")){
			$res = mkdir("snapshots",0777);
		}

		//it also sends the snapshot JPG info via POST
		try {
			if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
				$image = fopen("snapshots/".$photoName,"wb");
				fwrite($image , $GLOBALS["HTTP_RAW_POST_DATA"] );
				fclose($image);
			}
			echo "save=ok";
		} catch(Exception $e) {
			echo "save=failed";
		}
	}

	public function actionAvcSettings() {
		$config['connectionstring']='rtmp://elmo.otterlabs.com/hdfvr/_definst_';
		if(isset($_GET["recorderId"])){
			$recorderId = $_GET["recorderId"];
		}
		$config['languagefile']='translations/en.xml';
		$config['qualityurl']='avcQuality';
		$config['maxRecordingTime']=300;
		$config['userId']=Yii::app()->user->getName();
		$config['outgoingBuffer']=60;
		$config['playbackBuffer']= 1;
		$config['autoPlay']='false';
		$config['deleteUnsavedFlv'] = 'true';
		$config['hideSaveButton']=0;
		$config["onSaveSuccessURL"]="thankyou";
		$config["snapshotSec"] = 5;
		$config["snapshotEnable"] = "true";
		$config["minRecordTime"] = 5;
		$config["backgroundColor"] = 0x990000;
		$config["menuColor"] = 0x333333;
		$config["radiusCorner"] = 4;
		$config["showFps"] = 'true';
		$config["recordAgain"] =  'true';
		$config["useUserId"] =  'false';
		$config["streamPrefix"] = "dvtv";
		$config["streamName"] = "";
		$config["disableAudio"] = 'false';
		$config["chmodStreams"] = "";
		$config["padding"]=2;
		$config["countdownTimer"]="false";
		$config["overlayPath"]="../images/deafvideo_logo.png";
		$config["overlayPosition"]="tr";
		$config["loopbackMic"]="false";
		$config["showMenu"]="true";
		$config["showTimer"] = 'true';
		$config["showSoundBar"] = 'false';

		echo "donot=removethis";
		foreach ($config as $key => $value){
			echo '&'.$key.'='.$value;
		}
	}

	public function actionAvcQuality() {

		if (Yii::app()->user->getName() == 'admin') {
			$config['nm'] = '320x240@25fps';
			$config['bytes'] = '0';
			$config['quality'] = '90';
			$config['fps'] = '30';
			$config['kfps'] = '15';
			$config['width'] = '320';
			$config['height'] = '240';
			$config['snd'] = '8';
			$config['sndsilencelevel'] = '0';
			$config['vcodec'] = 'h264_w';
		} else {
			$config['nm'] = '320x240@25fps';
			$config['bytes'] = '50000';
			$config['quality'] = '90';
			$config['fps'] = '25';
			$config['kfps'] = '15';
			$config['width'] = '320';
			$config['height'] = '240';
			$config['snd'] = '8';
			$config['sndsilencelevel'] = '0';
			$config['vcodec'] = 'h264_w';
		}
		$this->layout = 'xml';
		$this->render('videoquality', array('config' => $config));
	}

	public function actionAvcTranslation() {
		$this->layout = 'xml';
		$this->render('translation');
	}
}
